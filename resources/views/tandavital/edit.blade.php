@extends('layouts.app', [
		'class' => '',
		'parentActive' => 'master',
		'elementActive' => 'tanda-vital'
])

@section('title', 'Master Tanda Vital')

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">
			Edit Tanda Vital
		</h3>
	</div>

	<form action="{{ route('tanda-vital.update', $id) }}" method="POST">
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
	      		<label for="exampleInputEmail1">Tanda <span class="redf">*</span></label>
	      		<input type="text" name="tanda" class="form-control" id="tanda" value="{{ $data?->tanda }}" placeholder="Masukkan Tandanya">
	    	</div>
	  	</div>
	  	<!-- /.card-body -->

	  	<div class="card-footer">
	    	<button type="submit" class="btn btn-primary">Submit</button>
	    	<a href="{{ route('tanda-vital.index') }}" class="btn btn-secondary">Cancel</a>
	  	</div>
	</form>
</div>
<!-- /.card -->
@endsection