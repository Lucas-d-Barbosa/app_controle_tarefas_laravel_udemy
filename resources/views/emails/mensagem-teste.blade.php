@component('mail::message')
# Introdução

Corpo da mensagem. <br>
- Opção 1 
- Opção 2 
- Opção 3 
@component('mail::button', ['url' => ''])
Esse botão é inútil 1
@endcomponent


@component('mail::button', ['url' => ''])
Esse botão é inútil 2
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
