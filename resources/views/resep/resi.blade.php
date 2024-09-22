<html>
    <head>
        <style>
            body {
                font-size: 11px;
                font-family: arial;
            }

            .tengah {
                text-align: center;
                font-weight: bold;
            }

            table.content {
                table-layout: auto; 
                width:100%;
                border-collapse: collapse;
            }

            .content table, .content th, .content td {
                border: 1px solid;
                padding-left: 5px: 
                margin-bottom: 10px;
            }
            @page { margin:50px 25px 60px 25px; }
            header { margin-bottom: 30px; }
            /* footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; } */
            hr.new1 {
              border-top: 1px dotted black;
            }
            main {
            	margin: 20px;
            	font-size: 15px;
            }
        </style>
    </head>

    <body>
        <header>
            <div style="width: 100%;text-align: center;font-size: 20px;font-weight: 500;">
            	RS ANWAR MEDIKA
            </div>
            <div style="text-align: center;margin-top: 5px;font-size: 13px;">
            	Jl. Bypass Krian No.KM. 33, Semawut, Balongbendo, Kec. BalongBendo, Kabupaten Sidoarjo, Jawa Timur 61262
            </div>
        </header>

        <main>
            <table width="100%">
            	<tr>
            		<td>No.Resi</td>
            		<td>:</td>
            		<td>{{ date('Y/m/d') . rand(1000, 9999) }}</td>
            	</tr>
            	<tr>
            		<td>Spesialisasi</td>
            		<td>:</td>
            		<td>{{ $data->dokter->spesialisasi }}</td>
            	</tr>
            	<tr>
            		<td>Tanggal Pemeriksaan</td>
            		<td>:</td>
            		<td>{{ humandate($data->tgl_pemeriksaan) }}</td>
            	</tr>
            	<tr>
            		<td>No.RM</td>
            		<td>:</td>
            		<td></td>
            	</tr>
            	<tr>
            		<td>Nama Pasien</td>
            		<td>:</td>
            		<td>{{ $data->nama_pasien }}</td>
            	</tr>
            	<tr>
            		<td>Alamat Pasien</td>
            		<td>:</td>
            		<td>{{ $data->alamat }}</td>
            	</tr>
            	<tr>
            		<td>Dokter</td>
            		<td>:</td>
            		<td>{{ $data->dokter->nama }}</td>
            	</tr>
            </table>

            <table class="content">
                <thead style="text-align: center">
                    <tr>
                    	<th>No</th>
                        <th>Obat</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                	<?php $i = 1; ?>
                	@foreach($data->resepApoteker as $row)
	                    <tr>
	                    	<td>
	                    		{{ $i }}
	                    	</td>
	                    	<td>
	                    		{{ $row->obat }}
	                    	</td>
	                    	<td>
	                    		{{ $row->jumlah }}
	                    	</td>
	                    	<td>
	                    		{{ $row->harga }}
	                    	</td>
	                    </tr>
	                    <?php $i++; ?>
	                @endforeach
                </tbody>
                <tfoot>
                	<tr>
                		<td colspan="3">Total</td>
                		<td>
                			{{$data->resepApoteker->sum('harga')}}
                		</td>
                	</tr>
                </tfoot>
            </table>

            <table width="100%">
            	<tr>
            		<td>Terbilang</td>
            		<td>:</td>
            		<td>
            			{{ terbilang($data->resepApoteker->sum('harga')) . ' Rupiah' }}
            		</td>
            	</tr>
            </table>
        </main>

    </body>
</html>