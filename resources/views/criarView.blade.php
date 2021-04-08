<form method="post" action="{{route('rota.store')}}" enctype="multipart/form-data">
      {{ csrf_field() }}                        
      <input type="text" name="name" placeholder="Nome">
      <input type="text" name="login" placeholder="Email">
      <input type="password" name="password" placeholder="Senha">	
      <button type="submit">
      Cadastrar
      </button>   
</form>