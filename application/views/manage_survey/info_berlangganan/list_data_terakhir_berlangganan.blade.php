@php 
	$ci = get_instance();
@endphp

<div class="card">
	<div class="card-header font-weight-bold">
		Current Subscription
	</div>
	<div class="card-body">
		
		<div class="row">
            <div class="col-md-6">
                
                <p>
                    <label>Nama Paket</label><br>
                    <span class="font-weight-bold">{{ $last_payment->nama_paket }}</span>
                </p>

                <p>
                    <label>Deskripsi</label><br>
                    <span class="font-weight-bold">{!! $last_payment->deskripsi_paket !!}</span>
                </p>

                <p>
                    <label>Lama Berlangganan</label><br>
                    <span class="font-weight-bold">{{ $last_payment->panjang_hari }} Hari</span>
                </p>

                <p>
                    <label>Harga Paket</label><br>
                    <span class="font-weight-bold">{{ $last_payment->harga_paket }}</span>
                </p>

                <p>
                    <label>Tanggal Pembelian</label><br>
                    <span class="font-weight-bold">{{ date('d-m-Y', strtotime($last_payment->tanggal_mulai)) }}</span>
                </p>

            </div>

            <div class="col-md-6">
                
                <p>
                    <label>Jumlah User</label><br>
                    <span class="font-weight-bold">{{ $last_payment->jumlah_user }}</span>
                </p>

                <p>
                    <label>Jumlah Kuesioner</label><br>
                    <span class="font-weight-bold">{{ $last_payment->jumlah_kuesioner }}</span>
                </p>

                <p>
                    <label>Status Paket</label><br>
                    <span>{!! $status_paket !!}</span>
                </p>

                <p>
                    <label>Tanggal Jatuh Tempo</label><br>
                    <span class="font-weight-bold text-danger">{!! $status_jatuh_tempo !!}</span>

                </p>

            </div>
        </div>

	</div>
</div>