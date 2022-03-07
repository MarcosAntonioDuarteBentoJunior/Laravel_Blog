
<h2>
    Olá, {{ $user->name }} . Bem vindo ao Blog Dev.
</h2>

<hr>

<p>
    Esta é uma aplicação de teste que simula um blog sobre desenvolvimento web.
    Encontrou algum bug ? Responda esta mensagem e me ajude a melhorar meus projetos.
</p>

<hr>
Email enviado em {{ date('d/m/Y h:i:s') }} para: {{ $user->email }}