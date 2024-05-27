@extends('layouts.admin')

@section('content')

    <div class="container-fluid px-4">
        <div class="space-between-elements d-flex justify-content-between align-items-center">
            <h2 class="mt-3">Perfil</h2>
            <ol class="breadcrumb mb-3 mt-3">
{{--                <li class="breadcrumb-item active"><a href="{{route('user.index')}}" class="text-decoration-none">Usuários</a></li>--}}
                <li class="breadcrumb-item active">Perfil</li>
            </ol>
        </div>

        <div class="card mb-4 borderAround shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Editar</span>
                </div>
                <div class="d-flex">
                    <a href="{{route('profile.show') }}" class="btn btn-secondary btn-sm me-2"> Visualizar</a>
                </div>
            </div>

            <div class="card-body">

                <x-alert/>

                <form  action="{{ route('profile.update')}}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="name" class="form-label">Nome </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nome do curso" value="{{ old('name', $user->name) }}" >
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail </label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Melhor e-mail" value="{{ old('email', $user->email) }}" >
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

