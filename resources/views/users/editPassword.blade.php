@extends('layouts.admin')

@section('content')

    <div class="container-fluid px-4">
        <div class="space-between-elements d-flex justify-content-between align-items-center">
            <h2 class="mt-3">Usuário</h2>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item active"><a href="{{route('dashboard.index')}}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{route('course.index')}}" class="text-decoration-none">Cursos</a></li>
                <li class="breadcrumb-item active"><a href="{{route('user.index')}}" class="text-decoration-none">Usuários</a></li>
                <li class="breadcrumb-item active">Usuário</li>
            </ol>
        </div>

        <div class="card mb-4 borderAround shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Editar</span>
                </div>
                <div class="d-flex">
                    <a href="{{route('user.show', ['user' => $user->id])}}" class="btn btn-outline-primary btn-sm me-2" title="Visualizar"><i class="fa-solid fa-eye"></i> Visualizar</a>

                    <form action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este registro?')"><i class="fa-solid fa-trash-can"></i> Excluir</button>
                    </form>
                </div>
            </div>

            <div class="card-body">

                <x-alert/>

                <form  action="{{ route('user.update-password', ['user' => $user->id]) }}" method="POST" class="row g-3">
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
