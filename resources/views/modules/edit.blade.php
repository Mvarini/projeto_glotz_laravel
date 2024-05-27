@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Módulo</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{ route('course.index') }}" class="text-decoration-none">Cursos</a></li>
                <li class="breadcrumb-item mb-3 mt-3"><a
                        href="{{ route('module.index', ['course' => $module->course_id]) }}"
                        class="text-decoration-none">Módulos</a></li>
                <li class="breadcrumb-item mb-3 mt-3 active">Módulo</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Editar</span>
                </div>
                <div>
                    <a href="{{ route('module.show', ['module' => $module->id]) }}" class="btn btn-secondary btn-sm">Visualizar</a>
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <form class="row g-3" action="{{ route('module.update', ['module' => $module->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="col-md-10">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nome do módulo"
                               value="{{ old('name', $module->name) }}"/>
                    </div>

                    <div class="col-md-2">
                    <label for="hour" class="form-label">Duração</label>
                    <input type="number" name="hour" id="hour" class="form-control" placeholder="Duração do módulo"
                           value="{{ old('hour', $module->hour) }}"/>
                    </div>
                    <div class="col-12">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea name="description" id="description" rows="4"
                             class="form-control" placeholder="Descrição do módulo">{{ old('description', $module->description) }}</textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
