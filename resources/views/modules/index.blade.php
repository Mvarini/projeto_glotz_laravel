@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-3">
            <h3 class="mt-3 ">
                {{ $course->name }}
            </h3>
            <ol class="breadcrumb mb-3 mt-3">
                @can('index-course')
                    <li class="breadcrumb-item mb-3 mt-3">
                        <a href="{{ route('course.index') }}" class="text-decoration-none">Cursos</a>
                    </li>
                @endcan
                <li class="breadcrumb-item mb-3 mt-3 active">Módulo</li>
            </ol>
        </div>
        @can('create-module')
            @if($datas->count() > 0)
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('module.create', ['course' => $course->id]) }}"
                       class="btn btn-primary btn-sm border-0 me-2" title="Cadastrar">Cadastrar
                    </a>
                </div>
            @endif
        @endcan
        <x-alert/>

        @forelse($datas as $data)
            <div class="list-group-item">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex justify-content-start">
                            <span>{{ $data->name }}</span>
                        </div>
                        <div>
                            @can('index-classe')
                                <a href="{{ route('classe.index', ['module' => $data->id]) }}"
                                   class="btn btn-outline-secondary btn-sm me-2 border-0" title="Aulas">
                                    <i class="fa-regular fa-clipboard"></i>
                                </a>
                            @endcan

                            @can('show-module')
                                <a href="{{ route('module.show', ['module' => $data->id]) }}"
                                   class="btn btn-outline-info btn-sm me-2 border-0" title="Detalhes">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            @endcan

                            {{--                            @can('create-module')--}}
                            {{--                                <a href="{{ route('module.create', ['course' => $data->course->id]) }}"--}}
                            {{--                                   class="btn btn-outline-primary btn-sm border-0 me-2" title="Cadastrar">--}}
                            {{--                                    <i class="fa-solid fa-plus"></i>--}}
                            {{--                                </a>--}}
                            {{--                            @endcan--}}

                            @can('edit-module')
                                <a href="{{ route('module.edit', ['module' => $data->id]) }}"
                                   class="btn btn-outline-primary btn-sm border-0 me-2" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endcan

                            @can('destroy-module')
                                <form id="formDelete{{ $data->id }}" class="d-inline"
                                      action="{{ route('module.destroy', ['module' => $data->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0 btnDelete"
                                            data-delete-id="{{$data->id}}"><i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            @endcan

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Aula</th>
                                <th style="width: 5%;">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data->classe as $dataClasses)
                                <tr>
                                    <td>
                                        @can('view-classe')
                                            <a href='{{ route('classe.view', ['classe' => $dataClasses->id]) }}'
                                               class="text-decoration-none text-dark">{{ $dataClasses->name }}
                                            </a>
                                        @endcan
                                    </td>
                                    <td class="text-center">
                                        @if($listClassesWatched->isNotEmpty() && auth()->user()->hasRole('Aluno'))
                                            @if($listClassesWatched->contains($dataClasses->id . $student->id))
                                                <i class="fa-solid fa-circle-check text-success"
                                                   title='Aula visualizada'></i>
                                            @else
                                                <i class="fa-solid fa-circle-play text-danger"
                                                   title='Aula não visualizada'></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-circle-play text-danger"
                                               title='Aula não visualizada'></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between mb-3">
                        <div class="d-flex justify-content-start">
                            <span>Módulo</span>
                        </div>
                        <div>
                            @can('create-module')
                                <a href="{{ route('module.create', ['course' => $course->id]) }}"
                                   class="btn btn-primary btn-sm">Cadastrar</a>
                            @endcan
                        </div>
                    </div>
                    <div class="container">
                        <div class="alert alert-info" role="alert">
                            Nenhum módulo cadastrado!
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

@endsection

