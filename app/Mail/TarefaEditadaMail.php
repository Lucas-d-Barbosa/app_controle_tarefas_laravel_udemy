<?php

namespace App\Mail;

use App\Models\Tarefa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TarefaEditadaMail extends Mailable
{
    use Queueable, SerializesModels;
    public $tarefaAtualizada;
    public $tarefaAntiga;
    public $data_limite_conclusao;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tarefa $tarefaAtualizada, Tarefa $tarefaAntiga)
    {
        $this->tarefaAtualizada = $tarefaAtualizada->tarefa;
        $this->tarefaAntiga = $tarefaAntiga->tarefa;
        $this->data_limite_conclusao = date('d/m/Y', strtotime($tarefaAtualizada->data_limite_conclusao));
        $this->url = 'http://localhost:8001/tarefa/'.$tarefaAtualizada->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.tarefa-editada-mail')
        ->subject('Tarefa editada com sucesso!');
    }
}
