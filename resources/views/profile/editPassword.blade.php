@extends('layouts.admin')

@section('content')

    <div class="container-fluid px-4">
        <div class="space-between-elements d-flex justify-content-between align-items-center">
            <h2 class="mt-3">Senha</h2>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item active">Perfil</li>
            </ol>
        </div>

        <div class="card mb-4 borderAround shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Editar</span>
                </div>
                <div class="d-flex">
                    <a href="{{route('profile.show')}}" class="btn btn-secondary btn-sm me-2">Visualizar</a>
                </div>
            </div>

            <div class="card-body">

                <x-alert/>

                <form  action="{{ route('profile.update-Password') }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="password" class="form-label">Nova Senha </label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="Deve conter no mínimo 6 caracteres" value="{{ old('password') }}" >
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirmar nova senha </label>
                        <input type="text" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Deve conter no mínimo 6 caracteres" value="{{ old('password_confirmation') }}" >
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

