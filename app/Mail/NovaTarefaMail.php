<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\Tarefa; 
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NovaTarefaMail extends Mailable
{
    use Queueable, SerializesModels;
    public $tarefa;
    public $data_limite_conclusao;
    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tarefa $tarefa)
    
    {

        $this->tarefa = $tarefa->tarefa;
        $this->data_limite_conclusao = date('d/m/Y', strtotime($tarefa->data_limite_conclusao));
        $this->url = 'http://localhost:8001/tarefa/'.$tarefa->id;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.nova-tarefa')
        ->subject('Nova tarefa adicionada');
        dd("Aqui 6");
    }
}
