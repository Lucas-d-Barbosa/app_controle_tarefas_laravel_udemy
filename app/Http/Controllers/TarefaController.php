<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\NovaTarefaMail;
use App\Mail\TarefaEditadaMail;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

use App\Exports\TarefasExport;
use Maatwebsite\Excel\Facades\Excel;

class TarefaController extends Controller
{


    public function __construct(){
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->id;
        $tarefas = Tarefa::where('user_id', $user)->paginate(10);
        return view('tarefa.index', ['tarefas' => $tarefas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['user_id'] = Auth::user()->id;
        $rules =
        [
            'tarefa' => 'required|min:4|max:200',
            'data_limite_conclusao' => 'required|after:yesterday'
        ];

        $feedback =
        [
            'required' => 'O campo :attribute deve ser preenchido!',
            'after' => 'A data de conslusão da tarefa deve ser posterior a ontem.'
        ];

        $request->validate($rules, $feedback);
        $tarefa = Tarefa::create($dados);
        $destinatario = Auth::user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {
        $user_id = Auth::user()->id;
        if($tarefa->user_id == $user_id)
        {
            return view('tarefa.edit', ['tarefa' => $tarefa]);
        }
        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        if($tarefa->user_id == Auth::user()->id)
        {
            $dados = $request->all();
            $dados['user_id'] = Auth::user()->id;
            $rules =
            [
                'tarefa' => 'required|min:4|max:200',
                'data_limite_conclusao' => 'required|after:yesterday'
            ];
    
            $feedback =
            [
                'required' => 'O campo :attribute deve ser preenchido!',
                'after' => 'A data de conslusão da tarefa deve ser posterior a ontem.'
            ];
    
            $request->validate($rules, $feedback);
            $tarefaAntiga = $tarefa;
            $tarefa->update($request->all());
            $destinatario = Auth::user()->email;
            Mail::to($destinatario)->send(new TarefaEditadaMail($tarefa, $tarefaAntiga));
            return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    
        }
        return view('acesso-negado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        if($tarefa->user_id == Auth::user()->id)
        {
            $tarefa->delete();
            return redirect()->route('tarefa.index');
        }
        return view('acesso-negado');
        
    }

    public function exportacao($formato)
    {
        if(in_array($formato, ['xlsx', 'csv', 'pdf']))
            return Excel::download(new TarefasExport, "lista_de_tarefas.$formato");    
        return redirect()->route('tarefa.index');  
    }

    public function exportar()
    {
        $tarefas = auth()->user()->tarefas()->get();
        $pdf = PDF::loadView('tarefa.pdf', ['tarefas' => $tarefas]);
        $pdf->setPaper('a4', 'landscape');
        // tipo de papel: a4, letter
        // orientação: landscape (paisagem), portrait (retrato)

        // return $pdf->download('lista_de_tarefas.pdf');
        return $pdf->stream('lista_de_tarefas.pdf');
    }

}
