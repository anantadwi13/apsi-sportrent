<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "kategori";

    public function ruangan(){
        return $this->hasMany('App\Lapangan', 'id_kategori');
    }
}
