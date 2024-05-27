@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Perfil</h3>
            <ol class="breadcrumb mb-3 mt-3">
{{--                <li class="breadcrumb-item mb-3 mt-3"><a href="{{route('teacher.index')}}" class="text-decoration-none">Professores</a></li>--}}
                <li class="breadcrumb-item mb-3 mt-3 active">Perfil</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Visualizar</span>
                </div>
                <div class="d-flex">
                    <a href="{{ route('profile.edit-Password') }}" class="btn btn-dark btn-sm me-2">Senha</a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm me-2">Editar</a>
                </div>
            </div>
            <div class="card-body">

                <x-alert/>

                <dl class="row">
                    <dt class="col-sm-3">Nome:</dt>
                    <dd class="col-sm-9">{{ $user->name }}</dd>

                    <dt class="col-sm-3">E-mail:</dt>
                    <dd class="col-sm-9">{{ $user->email }}</dd>

                    <dt class="col-sm-3">Cadastrado:</dt>
                    <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Editado:</dt>
                    <dd class="col-sm-9">{{ $user->updated_at->format('d/m/Y H:i:s') }}</dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
