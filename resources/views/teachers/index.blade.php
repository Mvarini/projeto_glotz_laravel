@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Professor</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3 active">Professores</li>
            </ol>
        </div>

        <div class="row mb-3">
            <form action="{{ route('teacher.index') }}" METHOD="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="pesquisar" value="{{ $pesquisar }}"
                           placeholder="Pesquisar professor por nome ou sobrenome">
                    <button type="submit" class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <a href="{{ route('teacher.index') }}" class="input-group-text"><i
                            class="fa-solid fa-eraser"></i></a>
                </div>
            </form>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Listar</span>
                </div>
                <div>
                    <a href="{{ route('teacher.create') }}">
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
                        <th>Sobrenome</th>
                        <th class="text-center" style="width: 20%;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->first_name }}</td>
                            <td>{{ $teacher->last_name }}</td>
                            <td class="d-md-flex justify-content-center">
                                @can('show-teacher')
                                    <a href="{{ route('teacher.show', ['teacher' => $teacher->id]) }}"
                                       class="btn btn-outline-info btn-sm me-2 border-0"><i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan

                                @can('edit-teacher')
                                    <a href="{{ route('teacher.edit', ['teacher' => $teacher->id]) }}"
                                       class="btn btn-outline-primary btn-sm me-2 border-0"><i
                                            class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endcan

                                @can('destroy-teacher')
                                    <form id="formDelete{{ $teacher->id }}"
                                          action="{{ route('teacher.destroy', ['teacher' => $teacher->id])}}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm border-0 btnDelete"
                                                data-delete-id="{{ $teacher->id }}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                @endcan

                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-info" role="alert">
                            Nenhum professor(a) cadastrado(a)
                        </div>
                    @endforelse
                    </tbody>
                </table>
                {{ $teachers->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
@endsection
