<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    const TYPE_PEMINJAM = 1;
    const TYPE_VENDOR = 2;
    const TYPE_CS = 90;
    const TYPE_ADMIN = 99;

    const STATUS_ACTIVE = 2;
    const STATUS_NONACTIVE = 1;
    const STATUS_BANNED = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'username', 'email', 'tipe_akun','nohp','password','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ruangan(){
        return $this->hasMany('App\Lapangan', 'id_user', 'id');
    }

    public function reservasi(){
        return $this->hasMany('App\Reservasi', 'id_user', 'id');
    }

    public function report(){
        return $this->hasMany('App\Report', 'id_pelapor', 'id');
    }

    public function reported(){
        return $this->hasMany('App\Report', 'id_dilapor', 'id');
    }

    public function data_admin(){
        return $this->hasOne('App\Admin', 'id_user', 'id');
    }

    public function data_vendor(){
        return $this->hasOne('App\Vendor', 'id_user', 'id');
    }

    public function data_peminjam(){
        return $this->hasOne('App\Peminjam', 'id_user', 'id');
    }

    public function data_customer_service(){
        return $this->hasOne('App\CustomerService', 'id_user', 'id');
    }
}
