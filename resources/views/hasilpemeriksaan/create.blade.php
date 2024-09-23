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
			<div class="col-md-7">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">
							Hasil Pemeriksaan
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
				      		<label for="exampleInputEmail1">Nama Pasien <span class="redf">*</span></label>
				      		<select class="form-control select2bs4" id="sel_namapasien" v-model="data.pasien_id" required>
								<option value="">Pilih Pasien : </option>
								<option  v-for="(row,idx) in pasiens" :value="row.id">@{{ row.nama_pasien }}</option>
							</select>
				      		<span class="msg-error">@{{ err.pasien_id }}</span>
				    	</div>
				    	
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

			<div class="col-md-5">
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
			                            <a href="javascript:void(0)" style="color: red;" @click.prevent="removePengukuran(idx)"><i class="fas fa-trash-alt"></i></a>
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
				pasien_id:{!! json_encode($data->pasien_id ?? '') !!},
				tgl_pemeriksaan:{!! json_encode($data->tgl_pemeriksaan ?? date('Y-m-d H:i')) !!},
				hasil_pemeriksaan:{!! json_encode($data->hasil_pemeriksaan ?? '') !!},
				resep:{!! json_encode($data->resep ?? '') !!},
				berkas: {!! json_encode($data->berkas ?? '') !!}
			},
			err: {
				pasien_id:'',
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
	                vm.data.pasien_id = this.value;
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