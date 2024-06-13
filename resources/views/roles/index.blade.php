@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Papel</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3 active">Papéis</li>
            </ol>
        </div>

        <div class="row mb-3">
            <form action="{{ route('role.index') }}" METHOD="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="pesquisar" value="{{ $pesquisar }}"
                           placeholder="Pesquisar por nome do papel">
                    <button type="submit" class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <a href="{{ route('role.index') }}" class="input-group-text"><i class="fa-solid fa-eraser"></i></a>
                </div>
            </form>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Listar</span>
                </div>
                <div>
                    <a href="{{ route('role.create') }}">
                        <button type="button" class="btn btn-primary btn-sm">Cadastrar</button>
                    </a>
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Nome</th>

                        <th class="text-center" style="width: 20%;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>

                            <td class="d-md-flex justify-content-center">
                                @can('index-role-permission')
                                    <a href="{{ route('role-permission.index', ['role' => $role->id]) }}"
                                       class="btn btn-outline-secondary btn-sm me-2 border-0"><i
                                            class="fa-solid fa-shield-halved" title="Permissões"></i>
                                    </a>
                                @endcan

                                @can('show-role')
                                    <a href="{{ route('role.show', ['role' => $role->id]) }}"
                                       class="btn btn-outline-info btn-sm me-2 border-0"><i
                                            class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan

                                @can('edit-role')
                                    <a href="{{ route('role.edit', ['role' => $role->id]) }}"
                                       class="btn btn-outline-primary btn-sm me-2 border-0">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endcan

                                @can('destroy-role')
                                    <form id="formDelete{{ $role->id }}" action="{{ route('role.destroy', ['role' => $role->id]) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm border-0 btnDelete" data-delete-id="{{ $role->id }}"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                @endcan

                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-info" role="alert">
                            Nenhum papel cadastrado
                        </div>
                    @endforelse
                    </tbody>
                </table>
                {{ $roles->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
@endsection
