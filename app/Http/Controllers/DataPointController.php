<?php

namespace App\Http\Controllers;

use App\DataDefinition;
use App\DataPoint;
use App\Imports\DataPointsImport;
use App\Traits\ApiStatusTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataPointController extends Controller
{
    use ApiStatusTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function import()
    {
        Excel::import(new DataPointsImport, request()->file('data_file'));
        $response['message'] = "Data point has been imported successfully";
        return $this->successApiResponse($response);
    }

    public function getData()
    {
        $datapoint = DataPoint::withCount(['data_definitions'])->get();
        $data = DataDefinition::with(['point_data'])->get();
        $response['datapoint'] = $datapoint;
        $response['datapointdefinitions'] = $data;
        return $this->successApiResponse($response);
    }

    public function updateData(Request $request)
    {
        if($request->type === 1){
            $data = array();
            $datad = array();
            $data['data_point'] = $request->data_point;
            $data['dw_database'] = $request->dw_database;
            $data['dw_field_name'] = $request->dw_field_name;
            $data['dw_server'] = $request->dw_server;
            $data['entity'] = $datad['entity'] = $request->entity;
            $data['parent_entity']= $datad['parent_entity']  = $request->parent_entity;
            $data['owner'] = $request->owner;
            $data['responsible_role'] = $request->responsible_role;
            $data['table_name'] = $request->table_name;
            DataPoint::find($request->id)->update($data);
            DataDefinition::where('data_point_id', $request->id)->update($datad);
        }
        if($request->type === 2){
            $data = array();
            $datad = array();
            $data['data_point'] = $request->data_point;
            $data['dw_database'] = $request->dw_database;
            $data['dw_field_name'] = $request->dw_field_name;
            $data['dw_server'] = $request->dw_server;
            $data['entity'] = $datad['entity'] = $request->entity;
            $data['parent_entity']= $datad['parent_entity']  = $request->parent_entity;
            $datad['data_point_definition']  = $request->data_point_definition;
            $datad['look_up_values']  = $request->look_up_values;
            $datad['look_up_value_definitions']  = $request->look_up_value_definitions;
            $data['owner'] = $request->owner;
            $data['responsible_role'] = $request->responsible_role;
            $data['table_name'] = $request->table_name;
            $data['data_type'] = $request->data_type;
            $data['source'] = $request->source;
            $data['read_write'] = $request->read_write;
            $data['definition_stakeholder'] = $request->definition_stakeholder;
            $data['ongoing_definition_owner'] = $request->definition_stakeholder;
            DataDefinition::find($request->id)->update($datad);
            DataPoint::find($request->data_point_id)->update($data);
        }
        $response['message'] = "Data has been updated successfully";
        return $this->successApiResponse($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
