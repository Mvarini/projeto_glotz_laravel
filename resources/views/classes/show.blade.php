@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3">
                @if($dataFirst)
                    {{ $dataFirst->module->course->name }}
                @endif
            </h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a
                        href="{{ route('course.index') }}"
                        class="text-decoration-none">Cursos</a></li>
                <li class="breadcrumb-item mb-3 mt-3"><a
                        href="{{ route('module.index', ['course' => $dataFirst->module->course_id]) }}"
                        class="text-decoration-none">Módulos</a></li>
                <li class="breadcrumb-item mb-3 mt-3"><a
                        href="{{ route('classe.index', ['module' => $classe->module_id]) }}"
                        class="text-decoration-none">Aulas</a></li>
                <li class="breadcrumb-item mb-3 mt-3 active">Aula</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    {{--                    <span>{{ $classe->name }}</span>--}}
                    Visualizar
                </div>
                <div class="d-flex">

                    <a href="{{ route('classe.edit', ['classe' => $classe->id]) }}" class="btn btn-primary btn-sm me-2">Editar</a>

                    <form id="formDelete{{ $classe->id }}" action="{{ route('classe.destroy', ['classe' => $classe->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm btnDelete" data-delete-id="{{ $classe->id }}">Excluir
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body ">

                <dl class="row">
                    <dt class="col-sm-3">Curso</dt>
                    <dd class="col-sm-9">{{ $classe->module->course->name }}</dd>

                    <dt class="col-sm-3">Módulo</dt>
                    <dd class="col-sm-9">{{ $classe->module->name }}</dd>

                    <dt class="col-sm-3">Aula:</dt>
                    <dd class="col-sm-9">{{ $classe->name }}</dd>

                    <dt class="col-sm-3">PDF:</dt>
                    <dd class="col-sm-9">
                        @if($classe->pdf)
                            <span>Baixar material da aula:</span><a
                                href="{{ route('classe.file', ['classe' => $classe->id]) }}"
                                class="text-decoration-none"> Clique aqui</a>
                        @else
                            <span class="text-secondary">Essa aula não possui material</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Criado:</dt>
                    <dd class="col-sm-9">{{ date_format($classe->created_at, 'd/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Editado:</dt>
                    <dd class="col-sm-9">{{ date_format($classe->updated_at, 'd/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Video:</dt>
                    <dd class="col-sm-9">
                        @if($classe->video)
                            <video src="/storage/{{ $classe->video }}" width="1100" height="500" controls
                                   style="width: 500px; height: 200px">
                                <source src="/storage/{{ $classe->video }}" type="video/mp4">
                                <source src="/storage/{{ $classe->video }}" type="video/mov">
                            </video>
                        @endif
                    </dd>



                </dl>
            </div>
        </div>
    </div>
@endsection
