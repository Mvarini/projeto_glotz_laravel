@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Módulo</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{ route('course.index') }}"
                                                         class="text-decoration-none">Cursos</a></li>
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{ route('module.index', ['course' => $course->id]) }}"
                                                         class="text-decoration-none">Módulos</a></li>
                <li class="breadcrumb-item mb-3 mt-3 active">Módulo</li>
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

                <form class="row g-3" action="{{ route('module.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">

                    <div class="col-md-10">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nome do módulo"
                               value="{{ old('name') }}"/>
                    </div>

                    <div class="col-md-2">
                        <label for="hour" class="form-label">Duração</label>
                        <input type="number" name="hour" id="hour" class="form-control" placeholder="minutos"
                               value="{{ old('hour') }}"/>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea name="description" id="description" rows="4"
                                  class="form-control"
                                  placeholder="Descrição do módulo">{{ old('description') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
