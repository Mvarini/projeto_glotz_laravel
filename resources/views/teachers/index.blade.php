@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Professor</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3 active">Professores</li>
            </ol>
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
                                <a href="{{ route('teacher.show', ['teacher' => $teacher->id]) }}"
                                   class="btn btn-outline-info btn-sm me-2 border-0"><i class="fa-solid fa-eye"></i>
                                </a>

                                <a href="{{ route('teacher.edit', ['teacher' => $teacher->id]) }}"
                                   class="btn btn-outline-primary btn-sm me-2 border-0"><i
                                        class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form id="formDelete{{ $teacher->id }}" action="{{ route('teacher.destroy', ['teacher' => $teacher->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0 btnDelete" data-delete-id="{{ $teacher->id }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
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
