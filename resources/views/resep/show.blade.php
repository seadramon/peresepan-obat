@extends('layouts.app', [
		'class' => '',
		'parentActive' => '',
		'elementActive' => 'resep'
])

@section('title', 'Hasil Pemeriksaan Pasien')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
@endsection

@section('content')
<div id="vue-app" v-cloak>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">
							Data Pasien
						</h3>

						<div class="card-tools">
              				<button type="button" class="btn btn-tool" data-card-widget="collapse">
                				<i class="fas fa-minus"></i>
              				</button>
            			</div>
					</div>

				  	<div class="card-body">
				  		<div class="row">
				  			<div class="col-md-6">
				  				<strong>Nama Pasien : </strong>
				                <p class="text-muted">
				                  {{ $data->nama_pasien }}
				                </p>

				                <strong>No.Handphone : </strong>
				                <p class="text-muted">
				                  {{ $data->nohp }}
				                </p>

				                <strong>Alamat : </strong>
				                <p class="text-muted">
				                  {{ $data->alamat }}
				                </p>	
				  			</div>
				  		</div>
				  	</div>
				  	<!-- /.card-body -->
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">
							Hasil Pemeriksaan
						</h3>

						<div class="card-tools">
              				<button type="button" class="btn btn-tool" data-card-widget="collapse">
                				<i class="fas fa-minus"></i>
              				</button>
            			</div>
					</div>

				  	<div class="card-body">
				  		<div class="row">
				  			<div class="col-md-6">
				  				<strong>Tanggal Pemeriksaan : </strong>
				                <p class="text-muted">
				                  {{ humandate($data->tgl_pemeriksaan, true) }}
				                </p>

				                <strong>Berkas Pemeriksaan Pasien : </strong>
				                <p class="text-muted">
				                  <a href="{{ asset('storage/' . $data->berkas) }}">Lihat Berkas</a>
				                </p>

				                <strong>Hasil Pemeriksaan : </strong>
				                <p class="text-muted">
				                  {{ $data->hasil_pemeriksaan }}
				                </p>


				                <strong>Resep : </strong>
				                <p class="text-muted">
				                  {{ $data->resep }}
				                </p>
				  			</div>

				  			<div class="col-md-6">
				  				<strong>Tanda-tanda vital : </strong>
				                <?php 
				                $tandavitals = json_decode($data->tanda_vital, true);
				                ?>
				                <table>
					                @foreach($tandavitals as $tandavital)
					                	<tr>
					                		<td>{{ $tandavital['tandavital'] }}</td>
					                		<td>:</td>
					                		<td>{{ $tandavital['pengukuran'] }}</td>
					                	</tr>
					                @endforeach
				                </table>
				  			</div>
				  		</div>
				  	</div>
				  	<!-- /.card-body -->
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">
							Buat Resep
						</h3>

						<div class="card-tools">
              				<button type="button" class="btn btn-tool" data-card-widget="collapse">
                				<i class="fas fa-minus"></i>
              				</button>
            			</div>
					</div>

				  	<div class="card-body">
				  		<div class="row">
				  			<div class="col-md-6">
				  				<div class="form-group">
									<label for="part_id">Nama Obat</label>
									<select class="form-control select2bs4" id="medicine" v-model="sel_medicine" required>
										<option value="">Pilih Obat : </option>
										<option  v-for="(row,idx) in medicines" :value="row.id + '#'  + row.name">@{{ row.name }}</option>
									</select>
								</div>
				  			</div>
				  			<div class="col-md-3">
				  				<div class="form-group">
						      		<label for="exampleInputEmail1">Jumlah</label>
						      		<input type="number" v-model="jumlah" class="form-control" id="jumlah" placeholder="Masukkan Jumlah Obat">
						    	</div>
				  			</div>
				  			<div class="col-md-3">
				  				<div style="margin-top: 33px;">
				  					<button @click.prevent="addMedicine()" :disabled="jumlah < 1" class="btn btn-primary">
										<span class="indicator-label" v-show="!is_loading">@{{ btnAdd }}</span>
										<span class="indicator-progress" v-show="is_loading">Please wait...
						                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
						                </span>
									</button>
				  				</div>
				  			</div>
				  			<div class="col-md-12">
	  							<table class="table table-bordered">
	  								<thead>
	  									<tr>
	  										<th>Obat</th>
	  										<th>Jumlah</th>
	  										<th>Harga Satuan</th>
	  										<th>Harga</th>
	  										<th>Action</th>
	  									</tr>
	  								</thead>
	  								<tbody>
	  									<tr v-for="(row, idx) in tmp_medicine">
	  				                        <td>@{{ row.obat }}</td>
	  				                        <td>@{{ row.jumlah }}</td>
	  				                        <td>@{{ row.harga_satuan }}</td>
	  				                        <td>@{{ row.harga }}</td>
	  				                        <td>
	  				                            <a href="javascript:void(0)" style="color: red;" @click.prevent="removeMedicine(idx)">Remove</a>
	  				                        </td>
	  				                    </tr>
	  									<tr class="text-muted" v-if="tmp_medicine.length < 1">
	  										<td colspan="5" style="text-align: center;">Data Kosong</td>
	  									</tr>
	  								</tbody>
	  								<tfoot>
	  									<tr>
	  				                    	<td colspan="3" style="text-align: right;">Total Harga</td>
	  				                    	<td colspan="2">Rp @{{ total }}</td>
	  				                    </tr>
	  								</tfoot>
	  							</table>
				  			</div>
				  		</div>
				  	</div>
				  	<!-- /.card-body -->

				  	<div class="card-footer">
				    	<button v-show="tmp_medicine.length > 0" @click.prevent="onSubmit()" class="btn btn-primary">
							<span class="indicator-label" v-show="!submit_loading">@{{ btnSubmit }}</span>
							<span class="indicator-progress" v-show="submit_loading">Please wait...
			                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
			                </span>
						</button>
				    	<a href="{{ route('resep.index') }}" class="btn btn-secondary">Batal</a>
				  	</div>

				</div>
			</div>
		</div>
	<form action="{{ route('hasil-pemeriksaan.store') }}" method="POST" name="" id="fpemeriksaan" enctype="multipart/form-data">
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
			msgError: '',
			data: {
				id:{!! json_encode($data->id ?? '') !!},
				tgl_pemeriksaan:{!! json_encode($data->tgl_pemeriksaan ?? '') !!},
			},
			err: {
				
			},
			medicines:{!! json_encode($medicines) !!},
			tmp_medicine: {!! json_encode($arrMedicine) ?? json_encode([]) !!},
			sel_medicine:'',
			jumlah: 0,
			is_loading: false,
			total: {!! json_encode($total) ?? 0 !!},
			btnSubmit: "Simpan",
			btnAdd: "Tambahkan",
			submit_loading: false,
		}
	}

	let app = new Vue({
		el: "#vue-app",
		data: function (){
			return initialState();
		},
		mounted: function() {
			this.$nextTick(this.initSelect2);
		},
		methods: {
			initSelect2: function (e) {
				var vm = this;

				$("#medicine").select2({
	            	theme: 'bootstrap4',
	            }).on('change', function () {
	                vm.sel_medicine = this.value;
	            });	  
			},
			addMedicine: function() {
				if (app.sel_medicine != "" && app.jumlah > 0) {
					app.is_loading = true

					const arrmedicine = app.sel_medicine.split("#")
		            let idmedicine = arrmedicine[0]
		            let namemedicine = arrmedicine[1]
		            let jumlah = app.jumlah

		            axios.get(
						"{{ url('resep/getprice') }}/" + idmedicine,
						{
							params: {
								"tgl_pemeriksaan": app.data.tgl_pemeriksaan,
							}
						}
					)
					.then(resp => {
						console.log(resp)
						let hargaSatuan = resp.data
						let harga = hargaSatuan * jumlah
						let tmp = {
							hasil_pemeriksaan_id : app.data.id,
							obat_id : idmedicine, 
							obat: namemedicine, 
							jumlah: jumlah, 
							harga_satuan: hargaSatuan,
							harga: harga
						}
		            	app.tmp_medicine.push(tmp)
		            	app.total += harga

		            	app.is_loading = false
					})
					.catch(err => {
		            	app.is_loading = false
					})
				}
			},
			removeMedicine(idx) {
				app.total -= app.tmp_medicine[idx].harga
	            app.tmp_medicine.splice(idx, 1)
	        },
	        onSubmit() {
	        	this.resetErrMsg()

	            let vm = this
				vm.submit_loading = true

				axios.post(
				"{{ route('resep.store') }}", {
	            	id: app.data.id,
	                reseps: app.tmp_medicine,
	                total: app.total
		        })
				.then(resp => {
					let response = resp.data

					if (response.result == "success") {
						flasher.success("Resep berhasil disimpan")

						/*setTimeout(() => {
							window.location.href = "{{ route('hasil-pemeriksaan.index')}}"
						}, 2000)*/
					} else {
						flasher.error("Resep gagal disimpan")
					}
					app.submit_loading = false
				})
				.catch(err => {
					app.submit_loading = false
					flasher.error("Resep gagal disimpan")
				})
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