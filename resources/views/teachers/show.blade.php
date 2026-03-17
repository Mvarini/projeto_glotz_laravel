@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Professor</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{route('teacher.index')}}" class="text-decoration-none">Professores</a></li>
                <li class="breadcrumb-item mb-3 mt-3 active">Professor</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Visualizar</span>
                </div>
                <div class="d-flex">
                    @can('edit-teacher')
                        <a href="{{ route('teacher.edit', ['teacher' => $teacher->id]) }}"
                           class="btn btn-primary btn-sm me-2">Editar</a>
                    @endcan
                    @can('destroy-teacher')
                            <form id="formDelete{{ $teacher->id }}" action="{{ route('teacher.destroy', ['teacher' => $teacher->id])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btnDelete" data-delete-id="{{ $teacher->id }}">Excluir
                                </button>
                            </form>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nome:</dt>
                    <dd class="col-sm-9">{{ $teacher->first_name }}</dd>

                    <dt class="col-sm-3">Sobrenome:</dt>
                    <dd class="col-sm-9">{{ $teacher->last_name }}</dd>

                    <dt class="col-sm-3">Cadastrado:</dt>
                    <dd class="col-sm-9">{{ $teacher->created_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Editado:</dt>
                    <dd class="col-sm-9">{{ $teacher->updated_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Assinatura:</dt>
                    <img src="/img/teachers/{{ $teacher->signature }}" class="img-fluid" alt="" style="width: 250px">
                </dl>
            </div>
        </div>
    </div>
@endsection
