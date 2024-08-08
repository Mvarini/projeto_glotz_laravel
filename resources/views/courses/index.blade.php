@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Curso</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3 active">Cursos</li>
            </ol>
        </div>

{{--        <div class="row mb-3">--}}
{{--            <form action="{{ route('course.index') }}" METHOD="GET">--}}
{{--                <div class="input-group">--}}
{{--                    <input type="text" class="form-control" name="pesquisar" value=""--}}
{{--                           placeholder="Pesquisar professor por nome ou sobrenome">--}}
{{--                    <button type="submit" class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></button>--}}
{{--                    <a href="{{ route('course.index') }}" class="input-group-text"><i class="fa-solid fa-eraser"></i></a>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}

        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Meus cursos</span>
                </div>
                <div>
                    @can('create-course')
                        <a href="{{ route('course.create', ['teacher' => $teacher->id]) }}"
                           class="btn btn-primary btn-sm">Cadastrar</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">

                    @forelse($courses as $course)

                        <div class="col mb-4">
                            <div class="card border-primary border-bottom border-3 border-0 shadow">
                                @if($course->cover)
                                    <a href="{{ route('module.index', ['course' => $course->id]) }}"><img
                                            src="/img/courses/{{ $course->cover }}" class="card-img-top"
                                            style="height: 10rem"
                                            alt="{{ $course->cover }}"/>
                                    </a>
                                @else
                                    <a href="{{ route('module.index', ['course' => $course->id]) }}"><img
                                            src="/assets/no-image.jpg" class="card-img-top" style="height: 10rem"
                                            alt=""/>
                                    </a>
                                @endif

                                <div class="card-body">
                                    <a href="{{ route('module.index', ['course' => $course->id]) }}"
                                       class="text-decoration-none"><h6
                                            class="card-title text-primary">{{ substr($course->name, 0, 27) }}</h6>
                                    </a>
                                    <hr>
                                    <div class="d-flex align-items-center gap-2">
                                        @can('show-course')
                                            <a href="{{ route('course.show', ['course' => $course->id]) }}"
                                               class="btn btn-outline-info btn-sm me-2 border-0"><i
                                                    class="fa-solid fa-eye"></i>
                                            </a>
                                        @endcan

                                        @can('edit-course')
                                            <a href="{{ route('course.edit', ['course' => $course->id]) }}"
                                               class="btn btn-outline-primary btn-sm me-2 border-0">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan

                                        @can('destroy-course')
                                            {{--                                                <form action="{{ route('course.destroy', ['course' => $course->id]) }}"--}}
                                            {{--                                                      method="POST">--}}
                                            {{--                                                    @csrf--}}
                                            {{--                                                    @method('DELETE')--}}
                                            {{--                                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0"--}}
                                            {{--                                                            onclick="return confirm('Deseja excluir o courso?')"><i--}}
                                            {{--                                                            class="fa-solid fa-trash-can"></i></button>--}}
                                            {{--                                                </form>--}}

                                            <form id="formDelete{{ $course->id }}"
                                                  action="{{ route('course.destroy', ['course' => $course->id]) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-sm border-0 btnDelete"
                                                        data-delete-id="{{ $course->id }}"><i
                                                        class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                    @if(!auth()->user()->hasRole('Aluno'))
                                        <hr>
                                    @endif
                                    <div>
                                        @can('generate-pdf-user')
                                            @if(auth()->user()->hasRole('Aluno'))
                                                <a href="{{ route('certificate.user', ['student' => $student->id, 'course' => $course->id]) }}"
                                                   class="btn btn-primary btn-sm me-2 border-0">
                                                    <i class="fa-solid fa-medal"></i> Certificado
                                                </a>
                                            @else
                                                <a class="btn btn-primary btn-sm me-2 border-0 disabled" role="button" aria-disabled="true">
                                                    <i class="fa-solid fa-medal"></i> Certificado
                                                </a>
                                            @endif
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="container">
                            <div class="alert alert-info text-center" role="alert">
                                Nenhum curso cadastrado
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation example" class="mt-2">
            {{ $courses->onEachSide(0)->links() }}
        </nav>
    </div>
@endsection
