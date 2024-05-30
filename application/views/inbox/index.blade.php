@extends('include_backend/template_backend')

@php 
	$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container-fluid">
	<div class="card">
		<div class="card-body">
		<div class="mb-5">
			<h3>INBOX</h3>
			<p>Anda dapat meilhat kontak masuk pada halaman ini.</p>
		</div>
			{!! $table !!}
		</div>
	</div>
</div>

<div class="modal fade" id="modal_userDetail" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body" id="bodymodal_userDetail">
        <div align="center" id="loading_registration">
          <img src="{{ base_url() }}assets/img/ajax/ajax-loader-big.gif" alt="">
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')

<script>
    function showdata(id)
    {
      $('.modal-title').text('Detail Kontak Masuk');

        $.ajax({
            type: "post",
            url: "{{ base_url() }}inbox/data-inbox",
            data: "id="+id,
            dataType: "html",
            success: function (response) {
                $('#bodymodal_userDetail').empty();
                $('#bodymodal_userDetail').append(response);
            }
        });
    }
</script>

<script>
	function delete_inbox(id) {
		Swal.fire({
			title: 'Apakah anda yakin?',
			text: "Anda akan menghapus inbox ini.",
			icon: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, saya akan menghapusnya!',
			allowOutsideClick: false
		}).then((result) => {
			if (result.value) {


				$.ajax({
					url: "{{ base_url() }}InboxController/delete_inbox/" + id,
					type: "POST",
					dataType: "JSON",
					beforeSend: function() {
						Swal.fire({
							title: 'Memproses data',
							html: 'Mohon tunggu sebentar. Sistem sedang melakukan request anda.',
							allowOutsideClick: false,
							onOpen: () => {
								swal.showLoading()
							}
						});
					},
					success: function(data) {
						if (data.status) {

							window.location.href = "{{ base_url() }}inbox";

						} else {

						}


					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('Error deleting data');
					}
				});

			}
		});

	}
</script>



@endsection