<?php

namespace App\Imports;

use App\DataDefinition;
use App\DataPoint;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class DataPointsImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new DataPoint([
            //
        ]);
    }

    public function collection(Collection $rows)
    {
//        dd($rows[1][0]);
        foreach ($rows as $key => $row) {
            if ($key == 0 ||
                $row[0] == 'Active' ||
                $row[0] == 'Provider' ||
                $row[0] == 'Service Type' ||
                $row[0] == 'Title' ||
                $row[0] == 'Value' ||
                $row[0] == 'Store') {
                continue;
            }


            $checkexist = DataPoint::where('data_point', 'LIKE', '%' . $row[0] . '%')
                ->where('entity', 'LIKE', '%' . $row[10] . '%')
                ->where('parent_entity', 'LIKE', '%' . $row[11] . '%')
                ->exists();

            if (!$checkexist) {

                $input = [
                    'data_point' => $row[0],
                    'entity' => $row[10],
                    'parent_entity' => $row[11],
                    'owner' => $row[15],
                    'responsible_role' => $row[16],
                    'dw_server' => $row[4],
                    'dw_database' => $row[5],
                    'table_name' => $row[6],
                    'dw_field_name' => $row[7],
                    'data_type' => $row[8],
                    'source' => $row[9],
                ];
                $dataPoint = DataPoint::create($input);

                DataDefinition::create([
                    'data_point_id' => $dataPoint->id,
                    'entity' => $row[10],
                    'parent_entity' => $row[11],
                    'data_point_definition' => $row[1],
                    'look_up_values' => $row[2],
                    'look_up_value_definitions' => $row[3],
                ]);
            } else {
                $checkexist = DataPoint::where('data_point', 'LIKE', '%' . $row[0] . '%')
                    ->where('entity', 'LIKE', '%' . $row[10] . '%')
                    ->where('parent_entity', 'LIKE', '%' . $row[11] . '%')
                    ->first();
                $checkDatadefinitionexist = DataDefinition::where('data_point_id', $checkexist->id)
                    ->where('entity', 'LIKE', '%' . $row[10] . '%')
                    ->where('parent_entity', 'LIKE', '%' . trim($row[11]) . '%')
                    ->where('look_up_values', 'LIKE', '%' . $row[2] . '%')
                    ->exists();
                if (!$checkDatadefinitionexist) {
                    DataDefinition::create([
                        'data_point_id' => $checkexist->id,
                        'entity' => $row[10],
                        'parent_entity' => $row[11],
                        'data_point_definition' => $row[1],
                        'look_up_values' => $row[2],
                        'look_up_value_definitions' => $row[3],
                    ]);
                }

            }


//
//            Contact::create([
//                'institution' => $row[3],
//                'type' => $row[4],
//                'address' => $row[5],
//            ]);
        }
//        dd();
    }
}
