<!DOCTYPE html>
<html>
<head>
	<title>Replikante - Processo seletivo</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<a href="rota/create"> <button>Adcionar novo</button></a>
<hr>
@foreach($consulta as $consulta)
{{$consulta->name}} -- {{$consulta->login}}
<a href="{{route('rota.edit', $consulta->user_id)}}">Editar</a>
<form action="{{ route('rota.destroy',$consulta->user_id) }}" method="POST">
      @csrf
      @method('DELETE')
      <button>Apagar</button>
</form>
<br>
@endforeach


</body>
</html>