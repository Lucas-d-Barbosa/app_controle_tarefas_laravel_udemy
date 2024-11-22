@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                  Tarefas 
                  <div class="d-flex gap-2">
                    <a href="{{route('tarefa.create')}}">Novo</a> 
                    <a href="{{route('tarefa.exportacao', ['formato' =>'csv'])}}">CSV</a>  
                    <a href="{{route('tarefa.exportacao', ['formato' =>'pdf'])}}">PDF</a>  
                    <a href="{{route('tarefa.exportar')}}" target="_blank">PDF V2</a>  
                    <a href="{{route('tarefa.exportacao', ['formato' =>'xlsx'])}}">XLSX</a>  
                  </div>
                </div>
                
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tarefa</th>
                            <th scope="col">Data limite</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($tarefas as $tarefa)
                            <tr>
                                <th scope="row">{{$tarefa->id}}</th>
                                <td>{{$tarefa->tarefa}}</td>
                                <td>{{date('d/m/Y', strtotime($tarefa->data_limite_conclusao))}}</td>
                                <td><a href="{{route('tarefa.edit', $tarefa->id)}}">Editar</a></td>
                                <td><a href="{{route('tarefa.show', $tarefa->id)}}">Exibir</a></td>
                                <td>
                                  <form action="{{route('tarefa.destroy', $tarefa->id)}}" method="POST" id="form_{{$tarefa->id}}">
                                    @csrf
                                    @method("DELETE")
                                  </form>
                                  <a href="#" onclick="document.getElementById('form_{{$tarefa->id}}').submit()">Excluir</a>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                          <li class="page-item"><a class="page-link" href="{{$tarefas->previousPageUrl()}}">Voltar</a></li>
                          @for ($i = 1; $i <= $tarefas->lastPage(); $i++)
                            <li class="page-item {{$tarefas->currentPage() == $i ? 'active' : ''}}">
                                <a class="page-link" href="{{$tarefas->url($i)}}">{{$i}}</a>
                            </li>
                          @endfor
                          
                          <li class="page-item"><a class="page-link" href="{{$tarefas->nextPageUrl()}}">Avançar</a></li>
                        </ul>
                      </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 