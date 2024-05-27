@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 ">Professor</h3>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item mb-3 mt-3"><a href="{{ route('teacher.index') }}"
                                                         class="text-decoration-none">Professores</a></li>
                <li class="breadcrumb-item mb-3 mt-3 active">Professor</li>
            </ol>
        </div>

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <span>Editar</span>
                </div>
                <div>
                    <a href="{{ route('teacher.show', ['teacher' => $teacher->id]) }}" class="btn btn-secondary btn-sm">Visualizar</a>
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <form class="row g-3" action="{{ route('teacher.update', ['teacher' => $teacher->id]) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-md-2">
                        <label for="first_name" class="form-label">Nome</label>
                        <input type="text" name="first_name"  class="form-control" id="first_name" placeholder="Nome do professor" value="{{ old('first_name', $teacher->first_name)}}">
                    </div>

                    <div class="col-md-5">
                        <label for="last_name" class="form-label">Sobrenome</label>
                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Sobrenome do professor" value="{{ old('last_name', $teacher->last_name) }}">
                    </div>

                    <div class="col-md-5">
                        <label for="signature" class="form-label">Assinatura</label>
                        <input type="file" class="form-control" name="signature" id="signature"><br>
                    </div>

                    <div class="d-flex justify-content-end mt-0">
                        <button type="submit" class="btn btn-primary" >Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
