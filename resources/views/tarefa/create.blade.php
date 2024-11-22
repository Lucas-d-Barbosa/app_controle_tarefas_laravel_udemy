@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Adicionar Tarefa</div>

                <div class="card-body">
                    <form method="POST" action="{{route('tarefa.store')}}">
                        @csrf
                        <div class="mb-3">
                          <label class="form-label">Tarefa</label>
                          <input type="text" class="form-control" name="tarefa">
                          @if ($errors->has('tarefa'))
                          <div class="alert alert-danger mt-2">
                            {{$errors->has('tarefa') ? $errors->first('tarefa') : ''}}
                          </div>
                          @endif
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Data de limite de conclusão</label>
                          <input type="date" class="form-control" name="data_limite_conclusao">
                            
                          @if ($errors->has('data_limite_conclusao'))
                          <div class="alert alert-danger mt-2">
                            {{$errors->has('data_limite_conclusao') ? $errors->first('data_limite_conclusao') : ''}}
                        </div>
                          @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 