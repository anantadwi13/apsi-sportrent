<?php

namespace App\Http\Controllers\Auth;

use App\Kecamatan;
use App\KotaKab;
use App\Peminjam;
use App\Provinsi;
use App\User;
use App\Http\Controllers\Controller;
use App\Vendor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationFormPenyedia()
    {
        $provinsi = Provinsi::all();
        $kota = old('provinsi')? KotaKab::whereIdProvinsi(old('provinsi'))->get() : [];
        $kecamatan = old('kota')? Kecamatan::whereIdKota(old('kota'))->get() : [];
        return view('auth.register_penyedia')->with(compact('provinsi','kota','kecamatan'));
    }

    public function showRegistrationFormPeminjam()
    {
        $provinsi = Provinsi::all();
        $kota = old('provinsi')? KotaKab::whereIdProvinsi(old('provinsi'))->get() : [];
        $kecamatan = old('kota')? Kecamatan::whereIdKota(old('kota'))->get() : [];
        return view('auth.register_peminjam')->with(compact('provinsi','kota','kecamatan'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if ($user->status == User::STATUS_ACTIVE)
            $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'tipe_akun' => ['bail','required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'username' => ['required', 'string', 'min:4', 'max:255', 'unique:users,username'],
            'tgl_lahir' => ['required_if:tipe_akun,'.User::TYPE_PEMINJAM, 'date'],
            'tempat_lahir' => ['required_if:tipe_akun,'.User::TYPE_PEMINJAM, 'string'],
            'jenis_kel' => ['required_if:tipe_akun,'.User::TYPE_PEMINJAM, 'boolean'],
            'no_hp' => ['required', 'numeric', 'digits_between:10,16'],
            'nama_pemilik' => ['required_if:tipe_akun,'.User::TYPE_VENDOR, 'string', 'max:255'],
            'no_hp_pemilik' => ['required_if:tipe_akun,'.User::TYPE_VENDOR, 'digits_between:10,15'],
            'npwp_pemilik' => ['required_if:tipe_akun,'.User::TYPE_VENDOR, 'digits_between:12,20'],
            'ktp_pemilik' => ['required_if:tipe_akun,'.User::TYPE_VENDOR, 'digits:16'],
            'alamat' => ['required_if:tipe_akun,'.User::TYPE_VENDOR,  'string', 'min:4', 'max:255'],
            'provinsi' => ['required_if:tipe_akun,'.User::TYPE_VENDOR,  'exists:provinsi,id'],
            'kota' => ['required_if:tipe_akun,'.User::TYPE_VENDOR, 'exists:kota_kab,id'],
            'kecamatan' => ['required_if:tipe_akun,'.User::TYPE_VENDOR, 'exists:kecamatan,id'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $status = User::STATUS_NONACTIVE;
        if ($data['tipe_akun']!= User::TYPE_VENDOR) {
            $status = User::STATUS_ACTIVE;
            $data['tipe_akun'] = User::TYPE_PEMINJAM;
        }
        else
            $data['no_identitas'] = null;

        try {
            DB::beginTransaction();
            $user = User::create([
                'nama' => $data['name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'tipe_akun' => $data['tipe_akun'],
                'nohp' => $data['no_hp'],
                'status' => $status,
                'password' => Hash::make($data['password']),
            ]);
            switch ($user->tipe_akun){
                case User::TYPE_PEMINJAM:
                    Peminjam::create([
                        'id_user' => $user->id,
                        'tgl_lahir' => $data['tgl_lahir'],
                        'tempat_lahir' => $data['tempat_lahir'],
                        'jenis_kel' => $data['jenis_kel']
                    ]);
                    break;
                case User::TYPE_VENDOR:
                    Vendor::create([
                        'id_user' => $user->id,
                        'nama_pemilik' => $data['nama_pemilik'],
                        'no_hp_pemilik' => $data['no_hp_pemilik'],
                        'npwp_pemilik' => $data['npwp_pemilik'],
                        'ktp_pemilik' => $data['ktp_pemilik'],
                        'alamat_jalan' => $data['alamat'],
                        'alamat_kecamatan' => $data['kecamatan'],
                    ]);
                    break;
            }
            DB::commit();
            return $user;
        }
        catch (\Exception $e){
            return null;
        }
    }
}
