@php 
	$ci = get_instance();
@endphp
<div id="kt_header" class="header header-fixed">
	<div class="container-fluid d-flex align-items-stretch justify-content-between">
		<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
			<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
				<div class="mt-3">
				</div>
			</div>
		</div>
		<div class="topbar">
			@php
			$user_id = $ci->session->userdata('user_id');
            $user_now = $ci->ion_auth->user($user_id)->row();
			@endphp
			<div class="topbar-item">
				<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
					<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
					<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ $user_now->first_name }} {{ $user_now->last_name }}</span>
					<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
						<span class="symbol-label font-size-h5 font-weight-bold">{{ substr($user_now->first_name, 0, 1) }} {{ substr($user_now->last_name, 0, 1) }}</span>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>