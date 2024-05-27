@extends('layouts.admin')

@section('content')

    <div class="container-fluid px-4">
        <div class="space-between-elements d-flex justify-content-between align-items-center">
            <h2 class="mt-3">Usuários</h2>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </div>

        <div class="card borderAround shadow mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Listar</span>
                </div>
                <div>
                    @can('create-user')
                        <a href="{{route('user.create')}}" class="btn btn-primary btn-sm">Cadastrar</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">

                <x-alert/>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Usuário</th>
                        <th class="d-none d-md-table-cell">E-mail</th>
                        <th class="text-center" style="width: 20%">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                            <td class="d-md-flex justify-content-center">
                                @can('edit-password-user')
                                    <a href="{{route('user.edit-password', ['user' => $user->id])}}"
                                       class="btn btn-outline-dark btn-sm me-2 border-0" title="Senha"><i
                                            class="fa-solid fa-key"></i></a>
                                @endcan

                                @can('show-user')
                                    <a href="{{route('user.show', ['user' => $user->id])}}"
                                       class="btn btn-outline-info btn-sm me-2 border-0" title="Visualizar"><i
                                            class="fa-solid fa-eye"></i></a>
                                @endcan

                                @can('edit-user')
                                    <a href="{{route('user.edit', ['user' => $user->id])}}"
                                       class="btn btn-outline-primary btn-sm me-2 border-0" title="Editar"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                @endcan

                                @can('destroy-user')
                                    <form id="formDelete{{ $user->id }}" action="{{ route('user.destroy', ['user' => $user->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm border-0 btnDelete" data-delete-id="{{ $user->id }}">
                                            <i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                @endcan

                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-info" role="alert">
                            Nenhum usuário cadastrado no sistema
                        </div>
                    @endforelse
                    </tbody>
                </table>
                {{ $users->onEachSide(0)->links() }}
            </div>
        </div>
    </div>

@endsection
