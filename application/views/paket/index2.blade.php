@extends('include_backend/template_backend')

@php 
	$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')
<div class="container">
	<div class="text-right mb-5">	
	@php
		echo anchor(base_url().'paket/add', 'Buat Paket Baru', ['class' => 'btn btn-primary font-weight-bold shadow-lg']);
	@endphp
	</div>

	<div class="row">

		
	@foreach ($paket->result() as $value)
	<div class="col-md-6">

		<div class="card mb-5" data-aos="fade-up">
		  <img src="{{ base_url() }}assets/themes/metronic/assets/media/bg/bg-9.jpg" class="card-img-top" alt="...">
		  <div class="card-body">
		    <h5 class="card-title text-primary">{{ $value->nama_paket }}</h5>
		    <p class="card-text">{{ $value->deskripsi_paket }}</p>
		    <p class="card-text">Harga Paket : Rp. {{ number_format($value->harga_paket,2,',','.') }}</p>
		    <p class="card-text">Panjang Hari : {{ $value->panjang_hari }}</p>
		    <div class="text-right">
		    	@php
		    		$cek_paket = $ci->db->get_where('berlangganan', ['id_paket' => $value->id]);
		    	@endphp
		    	@if ($cek_paket->num_rows() == 0)
		    		<a href="{{ base_url() }}paket/edit/{{ $value->id }}" class="btn btn-light-primary font-weight-bold shadow-lg">Edit paket ini</a>
		    		<a href="javascript:void(0)" class="btn btn-light-primary font-weight-bold shadow-lg" onclick="delete_data({{ $value->id }})">Delete</a>
		    	@endif
		    </div>
		  </div>
		</div>
		
	</div>

	@endforeach
	</div>
</div>
@endsection

@section('javascript')
<script>
function delete_data(id) {
    if (confirm('Are you sure delete this data?')) {
        $.ajax({
            url: "{{ base_url() }}paket/delete/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {

                    // Swal.fire(
                    //     'Informasi',
                    //     'Berhasil menghapus data',
                    //     'success'
                    // );

                   	window.location.href = "{{ base_url() }}paket";

                   	alert("Paket berhasil dihapus");

                } else {
                    Swal.fire(
                        'Informasi',
                        'Hak akses terbatasi. Bukan akun administrator.',
                        'warning'
                    );
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error deleting data');
            }
        });

    }
}
</script>
@endsection