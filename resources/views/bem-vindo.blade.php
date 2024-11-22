Site da aplicação
@auth
    <h1>Usuário autenticado!</h1>
    <p>{{Auth::user()->id}}</p>
    <p>{{Auth::user()->name}}</p>
    <p>{{Auth::user()->email}}</p>
@endauth

@guest
    <h1>Seja bem-vindo!</h1>
    <p>Cadastre-se já no nosso site e gerencie suas tarefas da melhor forma!</p>
@endguest