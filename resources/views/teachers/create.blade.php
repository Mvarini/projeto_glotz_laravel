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
                    <span>Cadastrar</span>
                </div>
            </div>
            <div class="card-body">

                {{--            As informações estão em view/components--}}
                <x-alert/>

                <form class="row g-3" action="{{ route('teacher.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="col-md-2">
                        <label for="first_name" class="form-label">Nome</label>
                        <input type="text" name="first_name" id="first_name" class="form-control"
                               placeholder="Nome do professor"
                               value="{{ old('first_name') }}">
                    </div>

                    <div class="col-md-5">
                        <label for="last_name" class="form-label">Sobrenome</label>
                        <input type="text" name="last_name" id="last_name" class="form-control"
                               placeholder="Sobrenome do professor"
                               value="{{ old('last_name') }}">
                    </div>

                    <div class="col-md-5">
                        <label for="signature" class="form-label">Assinatura (200x150)</label>
                        <input type="file" name="signature" id="signature" class="form-control"
                               placeholder="Assinatura do professor">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" >Cadastar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
