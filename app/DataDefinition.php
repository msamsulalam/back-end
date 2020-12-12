<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataDefinition extends Model
{
    protected $fillable = ['data_point_id','entity','parent_entity','data_point_definition',
    'look_up_values','look_up_value_definitions'];

    public function point_data(){
        return $this->hasOne(DataPoint::class, 'id', 'data_point_id');
    }

}
