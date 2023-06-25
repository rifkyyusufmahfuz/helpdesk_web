@extends('layouts.main')

@section('contents')
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Status Permintaan</h6>
                        {{-- <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie">
                            @if (!empty($statusPermintaanData))
                                <canvas id="status-permintaan-chart"></canvas>
                            @else
                                <p class="text-center">Belum ada permintaan</p>
                            @endif

                        </div>
                        <div class="mt-2 text-center small">
                            <span class="mr-2 small">
                                <i class="fas fa-circle text-danger"></i> Pending
                            </span>
                            <span class="mr-2 small">
                                <i class="fas fa-circle text-warning"></i> Ditinjau
                            </span>
                            <span class="mr-2 small">
                                <i class="fas fa-circle text-info"></i> Menunggu unit
                            </span>
                            <span class="mr-2 small">
                                <i class="fas fa-circle text-primary"></i> Diproses
                            </span>
                            <span class="mr-2 small">
                                <i class="fas fa-circle text-secondary"></i> Unit siap diambil
                            </span>
                            <span class="mr-2 small">
                                <i class="fas fa-circle text-success"></i> Permintaan selesai
                            </span>
                            <span class="mr-2 small">
                                <i class="fas fa-circle text-dark"></i> Ditolak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <di v class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Total Permintaan</h6>
                        {{-- <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-2">
                            @if (!empty($permintaanData))
                                <canvas id="permintaan-chart"></canvas>
                            @else
                                <p class="text-center">Belum ada permintaan</p>
                            @endif

                        </div>
                        <div class=" mt-2 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Hardware
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> Software
                            </span>
                            {{-- <span class="mr-2">
                                <i class="fas fa-circle text-info"></i> Referral
                            </span> --}}
                        </div>
                    </div>
                </div>
            </di>
        </div>
    </div>

    {{-- untuk permintaan software --}}
    <script>
        var permintaanData = {!! $permintaanData !!};

        var statusLabels = ['Hardware', 'Software'];
        var jumlahPermintaan = [];

        for (var i = 0; i < permintaanData.length; i++) {
            // statusLabels.push(permintaanData[i].status_permintaan);
            jumlahPermintaan.push(permintaanData[i].jumlah_permintaan);
        }

        var permintaanChartCanvas = document.getElementById('permintaan-chart').getContext('2d');
        var permintaanChart = new Chart(permintaanChartCanvas, {
            type: 'doughnut',
            data: {
                labels: ["Hardware", "Software"],
                datasets: [{
                    data: jumlahPermintaan,
                    backgroundColor: ['#1cc88a', '#4e73df']
                }]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            }
        });
    </script>


    {{-- untuk permintaan status --}}
    <script>
        var statusPermintaanData = {!! $statusPermintaanData !!};

        var statusPermintaanLabels = ['Pending', 'Ditinjau', 'Menunggu unit', 'Diproses', 'Proses selesai',
            'Permintaan selesai', 'Ditolak'
        ];
        var jumlahPermintaanHardware = [];

        for (var i = 0; i < statusPermintaanData.length; i++) {
            // statusPermintaanLabels.push(statusPermintaanData[i].status_permintaan);
            jumlahPermintaanHardware.push(statusPermintaanData[i].jumlah_permintaan);
        }

        var statusPermintaanChartCanvas = document.getElementById('status-permintaan-chart').getContext('2d');
        var statusPermintaanChart = new Chart(statusPermintaanChartCanvas, {
            type: 'pie',
            data: {
                labels: statusPermintaanLabels,
                datasets: [{
                    data: jumlahPermintaanHardware,
                    backgroundColor: ['#e74a3b', '#f6c23e', '#36b9cc', '#4e73df', '#858796', '#1cc88a',
                        '#5a5c69'
                    ] // Sesuaikan warna sesuai dengan jumlah status_permintaan yang ada
                }]
            },
            options: {
                maintainAspectRatio: false,
                // Opsi konfigurasi lainnya
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
            }
        });
    </script>
@endsection
