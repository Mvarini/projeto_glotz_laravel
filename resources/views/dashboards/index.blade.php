@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Dashboard</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3 active">Dashboard</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">Professores</div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>{{ $teacher }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">Cursos</div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>{{ $course }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary text-white mb-4 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">Papel Super Admin</div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>{{ $superAdminCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary text-white mb-4 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">Papel Admin</div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>{{ $adminCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <section>
                    <div class="shadow mb-4">
                        <h5 class="text-center pt-2"> Alunos</h5>
                        <canvas id="myChart" width="400" height="250" class="p-4"></canvas>
                    </div>
                </section>
            </div>
            <div class="col-xl-6 col-md-6">
                <section>
                    <div class="shadow mb-4">
                        <h5 class="text-center pt-2"> Cursos </h5>
                        <canvas id="myChart2" width="400" height="250" class="p-4"></canvas>
                    </div>
                </section>
            </div>

        </div>
    </div>
@endsection

@push('graficos')
    <script>
        /* Gráfico 01 */
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [{{ $studentYear }}],
                datasets: [{
                    label: [{!! $studentLabel !!}],
                    data: [{{ $studentTotal }}],
                    backgroundColor: [
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                }
            }
        });

        /* Gráfico 02 */
        var ctx = document.getElementById('myChart2');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [{!! $courseLabel !!}],
                datasets: [{
                    label: 'Visitas',
                    data: [{{ $courseTotal }}],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 159, 64)',
                        'rgba(0,0,255)',
                        'rgba(176,196,222)',
                        'rgba(28,28,28)',
                    ]
                }]
            }
        });
    </script>
@endpush
