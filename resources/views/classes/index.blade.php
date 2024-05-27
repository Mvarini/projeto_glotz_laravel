@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">
                {{ $module->course->name }}
            </h3>
            <ol class="breadcrumb mb-3 mt-3">
                @can('index-course')
                    <li class="breadcrumb-item mb-3 mt-3"><a class="text-decoration-none"
                                                             href="{{ route('course.index') }}">Cursos</a></li>
                @endcan

                @can('index-module')
                    <li class="breadcrumb-item mb-3 mt-3"><a class="text-decoration-none"
                                                             href="{{ route('module.index', ['course' => $module->course_id]) }}">Módulos</a>
                    </li>
                @endcan
                <li class="breadcrumb-item mb-3 mt-3 active">Aulas</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>
                        {{ $module->name }}
                    </span>
                </div>
                <div>
                    @can('create-classe')
                        <a href="{{ route('classe.create', ['module' => $module->id]) }}"
                           class="btn btn-primary btn-sm">Cadastrar</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        {{--                        <th>Módulo</th>--}}
                        <th>Aula</th>
                        <th class="text-center" style="width: 20%;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($classes as $classe)
                        <tr>
                            {{--                            <td>{{ $classe->module->course->name}}</td>--}}
                            <td>
                                @can('show-classe')
                                    <a href="{{ route('classe.show', ['classe' => $classe->id]) }}"
                                       class="text-decoration-none text-dark">{{ $classe->name }}</a>
                                @endcan
                            </td>
                            <td class="d-md-flex justify-content-center">

                                @can('show-classe')
                                    <a href="{{ route('classe.show', ['classe' => $classe->id]) }}"
                                       class="btn btn-outline-info btn-sm me-2 border-0"><i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan

                                @can('edit-classe')
                                    <a href="{{ route('classe.edit', ['classe' => $classe->id]) }}"
                                       class="btn btn-outline-primary btn-sm me-2 border-0"><i
                                            class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endcan

                                @can('destroy-classe')
                                    <form id="formDelete{{ $classe->id }}" action="{{ route('classe.destroy', ['classe' => $classe->id]) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm border-0 btnDelete" data-delete-id="{{ $classe->id }}"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                @endcan

                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-info" role="alert">
                            Nenhuma aula cadastrada
                        </div>
                    @endforelse
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    {{ $classes->onEachSide(0)->links() }}
                </nav>
            </div>
        </div>
    </div>

@endsection
