@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Aluno</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3 active">Alunos</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Listar</span>
                </div>
                <div>
                    @can('create-student')
                        <a href="{{ route('student.create') }}"
                           class="btn btn-primary btn-sm">Cadastrar
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
                        <th>Aluno</th>
                        <th>Curso</th>
                        <th class="text-center" style="width: 20%;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($students as $student)
                        <tr>

                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->course->name }}</td>

                            <td class="d-md-flex justify-content-center">
                                @can('show-student')
                                    <a href="{{ route('student.show', ['student' => $student->id]) }}"
                                       class="btn btn-outline-info btn-sm me-2 border-0"><i class="fa-solid fa-eye"></i></a>
                                @endcan

                                @can('edit-student')
                                    <a href="{{ route('student.edit', ['student' => $student->id]) }}"
                                       class="btn btn-outline-primary btn-sm me-2 border-0"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                @endcan

                                @can('destroy-student')
                                    <form id="formDelete{{ $student->id }}" action="{{ route('student.destroy', ['student' => $student->id]) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm border-0 btnDelete" data-delete-id="{{$student->id}}"><i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-info" role="alert">
                            Nenhum aluno(a) cadastrado(a)
                        </div>
                    @endforelse
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    {{ $students->onEachSide(0)->links() }}
                </nav>
            </div>
        </div>
    </div>

@endsection
