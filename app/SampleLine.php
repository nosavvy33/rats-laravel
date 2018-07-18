<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleLine extends Model
{
    protected $table="sample_lines";
    
    protected $primaryKey = "id";
    
    public $timestamps = false;

}
