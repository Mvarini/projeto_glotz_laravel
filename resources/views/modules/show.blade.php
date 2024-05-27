@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Módulo</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{route('course.index')}}" class="text-decoration-none">Cursos</a>
                </li>
                <li class="breadcrumb-item mb-3 mt-3"><a
                        href="{{route('module.index', ['course' => $module->course_id])}}" class="text-decoration-none">Módulos</a>
                </li>
                <li class="breadcrumb-item mb-3 mt-3 active">Módulo</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Visualizar</span>
                </div>
                <div class="d-flex">
                    <a href="{{ route('module.edit', ['module' => $module->id]) }}" class="btn btn-primary btn-sm me-2">Editar</a>


                    <form id="formDelete{{ $module->id }}" action="{{ route('module.destroy', ['module' => $module->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm btnDelete" data-delete-id="{{ $module->id }}">Excluir
                        </button>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Curso:</dt>
                    <dd class="col-sm-9">{{ $module->course->name}}</dd>

                    <dt class="col-sm-3">Módulo:</dt>
                    <dd class="col-sm-9">{{ $module->name }}</dd>

                    <dt class="col-sm-3">Duração:</dt>
                    <dd class="col-sm-9">{{ $module->hour }}</dd>

                    <dt class="col-sm-3">Descrição:</dt>
                    <dd class="col-sm-9">{{ $module->description }}</dd>

                    <dt class="col-sm-3">Cadastrado:</dt>
                    <dd class="col-sm-9">{{ $module->created_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Editado:</dt>
                    <dd class="col-sm-9">{{ $module->updated_at->format('d/m/Y H:i:s') }}</dd>
                </dl>
            </div>
        </div>
    </div>

@endsection
