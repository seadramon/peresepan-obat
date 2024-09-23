@extends('layouts.app', [
		'class' => '',
		'parentActive' => 'user',
		'elementActive' => 'apoteker'
])

@section('title', 'Akun Apoteker')

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">
			Form Apoteker
		</h3>
	</div>

	<form action="{{ route('apoteker.store') }}" method="POST">
		@csrf
	  	<div class="card-body">
	  		@if (count($errors) > 0)
				@foreach($errors->all() as $error)
					<div class="alert alert-danger alert-styled-right alert-dismissible">
			            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
			            {{ $error }}
			        </div>
				@endforeach
			@endif

	  		<div class="form-group">
	      		<label for="exampleInputEmail1">Nama <span class="redf">*</span></label>
	      		<input type="text" name="nama" class="form-control" id="nama">
	    	</div>
	    	<div class="form-group">
	      		<label for="exampleInputEmail1">No.Handphone <span class="redf">*</span></label>
	      		<input type="text" name="nohp" class="form-control" id="nohp">
	    	</div>
	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Alamat <span class="redf">*</span></label>
	      		<textarea name="alamat" class="form-control"></textarea>
	    	</div>
	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Nomor STRA <span class="redf">*</span></label>
	      		<input type="text" name="nomor_stra" class="form-control" id="nomor_izin_praktek">
	    	</div>
	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Email <span class="redf">*</span></label>
	      		<input type="email" name="email" class="form-control" id="email">
	    	</div>
	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Password <span class="redf">*</span></label>
	      		<input type="password" name="password" class="form-control" id="password">
	    	</div>
	  	</div>
	  	<!-- /.card-body -->

	  	<div class="card-footer">
	    	<button type="submit" class="btn btn-primary">Submit</button>
	    	<a href="{{ route('apoteker.index') }}" class="btn btn-secondary">Cancel</a>
	  	</div>
	</form>
</div>
<!-- /.card -->
@endsection