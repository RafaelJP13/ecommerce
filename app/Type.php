<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';
    
    static function list(){

        return Type::all('id','name');

    }

}
