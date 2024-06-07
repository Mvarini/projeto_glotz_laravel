@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Curso</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{ route('course.index') }}"
                                                         class="text-decoration-none">Cursos</a></li>
                <li class="breadcrumb-item mb-3 mt-3 active">Curso</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Editar</span>
                </div>
                <div>
                    <a href="{{ route('course.show', ['course' => $course->id]) }}" class="btn btn-secondary btn-sm">Visualizar</a>
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <form class="row g-3" action="{{ route('course.update', ['course' => $course->id]) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="teacher_id" class="form-label">Professor</label>
                        <select name="teacher_id" class="form-select">
                            <option value="">Selecione</option>
                            @foreach($teachers as $teacher)
                                <option {{ $teacher->id == $course->teacher_id ? "selected" : "" }} value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label">Curso</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nome do curso"
                               value="{{ old('name', $course->name) }}"/>
                    </div>

                    <div class="col-md-3">
                        <label for="price" class="form-label">Valor</label>
                        <input type="text" name="price" id="price" class="form-control" placeholder="Valor do curso"
                               value="{{ old('price', $course->price) }}"/>
                    </div>

                    <div class="col-md-3">
                        <label for="hour" class="form-label">Duração</label>
                        <input type="number" name="hour" id="hour" class="form-control" placeholder="Duração do curso"
                               value="{{ old('hour', $course->hour) }}"/>
                    </div>

                    <div class="col-md-6">
                        <label for="cover" class="form-label">Capa</label>
                        <input type="file" name="cover" id="cover" class="form-control" placeholder="Capa do curso"/>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea name="description" id="description" rows="4" cols="30" class="form-control"
                                  placeholder="Descrição do curso">{{ old('description', $course->description) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
