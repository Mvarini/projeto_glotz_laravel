@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Permissões</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{ route('role.index') }}" class="text-decoration-none">Papéis</a>
                </li>
                <li class="breadcrumb-item mb-3 mt-3 active">Permissões</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Papel -  {{ $role->name }} </span>
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Título</th>
                        <th>Rota</th>
                        <th class="text-center" style="width: 20%;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($permissions as $permission)
                        <tr>
                            <td>{{ $permission->title }}</td>
                            <td>{{ $permission->name }}</td>
                            <td class=" text-center">
                                @if(in_array($permission->id, $rolePermissions ?? []))
                                    @can('update-role-permission')
                                       <a href="{{ route('role-permission.update', ['role' => $role->id, 'permission' => $permission->id]) }}"><span class="badge text-bg-success">Liberado</span></a>
                                    @else
                                        <span class="badge text-bg-success">Liberado</span>
                                    @endcan
                                @else
                                    @can('update-role-permission')
                                        <a href="{{ route('role-permission.update', ['role' => $role->id, 'permission' => $permission->id]) }}"><span class="badge text-bg-danger">Bloqueado</span></a>
                                    @else
                                        <span class="badge text-bg-danger">Bloqueado</span>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-info" role="alert">
                            Nenhuma permissão para o papel encontada
                        </div>
                    @endforelse
                    </tbody>
                </table>
                {{--                {{ $roles->onEachSide(0)->links() }}--}}
            </div>
        </div>
    </div>
@endsection
