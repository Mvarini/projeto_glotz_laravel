@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Permissão</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{ route('permission.index') }}"
                                                         class="text-decoration-none">Permissões</a></li>
                <li class="breadcrumb-item mb-3 mt-3 active">Permissão</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Editar</span>
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <form class="row g-3" action="{{ route('permission.update', ['permission' => $permission->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" name="title" id="title" class="form-control"
                               placeholder="Nome da rota"
                               value="{{ old('title', $permission->title) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label">Rota</label>
                        <input type="text" name="name" id="name" class="form-control"
                               placeholder="Endereço da rota"
                               value="{{ old('name', $permission->name) }}">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" >Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
