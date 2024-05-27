@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Curso</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{route('course.index')}}" class="text-decoration-none">Cursos</a>
                </li>
                <li class="breadcrumb-item mb-3 mt-3 active">curso</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Visualizar</span>
                </div>
                <div class="d-flex">
                    <a href="{{ route('course.edit', ['course' => $course->id]) }}" class="btn btn-primary btn-sm me-2">Editar</a>


                    <form id="formDelete{{ $course->id }}" action="{{ route('course.destroy', ['course' => $course->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm btnDelete" data-delete-id="{{ $course->id }}">Excluir
                        </button>
                    </form>
                </div>
            </div>

            <div class="card-body">

                <x-alert/>

                <dl class="row">

                    <dt class="col-sm-3">Curso:</dt>
                    <dd class="col-sm-9">{{ $course->name }}</dd>

                    <dt class="col-sm-3">Valor:</dt>
                    <dd class="col-sm-9" id="price">{{ $course->price }}</dd>

                    <dt class="col-sm-3">Duração:</dt>
                    <dd class="col-sm-9">{{ $course->hour }}</dd>

                    <dt class="col-sm-3">Descrição:</dt>
                    <dd class="col-sm-9">{{ $course->description }}</dd>

                    <dt class="col-sm-3">Cadastrado:</dt>
                    <dd class="col-sm-9">{{ $course->created_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Editado:</dt>
                    <dd class="col-sm-9">{{ $course->updated_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Capa:</dt>

                    @if($course->cover)
                        <img src="/img/courses/{{ $course->cover }}" alt="{{ $course->cover }}" style="width: 250px">
                    @else
                        <img src="/assets/no-image.jpg" alt="" style="width: 250px">
                    @endif
                </dl>
            </div>
        </div>
    </div>

@endsection
