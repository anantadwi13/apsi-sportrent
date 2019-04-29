<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = "reservasi";

    const STATUS_WAITING = 0;
    const STATUS_REJECTED = 1;
    const STATUS_ACCEPTED = 2;

    public function lapangan(){
        return $this->belongsTo('App\Lapangan', 'id_lapangan','id');
    }

    public function user(){
        return $this->belongsTo('App\User','id_user','id');
    }
}
