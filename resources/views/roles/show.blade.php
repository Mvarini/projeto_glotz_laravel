@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Papel</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{route('role.index')}}" class="text-decoration-none">Papel</a>
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
                    @can('edit-role')
                        <a href="{{ route('role.edit', ['role' => $role->id]) }}" class="btn btn-primary btn-sm me-2">Editar</a>
                    @endcan

                    @can('destroy-role')
                        <form id="formDelete{{ $role->id }}" action="{{ route('role.destroy', ['role' => $role->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btnDelete" data-delete-id="{{ $role->id }}">Excluir
                            </button>
                        </form>
                    @endcan

                </div>
            </div>

            <div class="card-body">

                <x-alert/>

                <dl class="row">

                    <dt class="col-sm-3">Papel:</dt>
                    <dd class="col-sm-9">{{ $role->name }}</dd>

                    <dt class="col-sm-3">Cadastrado:</dt>
                    <dd class="col-sm-9">{{ $role->created_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Editado:</dt>
                    <dd class="col-sm-9">{{ $role->updated_at->format('d/m/Y H:i:s') }}</dd>

                </dl>
            </div>
        </div>
    </div>

@endsection
