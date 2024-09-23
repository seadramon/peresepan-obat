@extends('layouts.app', [
		'class' => '',
		'parentActive' => 'user',
		'elementActive' => 'apoteker'
])

@section('title', 'List Apoteker')

@section('content')
<div class="card">
	<div class="card-header">
		<div class="card-title">
			<a href="{{ route('apoteker.create') }}" class="btn btn-block btn-primary">Tambah Baru</a>
		</div>
		<div class="card-tools">
			<form action="{{ route('apoteker.index') }}" method="get">
			<div class="input-group input-group-sm" style="width: 200px;">
	            <input type="text" name="search" class="form-control float-right" placeholder="Search">

	            <div class="input-group-append">
	            	<button type="submit" class="btn btn-default">
	                	<i class="fas fa-search"></i>
	              	</button>
	              	<a href="{{ route('apoteker.index') }}" type="submit" class="btn btn-default">
	                	<i class="fas fa-sync-alt"></i>
	              	</a>
	            </div>
          	</div>
          </form>
		</div>
	</div>
	<div class="card-body">
		<!-- Notifikasi -->
		@if (Session::has('error'))
		    <div class="alert alert-danger alert-styled-right alert-dismissible">
		        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		        {{ Session::get('error', 'Error') }}
		    </div>
		@endif
		@if (Session::has('success'))
		    <div class="alert alert-success alert-styled-right alert-arrow-right alert-dismissible">
		        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		        {{ Session::get('success', 'Success') }}
		    </div>
		@endif
		<!-- ./notifikasi -->

		<table class="table table-bordered">
		  	<thead>
				<tr class="table-primary">
			  		<th>Nama</th>
			  		<th>No.Hp</th>
			  		<th>Email</th>
			  		<th>No.STRA</th>
			  		<th>Action</th>
				</tr>
		  	</thead>
		  	<tbody>
		  		@if (count($data) > 0)
			  		@foreach($data as $row)
						<tr>
					  		<td>{{ $row->nama }}</td>
					  		<td>{{ $row->nohp }}</td>
					  		<td>{{ $row->account->email }}</td>
					  		<td>{{ $row->nomor_stra }}</td>
					  		<td>
					  			<a href="{{ route('apoteker.edit', $row->id) }}" alt="Edit Tanda Vital"><i class="far fa-edit"></i></a>
					  		</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="3">Data tidak ditemukan</td>
					</tr>
				@endif
		  	</tbody>
		</table>

	</div>
	<!-- /.card-body -->
	<div class="card-footer clearfix">
		{{ $data->links('pagination.default') }}
		<p>Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries</p>
	</div>
	<!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection

@section('extra-js')
<script type="text/javascript">
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));        
    });

    $('#confirm-reset').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok-reset').attr('href', $(e.relatedTarget).data('href'));        
    });
</script>
@endsection