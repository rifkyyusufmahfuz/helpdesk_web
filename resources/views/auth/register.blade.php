{{-- <section>
    <div class="container py-4">
        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-6 bg-white">
                        <div class="p-5">
                            <h4 class="mb-2" style="color: #4835d4;">Registrasi User</h4>
                            <hr>
                            <form action="/registrasi/registrasi_akun" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-2 pb-2">
                                        <div class="form-outline">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="text" id="email" name="email"
                                                class="form-control form-control-lg" />
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2 pb-2">
                                        <div class="form-outline">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" name="password"
                                                class="form-control form-control-lg" />
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2 pb-2">
                                        <div class="form-outline">
                                            <label class="form-label" for="konfirmasipassword">Konfirmasi
                                                Password</label>
                                            <input type="password" id="konfirmasipassword" name="konfirmasipassword"
                                                class="form-control form-control-lg" />
                                            @error('konfirmasipassword')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="/">Sudah punya akun? Login sekarang!</a>
                                </div>
                        </div>
                    </div>

                    <div class="col-lg-6 bg-indigo text-white">
                        <div class="p-5">
                            <h4 class="mb-2">Data Pegawai</h4>
                            <hr>
                            <div class="mb-2 pb-2">
                                <div class="form-outline form-white">
                                    <label class="form-label" for="nip">NIP</label>
                                    <input type="text" id="nip" name="nip"
                                        class="form-control form-control-lg" />
                                    @error('nip')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-2 pb-2">
                                <div class="form-outline form-white">
                                    <label class="form-label" for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama"
                                        class="form-control form-control-lg" />
                                    @error('nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-2 pb-2">
                                <div class="form-outline form-white">
                                    <label class="form-label" for="lokasi">Lokasi</label>
                                    <input list="stasiun_list" class="form-control form-control-lg" id="lokasi"
                                        name="lokasi">
                                    <datalist id="stasiun_list">
                                        @foreach ($data_stasiun as $stasiun)
                                            <option value="{{ $stasiun->nama_stasiun }}"></option>
                                        @endforeach
                                    </datalist>
                                    @error('lokasi')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2 pb-2">
                                    <div class="form-outline form-white">
                                        <label class="form-label" for="bagian">Bagian</label>
                                        <input type="text" id="bagian" name="bagian"
                                            class="form-control form-control-lg" />
                                        @error('bagian')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6 mb-2 pb-2">
                                    <div class="form-outline form-white">
                                        <label class="form-label" for="jabatan">Jabatan</label>
                                        <input type="text" id="jabatan" name="jabatan"
                                            class="form-control form-control-lg" />
                                        @error('jabatan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end mr-1">
                                <button type="submit" class="btn btn-light"
                                    data-mdb-ripple-color="dark">Register</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section> --}}


@extends('auth.layout')
@section('content')
    <div class="container register mt-2 mb-1 col-md-8">
        <div class="row justify-content-center">
            <div class="card col-md-12 px-4 pt-1 pb-2">
                <div class="pb-2">

                    <div class="card-header bg-white">
                        <div class="row d-flex flex-column m-0">
                            <div class="d-flex">
                                <img class=" text-right" src="{{ asset('img/logo_it_helpdesk.png') }}" alt=""
                                    width="200px" height="auto">
                            </div>
                            <div class="d-flex">
                                <h6 class="register-heading">Form Registrasi Akun Pegawai</h6>
                            </div>
                        </div>
                    </div>
                    <form action="/registrasi/registrasi_akun" method="POST">
                        @csrf
                        <div class="row card-body">
                            <div class="col-md-7">
                                <span>Data Pegawai</span>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-sm-5">
                                        <label for="nip">NIPP<span class="text-danger">*</span></label>
                                        <input name="nip" id="nip" type="text" class="form-control"
                                            maxlength="5" />
                                    </div>
                                    <div class="form-group col-sm-7">
                                        <label for="nama">Nama</label>
                                        <input name="nama" id="nama" type="text" class="form-control" />
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-5">
                                        <label for="bagian">Unit/Bagian</label>
                                        <input name="bagian" id="bagian" type="text" class="form-control"/>
                                    </div>

                                    <div class="form-group col-sm-7">
                                        <label for="jabatan">Jabatan</label>
                                        <input name="jabatan" id="jabatan" type="text" class="form-control"/>
                                    </div>
                                </div>

                                {{-- <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" class="form-control" placeholder="Lokasi" />
                            </div> --}}

                                <div class="form-group">
                                    <label class="form-label" for="lokasi">Lokasi</label>
                                    <input list="stasiun_list" class="form-control" id="lokasi" name="lokasi" placeholder="Pilih lokasi">
                                    <datalist id="stasiun_list">
                                        @foreach ($data_stasiun as $stasiun)
                                            <option value="{{ $stasiun->nama_stasiun }}"></option>
                                        @endforeach
                                    </datalist>
                                    @error('lokasi')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <span class=" text-danger small">*NIPP harus terdaftar sebagai pegawai PT KCI</span>
                            </div>

                            <div class="col-md-5">
                                <span>Data Akun</span>
                                <hr>
                                <div class="form-group">
                                    <label for="username">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"/>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input name="password" id="password" type="password" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label for="konfirmasi_password">Konfirmasi Password</label>
                                    <input name="konfirmasi_password" id="konfirmasi_password" type="password"
                                        class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white">
                            <input type="submit" class="btn btn-block btn-primary" value="Registrasi" />
                        </div>

                        <div class="text-center">
                            <span class="text-center">Sudah punya akun? <a href="/">Login</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
