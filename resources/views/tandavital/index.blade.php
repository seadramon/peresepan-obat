@extends('layouts.app', [
		'class' => '',
		'parentActive' => 'master',
		'elementActive' => 'tanda-vital'
])

@section('title', 'List Tanda Vital')

@section('content')
<div class="card">
	<div class="card-header">
		<div class="card-title">
			<a href="{{ route('tanda-vital.create') }}" class="btn btn-block btn-primary">Tambah Baru</a>
		</div>
		<div class="card-tools">
			<form action="{{ route('tanda-vital.index') }}" method="get">
			<div class="input-group input-group-sm" style="width: 200px;">
	            <input type="text" name="search" class="form-control float-right" placeholder="Search">

	            <div class="input-group-append">
	            	<button type="submit" class="btn btn-default">
	                	<i class="fas fa-search"></i>
	              	</button>
	              	<a href="{{ route('tanda-vital.index') }}" type="submit" class="btn btn-default">
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
			  		<th>Tanda</th>
			  		<th>Action</th>
				</tr>
		  	</thead>
		  	<tbody>
		  		@if (count($data) > 0)
			  		@foreach($data as $row)
						<tr>
					  		<td>{{ $row->tanda }}</td>
					  		<td>
					  			<a href="{{ route('tanda-vital.edit', $row->id) }}" alt="Edit Tanda Vital"><i class="far fa-edit"></i></a>
					  			&nbsp;
					  			<a href="#" data-href="{{ route('tanda-vital.delete', $row->id) }}" data-toggle="modal" data-target="#confirm-delete"><i class="fas fa-trash-alt"></i></a>
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
        
            <div class="modal-body">
                <p>Apakah Anda yakin akan menghapus Tanda Vital ini?</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>
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