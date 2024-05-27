@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Aluno</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{route('student.index')}}" class="text-decoration-none">Alunos</a>
                </li>
                <li class="breadcrumb-item mb-3 mt-3 active">Aluno</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Visualizar</span>
                </div>
                <div class="d-flex">
                    @can('edit-student')
                        <a href="{{ route('student.edit', ['student' => $student->id]) }}"
                           class="btn btn-primary btn-sm me-2">Editar</a>
                    @endcan

                    @can('destroy-student')
                        <form id="formDelete{{ $student->id }}" action="{{ route('student.destroy', ['student' => $student->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btnDelete" data-delete-id="{{ $student->id }}">Excluir
                            </button>
                        </form>
                    @endcan

                </div>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Aluno:</dt>
                    <dd class="col-sm-9">{{ $student->user->name}}</dd>

                    <dt class="col-sm-3">Curso:</dt>
                    <dd class="col-sm-9">{{ $student->course->name }}</dd>

                    <dt class="col-sm-3">Cadastrado:</dt>
                    <dd class="col-sm-9">{{ $student->created_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Editado:</dt>
                    <dd class="col-sm-9">{{ $student->updated_at->format('d/m/Y H:i:s') }}</dd>
                </dl>
            </div>
        </div>
    </div>

@endsection
