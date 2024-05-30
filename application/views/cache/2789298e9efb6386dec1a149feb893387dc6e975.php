<?php
$ci = get_instance();
$user_id = $ci->session->userdata('user_id');
$user_now = $ci->ion_auth->user($user_id)->row();
?>

<?php if($ci->session->userdata('aside_minimize') == '2'): ?>
<div class="text-center mt-5">
    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
        <!-- <div class="text-center symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center"> -->
        <?php if($user_now->foto_profile == NULL): ?>
        <!-- <div class="symbol-label" style="background-image:url('<?php echo e(base_url()); ?>assets/klien/foto_profile/200px.jpg')"></div> -->

        <img class="" src="<?php echo e(base_url()); ?>assets/klien/foto_profile/200px.jpg" alt="">
        <?php else: ?>
        <img class="" src="<?php echo e(base_url()); ?>assets/klien/foto_profile/<?php echo $user_now->foto_profile ?>" alt="">
        <?php endif; ?>
        <i class="symbol-badge bg-success"></i>
    </div>
</div>
<?php endif; ?>

<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
        data-menu-dropdown-timeout="500">
        <ul class="menu-nav">

            <?php
            ($ci->uri->segment(1) == 'dashboard') ? $child_menu_active = 'menu-item-active' : $child_menu_active = ''
            ?>

            <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                <a href="<?php echo e(base_url()); ?>dashboard" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                    fill="#000000" fill-rule="nonzero" />
                                <path
                                    d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <!---------------------------------------- ADMINISTRATOR ----------------------------------------------->
            <?php
            $group = array('admin')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>

            <?php
            ($ci->uri->segment(1) == 'inbox') ? $child_menu_active = 'menu-item-active' : $child_menu_active = ''
            ?>
            <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                <a href="<?php echo e(base_url()); ?>inbox" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                    fill="#000000" fill-rule="nonzero" />
                                <path
                                    d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Kontak Masuk</span>
                </a>
            </li>



            <?php
            $menu_master = ['kriteria-responden', 'klasifikasi-survei', 'tahapan-pembelian', 'dimensi', 'unsur',
            'pertanyaan', 'profil-responden-kuesioner', 'lokasi-survei', 'inject-pertanyaan'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Master</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>


                        <?php
                        ($ci->uri->segment(1) == 'kelompok-skala') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>kelompok-skala" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kelompok Skala</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'klasifikasi-survei') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>klasifikasi-survei" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Klasifikasi Survei</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'tahapan-pembelian') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>tahapan-pembelian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Tahapan Pembelian</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'dimensi') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>dimensi" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Dimensi</span>
                            </a>
                        </li>

                        <!-- <?php
                        ($ci->uri->segment(1) == 'unsur') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>unsur" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Unsur</span>
                            </a>
                        </li> -->

                        <?php
                        ($ci->uri->segment(1) == 'pertanyaan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>pertanyaan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pertanyaan Unsur</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'inject-pertanyaan') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>inject-pertanyaan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Inject Pertanyaan Ke Survei</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'lokasi-survei') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>lokasi-survei" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Lokasi Survey</span>
                            </a>
                        </li>


                    </ul>
                </div>
            </li>




            <?php
            $menu_master = ['auth', 'pengguna-administrator', 'pengguna-klien', 'pengguna-surveyor',
            'pengguna-reseller', 'pengguna-klien-induk'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Pengguna</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>



                        <?php
                        ($ci->uri->segment(1) == 'pengguna-administrator') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>pengguna-administrator" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengguna Administrator</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'pengguna-klien-induk') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>pengguna-klien-induk" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengguna Klien Induk</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'pengguna-klien') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>pengguna-klien" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengguna Klien</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'pengguna-surveyor') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>pengguna-surveyor" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengguna Surveyor</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'pengguna-reseller') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>pengguna-reseller" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengguna Reseller</span>
                            </a>
                        </li>



                    </ul>
                </div>
            </li>



            <?php
            $menu_master = ['paket', 'berlangganan'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Berlangganan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>



                        <?php
                        ($ci->uri->segment(1) == 'paket') ? $child_menu_active = 'menu-item-active' : $child_menu_active
                        = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>paket" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Paket</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'berlangganan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active
                        = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>berlangganan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Berlangganan</span>
                            </a>
                        </li>


                    </ul>
                </div>
            </li>
            <?php endif; ?>



            <!------------------------------------------------- KLIEN ---------------------------------------------->
            <?php
            $group = array('client')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <?php
            $menu_master = ['overview', 'kelola-survei'];
            $uri_selected = $ci->uri->segment(2);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Survei</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        <?php
                        ($ci->uri->segment(2) == 'overview') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/overview'; ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Overview</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(2) == 'kelola-survei') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/kelola-survei' ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kelola Survei</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>


            <?php
            ($ci->uri->segment(2) == 'users-management') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            ?>
            <li class="menu-item <?php echo e($menu_active); ?>" aria-haspopup="true">
                <a href="<?php echo base_url() . $ci->session->userdata('username') . '/users-management' ?>"
                    class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-people-fill" viewBox="0 0 18 18">
                            <path
                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                        </svg>
                    </span>
                    <span class="menu-text">Kelola Pengguna</span>
                </a>
            </li>



            <!-- <?php
            ($ci->uri->segment(2) == 'info-berlangganan') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            ?>
            <li class="menu-item <?php echo e($menu_active); ?>" aria-haspopup="true">
                <a href="<?php echo base_url() . $ci->session->userdata('username') . '/info-berlangganan' ?>"
                    class="menu-link">
                    <span class="svg-icon menu-icon">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-receipt-cutoff"
                            width="24px" height="24px" viewBox="0 0 20 20">
                            <path
                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                            <path
                                d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293 2.354.646zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z" />
                        </svg>



                    </span>
                    <span class="menu-text">Info Berlangganan</span>
                </a>
            </li> -->



            <?php
            ($ci->uri->segment(1) == 'prosedur-penggunaan-aplikasi') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            ?>
            <li class="menu-item <?php echo e($menu_active); ?>" aria-haspopup="true">
                <a href="<?php echo e(base_url()); ?>prosedur-penggunaan-aplikasi" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"></rect>
                                <path
                                    d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z"
                                    fill="#000000"></path>
                                <path
                                    d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z"
                                    fill="#000000" opacity="0.3"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Prosedur Penggunaan Aplikasi</span>
                </a>
            </li>
            <?php endif; ?>



            <!------------------------------------------------- SURVEYOR ---------------------------------------------->
            <?php
            $group = array('surveyor')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <?php
            $menu_master = ['link-survei-surveyor', 'data-perolehan-surveyor', 'target-surveyor'];
            $uri_selected = $ci->uri->segment(2);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Surveyor</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        <?php
                        ($ci->uri->segment(2) == 'link-survei-surveyor') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/link-survei-surveyor' ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Link Survei</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(2) == 'data-perolehan-surveyor') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/data-perolehan-surveyor' ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Perolehan Survei</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(2) == 'target-surveyor') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/target-surveyor' ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Target Surveyor</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <?php endif; ?>




            <!------------------------------------------------- KLIEN INDUK ---------------------------------------------->
            <?php
            $group = array('client_induk')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <?php
            $menu_master = ['data-perolehan-keseluruhan', 'data-perolehan-per-bagian'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Data Perolehan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'data-perolehan-keseluruhan') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>data-perolehan-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'data-perolehan-per-bagian') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>data-perolehan-per-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>




            <?php
            $menu_master = ['target-keseluruhan', 'target-per-bagian'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Data Target</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'target-keseluruhan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>target-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'target-per-bagian') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>target-per-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>



            <?php
            $menu_master = ['olah-data-keseluruhan', 'olah-data-per-bagian'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Olah Data</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'olah-data-keseluruhan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>olah-data-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'olah-data-per-bagian') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>olah-data-per-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>



            <?php
            $menu_master = ['nilai-index-keseluruhan', 'nilai-index-bagian'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Nilai Indeks Per Sektor</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'nilai-index-keseluruhan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>nilai-index-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'nilai-index-bagian') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>nilai-index-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>




            <?php
            $menu_master = ['rekap-hasil-keseluruhan', 'rekap-hasil-per-bagian'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>
            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Rekap Hasil</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'rekap-hasil-keseluruhan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>rekap-hasil-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'rekap-hasil-per-bagian') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>rekap-hasil-per-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>




            <?php
            ($ci->uri->segment(1) == 'laporan-induk') ? $child_menu_active = 'menu-item-active' :
            $child_menu_active = '';
            ?>
            <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                <a href="<?php echo e(base_url()); ?>laporan-induk" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                    fill="#000000" fill-rule="nonzero" />
                                <path
                                    d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Laporan</span>
                </a>
            </li>



            <?php
            $menu_master = ['e-sertifikat-per-bagian', 'e-sertifikat-keseluruhan'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>
            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">E-Sertifikat</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'e-sertifikat-keseluruhan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>e-sertifikat-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'e-sertifikat-per-bagian') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>e-sertifikat-per-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>




            <!------------------------------------------------- supervisor ---------------------------------------------->
            <?php
            $group = array('supervisor')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>

            <?php
            ($ci->uri->segment(2) == 'kelola-survei') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            ?>
            <li class="menu-item <?php echo e($menu_active); ?>" aria-haspopup="true">
                <a href="<?php echo base_url() . $ci->session->userdata('username') . '/kelola-survei' ?>"
                    class="menu-link">
                    <span class="svg-icon menu-icon">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-stickies-fill"
                            width="24px" height="24px" viewBox="0 0 24 24">
                            <path
                                d="M0 1.5V13a1 1 0 0 0 1 1V1.5a.5.5 0 0 1 .5-.5H14a1 1 0 0 0-1-1H1.5A1.5 1.5 0 0 0 0 1.5z" />
                            <path
                                d="M3.5 2A1.5 1.5 0 0 0 2 3.5v11A1.5 1.5 0 0 0 3.5 16h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 16 9.586V3.5A1.5 1.5 0 0 0 14.5 2h-11zm6 8.5a1 1 0 0 1 1-1h4.396a.25.25 0 0 1 .177.427l-5.146 5.146a.25.25 0 0 1-.427-.177V10.5z" />
                        </svg>
                    </span>


                    <span class="menu-text">Kelola Survei</span>
                </a>
            </li>
            <?php endif; ?>


        </ul>
    </div>
</div><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/include_backend/partials_backend/_aside_menu.blade.php ENDPATH**/ ?>