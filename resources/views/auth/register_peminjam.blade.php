@extends('layouts.dashboard')

@section('title','Register Peminjam')

@section('action')
    <div class="float-sm-right">
        <a href="{{route('register')}}" class="btn btn-secondary">Back</a>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-8">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{$errors->first()}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register.act') }}">
                            @csrf
                            <input type="hidden" name="tipe_akun" value="{{\App\User::TYPE_PEMINJAM}}">

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nama</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="no_hp" class="col-md-4 col-form-label text-md-right">No HP / Telepon</label>
                                <div class="col-md-6">
                                    <input id="no_hp" type="number" class="form-control{{ $errors->has('no_hp') ? ' is-invalid' : '' }}" name="no_hp" value="{{ old('no_hp') }}" required>

                                    @if ($errors->has('no_hp'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('no_hp') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="deskripsi" class="col-md-4 col-form-label text-md-right">Tanggal Lahir</label>

                                <div class="col-md-6">
                                    <input type="text" autocomplete="off" class="form-control float-right datetimepicker datetimepicker-input" name="tgl_lahir" id="time_start" data-toggle="datetimepicker" data-target="#time_start">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tempat_lahir" class="col-md-4 col-form-label text-md-right">Tempat Lahir</label>

                                <div class="col-md-6">
                                    <input id="tempat_lahir" type="text" class="form-control" name="tempat_lahir" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jenis_kel" class="col-md-4 col-form-label text-md-right">Jenis Kelamin</label>
                                <div class="col-md-6">
                                    <select id="jenis_kel" class="form-control select2" name="jenis_kel">
                                        <option value="-1" disabled selected>-</option>
                                        <option value="0">Perempuan</option>
                                        <option value="1">Laki-laki</option>
                                    </select>

                                    @if ($errors->has('jenis_kel'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('jenis_kel') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/tempusdominus-bootstrap-4.min.css')}}" />
@endsection

@section('js')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <script>
        var p = $('#provinsi');
        var k = $('#kota');
        var c = $('#kecamatan');

        p.change(function () {
            emptyOption(k);
            emptyOption(c);
            update(true,p,k,c);
        });
        k.change(function () {
            emptyOption(c);
            update(false,p,k,c);
        });
        function emptyOption(select) {
            select.empty();
            select.append($("<option></option>").attr('value', '').text('-'));
        }
        function update(isP,p,k,c) {
            $.ajax({
                method: 'POST',
                async: true,
                url: '{{route('api.getDistrict')}}',
                data: {a: p.val(), b:k.val()},
            }).done(function (data) {
                if (data['success']) {
                    if(data['kota'].length>0 && isP) {
                        emptyOption(k);
                        $.each(data['kota'], function (key, value) {
                            console.log(value);
                            k.append($("<option></option>").attr('value', value['id']).text(value['nama']));
                        });
                    }
                    if(data['kec'].length>0) {
                        emptyOption(c);
                        $.each(data['kec'], function (key, value) {
                            console.log(value);
                            c.append($("<option></option>").attr('value', value['id']).text(value['nama']));
                        });
                    }
                }
            });
        }

        $(document).ready(function() {
            $('.select2').select2();
            $('.datetimepicker').datetimepicker({
                locale: 'id',
                format: 'YYYY-MM-DD',
                icons:{
                    date: 'far fa-calendar',
                }
            });
        });

        $('form').submit(function()
        {
            $("button[type='submit']", this)
                .text("Please Wait...")
                .attr('disabled', 'disabled');

            return true;
        });
    </script>
@endsection