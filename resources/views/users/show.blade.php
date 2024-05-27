@extends('layouts.admin')

@section('content')

    <div class="container-fluid px-4">
        <div class="space-between-elements d-flex justify-content-between align-items-center">
            <h2 class="mt-3">Usuário</h2>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item active"><a href="{{route('user.index')}}" class="text-decoration-none">Usuários</a>
                </li>
                <li class="breadcrumb-item active">Usuário</li>
            </ol>
        </div>

        <div class="card mb-4 borderAround shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Visualizar</span>
                </div>
                <div class="d-flex">
                    @can('edit-password-user')
                        <a href="{{route('user.edit-password', ['user' => $user->id])}}"
                           class="btn btn-dark btn-sm me-2"> Senha</a>
                    @endcan

                    @can('edit-user')
                        <a href="{{route('user.edit', ['user' => $user->id])}}" class="btn btn-primary btn-sm me-2">
                            Editar</a>
                    @endcan

                    @can('destroy-user')
                        <form id="formDelete{{ $user->id }}" action="{{ route('user.destroy', ['user' => $user->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btnDelete" data-delete-id="{{ $user->id }}"> Excluir
                            </button>
                        </form>
                    @endcan
                </div>
            </div>

            <div class="card-body">

                <x-alert/>

                <dl class="row">
                    <dt class="col-sm-3">Usuário:</dt>
                    <dd class="col-sm-9">{{ $user->name }}</dd>

                    <dt class="col-sm-3">e-mail:</dt>
                    <dd class="col-sm-9">{{ $user->email }}</dd>

                    <dt class="col-sm-3">Papel:</dt>
                    <dd class="col-sm-9">
                        @forelse($user->getRoleNames() as $role)
                            {{ $role }}
                        @empty
                            {{ "Nenhum papel" }}
                        @endforelse
                    </dd>

                    <dt class="col-sm-3">Criação:</dt>
                    <dd class="col-sm-9">{{ \Carbon\Carbon::parse($user->created_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s')}}</dd>

                    <dt class="col-sm-3">Alteração:</dt>
                    <dd class="col-sm-9">{{ \Carbon\Carbon::parse($user->updated_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</dd>
                </dl>
            </div>
        </div>
    </div>

@endsection
