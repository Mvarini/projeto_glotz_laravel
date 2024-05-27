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
                    <div class="card-body d-flex justify-content-center">Qtde Professores</div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>{{ $teacher }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">Qtde Cursos</div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>{{ $course }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">Alunos com cursos</div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>{{ $student }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">Cursos com aluno</div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>{{ $courseStudentCount }}</div>
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

            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary text-white mb-4 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">Papel Professores</div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>{{ $teacherCount }}</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary text-white mb-4 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">Papel Aluno</div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>{{ $studentCount }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
