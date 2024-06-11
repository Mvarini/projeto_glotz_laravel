@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Aula</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a class="text-decoration-none"
                                                         href="{{ route('course.index') }}">Cursos</a></li>
                <li class="breadcrumb-item mb-3 mt-3"><a class="text-decoration-none"
                                                         href="{{ route('classe.index', ['module' => $module->id]) }}">Aulas</a>
                </li>
                <li class="breadcrumb-item mb-3 mt-3 active">Aula</li>
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

                <form class="row g-3" action="{{ route('classe.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="module_id" id="module_id" value="{{ $module->id }}">

                    <div class="col-md-6">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nome da aula"
                               value="{{ old('name') }}"/>
                    </div>

                    <div class="col-md-6">
                        <label for="video" class="form-label">Video (40mb)</label>
                        <input type="file" name="video" id="video" class="form-control" placeholder="video da aula"/>

                        </div>

                    <div class="col-md-6">
                        <label for="pdf" class="form-label">PDF (7mb)</label>
                        <input type="file" name="pdf" id="pdf" class="form-control" placeholder="pdf da aula"/>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" value="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
