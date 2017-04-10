<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    protected $table='evidences'; 
    protected $primaryKey='evidence_id';
    public $timestamps = false;
    
    protected $fillable=['evidence_file'];
}
