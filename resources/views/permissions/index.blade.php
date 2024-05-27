@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Permissão</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3 active">Permissões</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Listar</span>
                </div>
                <div>
                    @can('create-permission')
                        <a href="{{ route('permission.create') }}">
                            <button type="button" class="btn btn-primary btn-sm">Cadastrar</button>
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Título</th>
                        <th>Nome</th>
                        <th class="text-center" style="width: 20%;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($permissions as $permission)
                        <tr>
                            <td>{{ $permission->title }}</td>
                            <td>{{ $permission->name }}</td>
                            <td class="d-md-flex justify-content-center">

                                @can('show-permission')
                                    <a href="{{ route('permission.show', ['permission' => $permission->id]) }}"
                                       class="btn btn-outline-info btn-sm me-2 border-0"><i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan

                                @can('edit-permission')
                                    <a href="{{ route('permission.edit', ['permission' => $permission->id]) }}"
                                       class="btn btn-outline-primary btn-sm me-2 border-0"><i
                                            class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endcan

                                @can('destroy-permission')
                                    <form id="formDelete{{ $permission->id }}" action="{{ route('permission.destroy', ['permission' => $permission->id]) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm border-0 btnDelete" data-delete-id="{{ $permission->id }}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-info" role="alert">
                            Nenhuma permissão cadastrada
                        </div>
                    @endforelse
                    </tbody>
                </table>
                {{ $permissions->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
@endsection
