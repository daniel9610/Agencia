@if(count($errors)>0)
	<div class="alert alert-danger">
		<p>Tienes {{count($errors)}} error(es)</p>
		<ul>
			@foreach($errors->all() as $error)
			<li>{{$error}}</li>
			@endforeach
		</ul>
	</div>
@endif