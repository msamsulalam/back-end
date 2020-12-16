<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataPoint extends Model
{
    protected $fillable = ['data_point','entity','parent_entity','owner',
        'responsible_role','dw_server','dw_database','table_name',
        'dw_field_name','data_type','source','read_write','definition_stakeholder','ongoing_definition_owner'];

    public function data_definitions(){
        return $this->hasMany(DataDefinition::class, 'data_point_id', 'id');
    }

}
