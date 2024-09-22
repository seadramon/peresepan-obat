@extends('layouts.app', [
		'class' => '',
		'parentActive' => '',
		'elementActive' => 'hasil-pemeriksaan'
])

@section('title', 'Pemeriksaan Pasien')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
@endsection

@section('content')
<div id="vue-app" v-cloak>
	<form action="{{ route('hasil-pemeriksaan.store') }}" method="POST" name="" id="fpemeriksaan" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-6">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">
							Form Data Pasien
						</h3>
					</div>

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
							<label for="part_id">Sudah pernah berobat ? </label>
							<select class="form-control select2bs4" id="sel_sudahpernah" v-model="sel_sudahpernah" required>
								<option value="">Pilih : </option>
								<option value="belum">Belum </option>
								<option value="sudah">Sudah </option>
							</select>
							<span class="msg-error">@{{ err.sudahpernah }}</span>
						</div>

						<template v-if="sel_sudahpernah != ''">
					  		<div class="form-group" v-if="sel_sudahpernah == 'belum'">
					      		<label for="exampleInputEmail1">Nama Pasien <span class="redf">*</span></label>
					      		<input type="text" v-model="data.nama_pasien" class="form-control" id="sel_namapasien" placeholder="Masukkan Nama Pasien">
					      		<span class="msg-error">@{{ err.nama_pasien }}</span>
					    	</div>
					    	<div class="form-group" v-if="sel_sudahpernah == 'sudah'">
					      		<label for="exampleInputEmail1">Nama Pasien <span class="redf">*</span></label>
					      		<select class="form-control select2bs4" id="nama_pasien" v-model="data.nama_pasien" required>
									<option value="">Pilih Pasien : </option>
									<option  v-for="(row,idx) in pasiens" :value="row.nama_pasien + '#' + row.nohp + '#' + row.alamat">@{{ row.nama_pasien }}</option>
								</select>
					      		<span class="msg-error">@{{ err.nama_pasien }}</span>
					    	</div>
					    	<div class="form-group">
					      		<label for="exampleInputEmail1">No Handphone <span class="redf">*</span></label>
					      		<input type="text" v-model="data.nohp" class="form-control" id="nohp" placeholder="Masukkan No Handphone">
					      		<span class="msg-error">@{{ err.nohp }}</span>
					    	</div>
					    	<div class="form-group">
					      		<label for="exampleInputEmail1">Alamat <span class="redf">*</span></label>
					      		<textarea v-model="data.alamat" placeholder="Masukkan Alamat" id="alamat" class="form-control"></textarea>
					      		<span class="msg-error">@{{ err.alamat }}</span>
					    	</div>
						</template>
				  	</div>
				  	@{{ pasiens }}
				  	<!-- /.card-body -->
				</div>
			</div>
			<div class="col-md-6">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">
							Tanda-tanda vital
						</h3>
					</div>

					<div class="card-body">
				    	<div class="form-group">
							<label for="part_id">Tanda Vital</label>
							<select class="form-control select2bs4" id="tandavital" v-model="sel_tandavital" required>
								<option value="">Pilih Tanda vital : </option>
								<option  v-for="(row,idx) in tandavitals" :value="row.tanda">@{{ row.tanda }}</option>
							</select>
						</div>
						<div class="form-group">
				      		<label for="exampleInputEmail1">Hasil Pengukuran</label>
				      		<input type="text" class="form-control" id="pengukuran" v-model="pengukuran" placeholder="Masukkan Hasil Pengukuran">
				    	</div>
						<!-- </div> -->
						<div class="form-group">
		               		<a href="javascript:void(0)" @click.prevent="addPengukuran"  class="btn btn-info">Tambah</a>
		               	</div>

						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Tanda Vital</th>
									<th>Hasil Pengukuran</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(row, idx) in tmp_pengukuran">
			                        <td>@{{ row.tandavital }}</td>
			                        <td>@{{ row.pengukuran }}</td>
			                        <td>
			                            <a href="javascript:void(0)" style="color: red;" @click.prevent="removePengukuran(idx)">Remove</a>
			                        </td>
			                    </tr>
								<tr class="text-muted" v-if="tmp_pengukuran.length < 1">
									<td colspan="3" style="text-align: center;">Data Kosong</td>
								</tr>
							</tbody>
						</table>
						<span class="msg-error">@{{ err.tandavital }}</span>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">
							Hasil Pemeriksaan
						</h3>
					</div>

					<div class="card-body">
						<div class="form-group">
				      		<label for="exampleInputEmail1">Tanggal Pemeriksaan <span class="redf">*</span></label>
				      		<input type="text" v-model="data.tgl_pemeriksaan" id="tgl_pemeriksaan" class="form-control daterange">
				      		<span class="msg-error">@{{ err.tgl_pemeriksaan }}</span>
				    	</div>

				    	<div class="form-group">
				      		<label for="exampleInputEmail1">Hasil Pemeriksaan <span class="redf">*</span></label>
				      		<textarea v-model="data.hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control"></textarea>
				      		<span class="msg-error">@{{ err.hasil_pemeriksaan }}</span>
				    	</div>

				    	<div class="form-group">
				    		<label for="customFile">Berkas Pemeriksaan Pasien</label>

		                    <div class="custom-file">
		                      	<input type="file" name="berkas" @change="onFileChange" class="form-control" id="customFile">
		                    </div>
			                @if ($data?->berkas)
			                	<a href="{{ asset('storage/' . $data->berkas) }}" target="_blank">Lihat Berkas</a>
			                @endif
		                </div>

		                <div class="form-group">
				      		<label for="exampleInputEmail1">Resep <span class="redf">*</span></label>
				      		<textarea v-model="data.resep" id="resep" class="form-control"></textarea>
				      		<span class="msg-error">@{{ err.resep }}</span>
				    	</div>
					</div>

					<div class="card-footer">
				    	<button @click.prevent="onSubmit()" class="btn btn-primary">
							<span class="indicator-label" v-show="!is_loading">@{{ btnSubmit }}</span>
							<span class="indicator-progress" v-show="is_loading">Please wait...
			                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
			                </span>
						</button>
				    	<a href="{{ route('hasil-pemeriksaan.index') }}" class="btn btn-secondary">Batal</a>
				  	</div>
				</div>
			</div>
		</div>
		
	</form>
</div>
@endsection

@section('extra-js')

@if(App::environment('production'))
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
@else
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
@endif
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>

<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/plugins/filepond/filepond-plugin-file-validate-type.js')}}"></script>
<script src="{{asset('assets/plugins/filepond/filepond.min.js')}}"></script>

<script src="{{asset('assets/js/blockUi.js')}}"></script>

<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>

<script type="text/javascript">
	function initialState (){
		return {
			alertError:false,
			alertSuccess:false,
			tandavitals:{!! json_encode($tandavitals) !!},
			pasiens:{!! json_encode($pasiens) !!},
			msgError: '',
			data: {
				id:{!! json_encode($data->id ?? '') !!},
				nama_pasien:{!! json_encode($data->nama_pasien ?? '') !!},
				nohp:{!! json_encode($data->nohp ?? '') !!},
				alamat:{!! json_encode($data->alamat ?? '') !!},
				tgl_pemeriksaan:{!! json_encode($data->tgl_pemeriksaan ?? date('Y-m-d H:i')) !!},
				hasil_pemeriksaan:{!! json_encode($data->hasil_pemeriksaan ?? '') !!},
				resep:{!! json_encode($data->resep ?? '') !!},
				berkas: {!! json_encode($data->berkas ?? '') !!}
			},
			err: {
				nama_pasien:'',
				nohp:'',
				alamat:'',
				tgl_pemeriksaan:'',
				hasil_pemeriksaan:'',
				resep:'',
				tandavital:'',
				sudahpernah:''
			},
			sel_tandavital:'',
			sel_sudahpernah:'',
			sel_namapasien:'',
			tmp_pengukuran: {!! $data->tanda_vital ?? json_encode([]) !!},
			is_loading: false,
			pengukuran: '',
			btnSubmit: "Simpan",
		}
	}

	let app = new Vue({
		el: "#vue-app",
		data: function (){
			return initialState();
		},
		mounted: function() {
			this.$nextTick(this.initSelect2);
			this.$nextTick(this.initDateRangePicker);
		},
		methods: {
			initDateRangePicker: function(e) {
				$('.daterange').daterangepicker({
					timePicker: true,
					timePicker24Hour:true,
					singleDatePicker: true,
					startDate: app.data.tgl_pemeriksaan,
					drops: 'up',
					locale: {
						format: 'YYYY-MM-DD HH:mm'
					}
				})
				.on('apply.daterangepicker', function (ev, picker) {
					app.data.tgl_pemeriksaan = picker.startDate.format('YYYY-MM-DD HH:mm');
				})
			},
			initSelect2: function (e) {
				var vm = this;

				$("#tandavital").select2({
	            	theme: 'bootstrap4',
	            }).on('change', function () {
	                vm.sel_tandavital = this.value;
	            });	

	            $("#sel_namapasien").select2({
	            	theme: 'bootstrap4',
	            }).on('change', function () {
	                vm.sel_namapasien = this.value;
	            });	

	            $("#sel_sudahpernah").select2({
	            	theme: 'bootstrap4',
	            }).on('change', function () {
	                vm.sel_sudahpernah = this.value;
	            });	  
			},
			onFileChange(e) {
		      	app.data.berkas = e.target.files[0];
		    },
			addPengukuran: function() {
				if (app.sel_tandavital != "") {
		            let tandavital = app.sel_tandavital
		            let pengukuran = app.pengukuran

		            let tmp = {tandavital : tandavital, pengukuran: pengukuran}
		            console.log(tmp)
		            app.tmp_pengukuran.push(tmp)
				}
			},
			removePengukuran(idx) {
	            app.tmp_pengukuran.splice(idx, 1)
	        },
	        checkForm: function() {
	        	let vm = this
				let countErr = 0
				let exception = ['pengukuran', 'berkas', 'id', 'sudahpernah']
				
				$.each(vm.data,function(index, value){
					if (exception.includes(index) == false) {
						if (value == "") {
							vm.err[index] = "Kolom ini wajib diisi"
							countErr = countErr + 1
						}
					}
				});

				if (vm.tmp_pengukuran.length == 0) {
					vm.err['tandavital'] = "Tanda-tanda vital wajib diisi"
					countErr = countErr + 1
				}

				if (vm.sel_sudahpernah == "") {
					vm.err['sudahpernah'] = "Data pasien wajib diisi"
					countErr = countErr + 1	
				}

				if (countErr > 0) {
					return false
				}

				return true
	        },
	        onSubmit() {
	        	this.resetErrMsg()

	            let vm = this
	            if (app.checkForm()) {
					vm.is_loading = true

					let formData = new FormData()
					
					$.each(vm.data, function (key, val) {
						formData.append(key, val)
					})
					formData.append('berkas', vm.data.berkas)
					formData.append('tanda_vital', JSON.stringify(vm.tmp_pengukuran))

					axios.post(
						"{{ route('hasil-pemeriksaan.store') }}", formData, {
							headers: {
					            'Content-Type': 'multipart/form-data'
					        },
						}
					)
					.then(resp => {
						let response = resp.data

						if (response.result == "success") {
							flasher.success("Hasil Pemeriksaan berhasil disimpan")

							setTimeout(() => {
								window.location.href = "{{ route('hasil-pemeriksaan.index')}}"
							}, 2000)
						} else {
							$.each(response.errors, function (key, val) {
								vm.err[key] = val[0]
							})
							flasher.error("Hasil Pemeriksaan gagal disimpan")
						}
						app.is_loading = false
					})
					.catch(err => {
						app.is_loading = false
						flasher.error("Hasil Pemeriksaan gagal disimpan")
					})
	            }
	        },
	        resetErrMsg() {
				let vm = this

				$.each(vm.err,function(index, value){
					vm.err[index] = ""
				})
			},
			reset() {
				Object.assign(this.$data, initialState());
			}
		}
	})
</script>
@endsection