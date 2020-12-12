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
        $response['msg'] = "Data point has been imported successfully";
        return $this->successApiResponse($response);
    }

    public function getData()
    {
        $datapoint = DataPoint::withCount(['data_definitions'])->get();
        $data = DataDefinition::/*with(['point_data'=>function($query){
            $query->select('data_point');
        }])->*/get();
        $response['datapoint'] = $datapoint;
        $response['datapointdefinitions'] = $data;
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
