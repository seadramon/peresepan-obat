@extends('layouts.app', [
		'class' => '',
		'parentActive' => 'master',
		'elementActive' => 'pasien'
])

@section('title', 'Master Pasien')

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">
			Edit Pasien
		</h3>
	</div>

	<form action="{{ route('pasien.update', $id) }}" method="POST">
		@method('PUT')
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
	      		<label for="exampleInputEmail1">Nama Pasien <span class="redf">*</span></label>
	      		<input type="text" name="nama_pasien" class="form-control" id="nama_pasien" value="{{ $data?->nama_pasien }}" placeholder="Masukkan Nama Pasien">
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">No.Handphone <span class="redf">*</span></label>
	      		<input type="text" name="nohp" class="form-control" id="nohp" value="{{ $data?->nohp }}" placeholder="Masukkan No.Handphone">
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Alamat <span class="redf">*</span></label>
	      		<input type="text" name="alamat" class="form-control" id="alamat" value="{{ $data?->alamat }}" placeholder="ALamat">
	    	</div>
	  	</div>
	  	<!-- /.card-body -->

	  	<div class="card-footer">
	    	<button type="submit" class="btn btn-primary">Submit</button>
	    	<a href="{{ route('pasien.index') }}" class="btn btn-secondary">Cancel</a>
	  	</div>
	</form>
</div>
<!-- /.card -->
@endsection