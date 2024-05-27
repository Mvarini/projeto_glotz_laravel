@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Aluno</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{ route('student.index') }}"
                                                         class="text-decoration-none">Alunos</a></li>
                <li class="breadcrumb-item mb-3 mt-3 active">Aluno</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Cadastrar</span>
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <form class="row g-3" action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="col-md-6">
                        <label for="user_id" class="form-label">Aluno</label>
                        <select name="user_id" class="form-select">
                            <option value="">Selecione</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="course_id" class="form-label">Curso</label>
                        <select name="course_id" class="form-select">
                            <option value="">Selecione</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>

                </form>
@endsection
