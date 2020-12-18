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
        foreach ($rows as $key => $row) {
            if ($key == 0 ||
                $row[2] === null
            ) {
                continue;
            }

            $checkexist = DataPoint::where('data_point', 'LIKE', '%' . preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[0])) . '%')
                ->where('entity', 'LIKE', '%' . preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[10])) . '%')
                ->where('parent_entity', 'LIKE', '%' . preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[11])) . '%')
                ->exists();

            if (!$checkexist) {

                $input = [
                    'data_point' => preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[0])),
                    'entity' => preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[10])),
                    'parent_entity' => preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[11])),
                    'dw_server' => $row[4],
                    'dw_database' => $row[5],
                    'table_name' => $row[6],
                    'dw_field_name' => $row[7],
                    'data_type' => $row[8],
                    'source' => $row[9],
                    'read_write' => $row[12],
                    'definition_stakeholder' => trim($row[13]),
                    'ongoing_definition_owner' => trim($row[14]),
                    'owner' => $row[15],
                    'responsible_role' => $row[16],
                ];
                $dataPoint = DataPoint::create($input);
                    DataDefinition::create([
                        'data_point_id' => $dataPoint->id,
                        'entity' => preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[10])),
                        'parent_entity' => preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[11])),
                        'data_point_definition' => trim($row[1]),
                        'look_up_values' => $row[2],
                        'look_up_value_definitions' => $row[3],
                    ]);
            } else {
                $checkexist = DataPoint::where('data_point', 'LIKE', '%' . preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[0])) . '%')
                    ->where('entity', 'LIKE', '%' . preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[10])) . '%')
                    ->where('parent_entity', 'LIKE', '%' . preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[11])) . '%')
                    ->first();
                $checkDatadefinitionexist = DataDefinition::where('data_point_id', $checkexist->id)
                    ->where('entity', 'LIKE', '%' . preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[10])) . '%')
                    ->where('parent_entity', 'LIKE', '%' . preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[11])) . '%')
                    ->where('look_up_values', 'LIKE', '%' . preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[2])) . '%')
                    ->exists();

                if (!$checkDatadefinitionexist) {
                    DataDefinition::create([
                        'data_point_id' => $checkexist->id,
                        'entity' => preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[10])),
                        'parent_entity' => preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[11])),
                        'data_point_definition' => $row[1],
                        'look_up_values' => preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', trim($row[2])),
                        'look_up_value_definitions' => $row[3],
                    ]);
                }
            }
        }
    }
}
