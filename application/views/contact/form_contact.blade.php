@extends('include_backend/template_no_aside')

@php 
	$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">
    	<div class="card">
    		<div class="card-header text-center">
					<h1>Hubungi Kami</h1>
				</div>
    		<div class="card-body">
    			<p class="text-center">
									Anda bisa menghubungi kami mengenai paket pembelian atau hal lain melalui form kontak dibawah ini.<br>Tim kami akan segera menanggapi pesan anda.
								</p><br><br>


							{!! form_open($form_action, ['id' => 'confirmation_form']) !!}
							<div class="mb-3">
							  <label for="conNama" class="form-label font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
							  {!! form_input($conNama) !!}
							</div>
							<div class="mb-3">
							  <label for="conEmail" class="form-label font-weight-bold">Email <span class="text-danger">*</span></label>
							  {!! form_input($conEmail) !!}
							</div>
							<div class="mb-3">
							  <label for="conTelp" class="form-label font-weight-bold">Telepon</label>
							  {!! form_input($conTelp) !!}
							</div>
							<div class="mb-3">
							  <label for="conOrganisasi" class="form-label font-weight-bold">Nama Organisasi</label>
							  {!! form_input($conOrganisasi) !!}
							</div>
							<div class="mb-3">
							  <label for="conSubject" class="form-label font-weight-bold">Perihal <span class="text-danger">*</span></label>
							  {!! form_input($conSubject) !!}
							</div>
							<div class="mb-3">
							  <label for="conMessage" class="form-label font-weight-bold">Pesan <span class="text-danger">*</span></label>
							  {!! form_textarea($conMessage) !!}
							</div>
							<br>
							<div class="mt-5 mb-3">
								<div id="error_captcha"></div>
	    						<span id="captImg">{!! $gambar_captcha !!}</span> <a href="javascript:void(0);" class="refreshCaptcha" title="Ubah Captcha"><i class="fas fa-sync"></i></a>
							  <br>
							  <label for="kodeCaptcha" class="form-label font-weight-bold mt-5">Captcha *</label>
							  {!! form_input($kodeCaptcha) !!}
							  
							</div>
							
							<div class="text-end mt-5">
								<br><br><br>
								<button type="submit" class="btn btn-info btn-block font-weight-bold shadow btn-lg" id="sendConfirm">Kirimkan Pesan</button>
							</div>
							
							{!! form_close() !!}

    		</div>
    	</div>
    </div>
  </div>
</div>




<div class="modal fade" id="modalInformasi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('javascript')

<script>
$(document).ready(function(){

	$('#confirmation_form').on('submit', function(event){

		event.preventDefault();

		$.ajax({
		url:       "{{ base_url() }}contact/validate-message",
		method:    "POST",
		data:      $(this).serialize(),
		dataType:  "json",

		beforeSend:function(){

			// $('#sendConfirm').attr('disabled', 'disabled');
			// $("#form-contact").addClass("bg-blur");
			// document.getElementById("confirmation_form").style.cursor = "wait";

			Swal.fire({
				title: 'Memproses data',
				html: 'Mohon tunggu sebentar. Sistem sedang melakukan request anda.',
				allowOutsideClick: false,
				onOpen: () => {
					swal.showLoading()
				}
			});

		},
		success:function(data){

			if(data.success){

				$('#confirmation_form')[0].reset();
				$('#message').html(data.success);

				// $('#sendConfirm').attr('disabled', false);
				// $("#form-contact").removeClass("bg-blur");
				// document.getElementById("confirmation_form").style.cursor = "default";

				$('#error_captcha').html('');
				reloadCaptcha();

				Swal.fire({
				  type: 'success',
				  icon: "success",
				  title: 'Pesan anda berhasil dikirim',
				  text: 'Kami akan segera menindaklanjuti pesan dari anda melalui kontak yang Anda cantumkan.',
				  allowOutsideClick: false
				});

				// $('#staticBackdropLabel').html('Informasi');
				// $('.modal-body').html('<div class="alert alert-primary" role="alert"><h4 class="alert-heading"><i class="far fa-paper-plane"></i> Well done!</h4><p>Sukses, pesan yang anda kirimkan telah di inbox kami.</p><hr><p class="mb-0">Kami akan segera menindaklanjuti pesan dari anda melalui kontak yang Anda cantumkan.</p></div>');
				// $('#modalInformasi').modal('show');


			}

			if(data.error){
				$('#error_captcha').html(data.error);
				$("#form-contact").removeClass("bg-blur");
				document.getElementById("confirmation_form").style.cursor = "default";
				$('#sendConfirm').attr('disabled', false);
				reloadCaptcha();

				Swal.fire({
				  icon: "error",
				  title: 'Error',
				  text: data.message,
				  allowOutsideClick: false
				});

		    }
			
		}

		});

	});

	$('.refreshCaptcha').on('click', function(){
      $.get("{{ base_url() }}contact/refresh-captcha", function(data){
        $('#captImg').html(data);
      });
    });


});

	function reloadCaptcha(){
		$.get("{{ base_url() }}contact/refresh-captcha", function(data){
			$('#captImg').html(data);
		});
	}
</script>

@endsection