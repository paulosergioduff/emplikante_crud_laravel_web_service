<form method="post" action="{{route('rota.update', $consulta->id)}}" enctype="multipart/form-data">
    {!! method_field('put') !!}
    {{ csrf_field() }}
    <input type="text" name="name" value="{{$consulta->name}}">
	<input type="text" name="description" value="{{$consulta->description}}">
    <button type="submit">
    Cadastrar
    </button>
  </form>