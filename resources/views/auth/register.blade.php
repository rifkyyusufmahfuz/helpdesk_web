<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KCI IT Helpdesk - Registrasi</title>
    <link rel="icon" href="{!! asset('img/Logo_KAI_Commuter_kecil.png') !!}" />

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/halamanregistrasi.css') }}" rel="stylesheet">

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body background="{{ asset('img/bg-login.webp') }}" style="background-repeat: no-repeat;background-size: cover;">
    <section>
        <div class="container py-4">
            <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 bg-white">
                            <div class="p-5">
                                <h4 class="mb-2" style="color: #4835d4;">Registrasi User</h4>
                                <hr>
                                <form action="/register/registrasi_akun" method="POST">
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
                                        <input list="stasiun_list" class="form-control form-control-lg"
                                            id="lokasi" name="lokasi">
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

        <?php $listError = ['email', 'password', 'konfirmasi_password', 'nip', 'nama', 'bagian', 'jabatan', 'lokasi']; ?>


    </section>
</body>

<footer>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    @include('sweetalert::alert')
</footer>

</html>
