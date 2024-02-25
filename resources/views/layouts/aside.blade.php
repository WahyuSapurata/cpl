@php
    $path = explode('/', Request::path());
    $role = auth()->user()->role;

    $dashboardRoutes = [
        'operator' => 'operator.dashboard-operator',
        'kajur' => 'kajur.dashboard-kajur',
        'dosen' => 'dosen.dashboard-dosen',
        // 'direktur' => 'direktur.dashboard-direktur',
        // 'pajak' => 'pajak.dashboard-pajak',
    ];

    $isActive = in_array($role, array_keys($dashboardRoutes)) && isset($path[1]) && $path[1] === 'dashboard-' . $role;
    $activeColor = $isActive ? 'color: #F4BE2A' : 'color: #FFFFFF';
@endphp

<div class="aside-menu bg-primary flex-column-fluid">
    <!--begin::Aside Menu-->
    <div class="hover-scroll-overlay-y mb-5 mb-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
        data-kt-scroll-offset="0">
        <script>
            // Ambil elemen menu menggunakan JavaScript
            var menu = document.getElementById('kt_aside_menu_wrapper');

            // Set tinggi maksimum dan penanganan overflow menggunakan JavaScript
            if (menu) {
                menu.style.maxHeight = '88vh'; // Set tinggi maksimum
            }
        </script>
        <!--begin::Menu-->
        <div class="menu menu-column mt-2 menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
            id="kt_aside_menu" data-kt-menu="true" style="gap: 3px;">

            <div class="menu-item">
                <a class="menu-link {{ $isActive ? 'active' : ($module = 'Persetujun PO') }}"
                    href="{{ route($dashboardRoutes[$role]) }}">
                    <span class="menu-icon">
                        <span class="svg-icon svg-icon-2">
                            <img src="{{ $isActive ? url('admin/assets/media/icons/aside/dashboardact.svg') : url('admin/assets/media/icons/aside/dashboarddef.svg') }}"
                                alt="">
                        </span>
                    </span>
                    <span class="menu-title" style="{{ $activeColor }}">Dashboard</span>
                </a>
            </div>

            @if ($role === 'operator')
                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'data-dosen' ? 'active' : '' }}"
                        href="{{ route('operator.data-dosen') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'data-dosen' ? url('admin/assets/media/icons/aside/adminact.svg') : url('/admin/assets/media/icons/aside/admindef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'data-dosen' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Data
                            Dosen</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'mata-kuliah' ? 'active' : '' }}"
                        href="{{ route('operator.mata-kuliah') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'mata-kuliah' ? url('admin/assets/media/icons/aside/pengajuanact.svg') : url('/admin/assets/media/icons/aside/pengajuandef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'mata-kuliah' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Mata
                            Kuliah</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'cpl' ? 'active' : '' }}"
                        href="{{ route('operator.cpl') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'cpl' ? url('admin/assets/media/icons/aside/gajiact.svg') : url('/admin/assets/media/icons/aside/gajidef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'cpl' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">CPL</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'indikator-kinerja' ? 'active' : '' }}"
                        href="{{ route('operator.indikator-kinerja') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'indikator-kinerja' ? url('admin/assets/media/icons/aside/piutangact.svg') : url('/admin/assets/media/icons/aside/piutangdef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'indikator-kinerja' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Indikator
                            Kinerja</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'cpldenganik' ? 'active' : '' }}"
                        href="{{ route('operator.cpldenganik') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'cpldenganik' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'cpldenganik' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Hubungan
                            CPL
                            Dengan IK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? 'active' : '' }}"
                        href="{{ route('operator.ikdengancpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Hubungan
                            IK
                            Dengan CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->
            @endif

            @if ($role === 'dosen')
                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? 'active' : '' }}"
                        href="{{ route('dosen.ikdengancpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Hubungan
                            IK
                            Dengan CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'nilai' ? 'active' : '' }}"
                        href="{{ route('dosen.nilai') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'nilai' ? url('admin/assets/media/icons/aside/absenact.svg') : url('/admin/assets/media/icons/aside/absendef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'nilai' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai</span>
                    </a>
                </div>
                <!--end::Menu item-->
            @endif

            <div class="menu-item">
                <a class="menu-link  {{ $path[0] === 'ubahpassword' ? 'active' : '' }}"
                    href="{{ route('ubahpassword') }}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                        <span class="svg-icon svg-icon-2">
                            <img src="{{ $path[0] === 'ubahpassword' ? url('admin/assets/media/icons/aside/ubahpasswordact.svg') : url('/admin/assets/media/icons/aside/ubahpassworddef.svg') }}"
                                alt="">
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title"
                        style="{{ $path[0] === 'ubahpassword' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Ubah
                        Password</span>
                </a>
            </div>

        </div>
        <!--end::Menu-->
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            // $(".menu-link").hover(function(){
            //     $(this).css("background", "#282EAD");
            // }, function(){
            //     $(this).css("background", "none");
            // });
        });
    </script>
@endsection
