@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Aluno</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{ route('student.index') }}"
                                                         class="text-decoration-none">Alunos</a></li>
                <li class="breadcrumb-item mb-3 mt-3 active">aluno</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Editar</span>
                </div>
                <div>
                    <a href="{{ route('student.show', ['student' => $student->id]) }}" class="btn btn-secondary btn-sm">Visualizar</a>
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <form class="row g-3" action="{{ route('student.update', ['student' => $student->id]) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="user_id" class="form-label">Aluno</label>
                        <select name="user_id" class="form-select">
                            <option value="">Selecione</option>
                            @foreach($users as $user)
                                <option
                                    {{ $user->id == $student->user_id ? "selected" : "" }} value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="course_id" class="form-label">Curso</label>
                        <select name="course_id" class="form-select">
                            <option value="">Selecione</option>
                            @foreach($courses as $course)
                                <option
                                    {{ $course->id == $student->course_id ? "selected" : "" }} value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
