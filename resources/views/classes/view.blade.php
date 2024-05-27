@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3">
                @if($dataFirst)
                    {{ $dataFirst->module->course->name }}
                @endif
            </h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a
                        href="{{ route('course.index') }}"
                        class="text-decoration-none">Cursos</a></li>
                <li class="breadcrumb-item mb-3 mt-3"><a
                        href="{{ route('module.index', ['course' => $dataFirst->module->course_id]) }}"
                        class="text-decoration-none">Módulos</a></li>

                <li class="breadcrumb-item mb-3 mt-3 active">Aula</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>{{ $classe->name }}</span>
                </div>
                <div class="d-flex">

                    <!-- Inicio modal -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                         aria-labelledby="offcanvasRightLabel">
                        <div class="d-flex justify-content-end me-2 mt-2">
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasRightLabel">
                                @if($dataFirst)
                                    {{ $dataFirst->module->course->name }}
                                @endif
                            </h5>
                        </div>
                        <div class="offcanvas-body">
                            <div class="mb-2">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel">
                                    @if($dataFirst)
                                        {{ $dataFirst->module->name }}
                                    @endif
                                </h5>
                            </div>

                            @foreach($listClasses as $classUnique)
                                <div>
                                    @if($listClassesWatched->isNotEmpty() && auth()->user()->hasRole('Aluno'))

                                        @if($listClassesWatched->contains($classUnique->id . $student->id))

                                            <i class="fa-solid fa-circle-check text-success"
                                               title='Aula visualizada'></i>
                                        @else
                                            <i class="fa-solid fa-circle-play text-danger"
                                               title='Aula não visualizada'></i>
                                        @endif
                                        <a href="{{ route('classe.view', ['classe' => $classUnique->id]) }}"
                                           class="text-decoration-none text-dark">{{ $classUnique->name }}
                                        </a>
                                    @else
                                        <i class="fa-solid fa-circle-play text-danger"
                                           title='Aula não visualizada'></i>
                                        <a href="{{ route('classe.view', ['classe' => $classUnique->id]) }}"
                                           class="text-decoration-none text-dark">{{ $classUnique->name }}
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Fim modal -->

                </div>
            </div>

            <div class="card-body text-center">

                <div class="col-12 pl-0 pr-0">
                    <div class="row mb-2">
                        <div class="container text-center d-flex justify-content-center">
                            {{--                            <span><a class="btn btn-outline-primary btn-sm" href="#" >&larr; Anterior</a></span>--}}

                            <button class="btn btn-outline-primary btn-sm me-2" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Listar Aulas
                            </button>

                            {{--                            <span><a class="btn btn-outline-primary btn-sm" href="#">Próxima &rarr;</a></span>--}}
                        </div>
                    </div>
                </div>

                @if($classe->video)
                    <video src="/storage/{{ $classe->video }}" class="img-fluid" width="1100" height="500" controls
                           style="width: 1100px; height: 500px">
                        <source src="/storage/{{ $classe->video }}" type="video/mp4">
                        <source src="/storage/{{ $classe->video }}" type="video/mov">
                    </video>
                @endif
                <br>
                @if($classe->pdf)
                    <span>Baixar material da aula:</span><a
                        href="{{ route('classe.file', ['classe' => $classe->id]) }}"
                        class="text-decoration-none"> Clique aqui</a>
                @else
                    <span class="text-secondary">Essa aula não possui material</span>
                @endif
            </div>
        </div>
    </div>

@endsection
