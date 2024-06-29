@php
    $path = explode('/', Request::path());
    $role = auth()->user()->role;

    $dashboardRoutes = [
        'operator' => 'operator.dashboard-operator',
        'kajur' => 'kajur.dashboard-kajur',
        'dosen' => 'dosen.dashboard-dosen',
        'admin' => 'admin.dashboard-admin',
        'lpm' => 'lpm.dashboard-lpm',
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

            @if ($role === 'admin')
                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'data-operator' ? 'active' : '' }}"
                        href="{{ route('admin.data-operator') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'data-operator' ? url('admin/assets/media/icons/aside/akunact.svg') : url('/admin/assets/media/icons/aside/akundef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'data-operator' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Operator</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'data-dosen' ? 'active' : '' }}"
                        href="{{ route('admin.data-dosen') }}">
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
                        href="{{ route('admin.mata-kuliah') }}">
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
                        href="{{ route('admin.cpl') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'cpl' ? url('admin/assets/media/icons/aside/gajiact.svg') : url('/admin/assets/media/icons/aside/gajidef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'cpl' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Rumusan
                            CPL/PLO</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'indikator-kinerja' ? 'active' : '' }}"
                        href="{{ route('admin.indikator-kinerja') }}">
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
                {{--
                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'cpldenganik' ? 'active' : '' }}"
                        href="{{ route('admin.cpldenganik') }}">
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
                <!--end::Menu item--> --}}

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? 'active' : '' }}"
                        href="{{ route('admin.ikdengancpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'subcpmk' ? 'active' : '' }}"
                        href="{{ route('admin.subcpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'subcpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'subcpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Sub
                            CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'nilai' ? 'active' : '' }}"
                        href="{{ route('admin.nilai') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'nilai' ? url('admin/assets/media/icons/aside/absenact.svg') : url('/admin/assets/media/icons/aside/absendef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'nilai' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai
                            IK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'nilaicpl' ? 'active' : '' }}"
                        href="{{ route('admin.nilaicpl') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'nilaicpl' ? url('admin/assets/media/icons/aside/laporanact.svg') : url('/admin/assets/media/icons/aside/laporandef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'nilaicpl' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai
                            CPL</span>
                    </a>
                </div>
                <!--end::Menu item-->
            @endif

            @if ($role === 'operator')
                <div class="menu-item menu-link-indention menu-accordion {{ $path[1] == 'data-master' ? 'show' : '' }}"
                    data-kt-menu-trigger="click">
                    <!--begin::Menu link-->
                    <a href="#" class="menu-link py-3 {{ $path[1] == 'data-master' ? 'active' : '' }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ $path[1] == 'data-master' ? url('admin/assets/media/icons/aside/masterdataact.svg') : url('admin/assets/media/icons/aside/masterdatadef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ $path[1] == 'data-master' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Data
                            Master</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <!--end::Menu link-->

                    <!--begin::Menu sub-->
                    <div class="menu-sub gap-2 menu-sub-accordion my-2">
                        <!--begin::Menu item-->
                        <div class="menu-item pe-0">
                            <a class="menu-link {{ isset($path[2]) && $path[2] === 'data-dosen' ? 'active' : '' }}"
                                href="{{ route('operator.data-dosen') }}">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <img src="{{ isset($path[2]) && $path[2] === 'data-dosen' ? url('admin/assets/media/icons/aside/adminact.svg') : url('/admin/assets/media/icons/aside/admindef.svg') }}"
                                            alt="">
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="menu-title"
                                    style="{{ isset($path[2]) && $path[2] === 'data-dosen' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Data
                                    Dosen</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item pe-0">
                            <a class="menu-link {{ isset($path[2]) && $path[2] === 'mata-kuliah' ? 'active' : '' }}"
                                href="{{ route('operator.mata-kuliah') }}">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <img src="{{ isset($path[2]) && $path[2] === 'mata-kuliah' ? url('admin/assets/media/icons/aside/pengajuanact.svg') : url('/admin/assets/media/icons/aside/pengajuandef.svg') }}"
                                            alt="">
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="menu-title"
                                    style="{{ isset($path[2]) && $path[2] === 'mata-kuliah' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Mata
                                    Kuliah</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item pe-0">
                            <a class="menu-link {{ isset($path[2]) && $path[2] === 'mahasiswa' ? 'active' : '' }}"
                                href="{{ route('operator.mahasiswa') }}">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <img src="{{ isset($path[2]) && $path[2] === 'mahasiswa' ? url('admin/assets/media/icons/aside/mahasiswaact.svg') : url('/admin/assets/media/icons/aside/mahasiswadef.svg') }}"
                                            alt="">
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="menu-title"
                                    style="{{ isset($path[2]) && $path[2] === 'mahasiswa' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Mahasiswa</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu sub-->

                </div>

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
                            style="{{ isset($path[1]) && $path[1] === 'cpl' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Rumusan
                            CPL/PLO</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'cpmk' ? 'active' : '' }}"
                        href="{{ route('operator.cpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'cpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'cpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'subcpmk' ? 'active' : '' }}"
                        href="{{ route('operator.subcpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'subcpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'subcpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Sub
                            CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'nilaicpl' ? 'active' : '' }}"
                        href="{{ route('operator.nilaicpl') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'nilaicpl' ? url('admin/assets/media/icons/aside/laporanact.svg') : url('/admin/assets/media/icons/aside/laporandef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'nilaicpl' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai
                            CPL</span>
                    </a>
                </div>
                <!--end::Menu item-->
            @endif

            @if ($role === 'dosen')
                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'cpmk' ? 'active' : '' }}"
                        href="{{ route('dosen.cpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'cpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'cpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'subcpmk' ? 'active' : '' }}"
                        href="{{ route('dosen.subcpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'subcpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'subcpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Sub
                            CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'penilaian' ? 'active' : '' }}"
                        href="{{ route('dosen.penilaian') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'penilaian' ? url('admin/assets/media/icons/aside/absenact.svg') : url('/admin/assets/media/icons/aside/absendef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'penilaian' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Penilaian</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'nilai-cpmk' ? 'active' : '' }}"
                        href="{{ route('dosen.nilai-cpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'nilai-cpmk' ? url('admin/assets/media/icons/aside/absenact.svg') : url('/admin/assets/media/icons/aside/absendef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'nilai-cpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai
                            CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                {{-- <!--begin::Menu item-->
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
                            style="{{ isset($path[1]) && $path[1] === 'nilai' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai
                            IK</span>
                    </a>
                </div>
                <!--end::Menu item--> --}}

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'nilaicpl' ? 'active' : '' }}"
                        href="{{ route('dosen.nilaicpl') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'nilaicpl' ? url('admin/assets/media/icons/aside/laporanact.svg') : url('/admin/assets/media/icons/aside/laporandef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'nilaicpl' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai
                            CPL</span>
                    </a>
                </div>
                <!--end::Menu item-->
            @endif

            @if ($role === 'kajur')
                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'cpl' ? 'active' : '' }}"
                        href="{{ route('kajur.cpl') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'cpl' ? url('admin/assets/media/icons/aside/gajiact.svg') : url('/admin/assets/media/icons/aside/gajidef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'cpl' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Rumusan
                            CPL/PLO</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'indikator-kinerja' ? 'active' : '' }}"
                        href="{{ route('kajur.indikator-kinerja') }}">
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
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? 'active' : '' }}"
                        href="{{ route('kajur.ikdengancpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'subcpmk' ? 'active' : '' }}"
                        href="{{ route('admin.subcpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'subcpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'subcpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Sub
                            CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'nilai' ? 'active' : '' }}"
                        href="{{ route('kajur.nilai') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'nilai' ? url('admin/assets/media/icons/aside/absenact.svg') : url('/admin/assets/media/icons/aside/absendef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'nilai' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai
                            IK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'nilaicpl' ? 'active' : '' }}"
                        href="{{ route('kajur.nilaicpl') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'nilaicpl' ? url('admin/assets/media/icons/aside/laporanact.svg') : url('/admin/assets/media/icons/aside/laporandef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'nilaicpl' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai
                            CPL</span>
                    </a>
                </div>
                <!--end::Menu item-->
            @endif

            @if ($role === 'lpm')
                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'cpl' ? 'active' : '' }}"
                        href="{{ route('lpm.cpl') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'cpl' ? url('admin/assets/media/icons/aside/gajiact.svg') : url('/admin/assets/media/icons/aside/gajidef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'cpl' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Rumusan
                            CPL/PLO</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'indikator-kinerja' ? 'active' : '' }}"
                        href="{{ route('lpm.indikator-kinerja') }}">
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
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? 'active' : '' }}"
                        href="{{ route('lpm.ikdengancpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'ikdengancpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'subcpmk' ? 'active' : '' }}"
                        href="{{ route('admin.subcpmk') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'subcpmk' ? url('admin/assets/media/icons/aside/persetujuanpoact.svg') : url('/admin/assets/media/icons/aside/persetujuanpodef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'subcpmk' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Sub
                            CPMK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'nilai' ? 'active' : '' }}"
                        href="{{ route('lpm.nilai') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'nilai' ? url('admin/assets/media/icons/aside/absenact.svg') : url('/admin/assets/media/icons/aside/absendef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'nilai' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai
                            IK</span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item">
                    <a class="menu-link {{ isset($path[1]) && $path[1] === 'nilaicpl' ? 'active' : '' }}"
                        href="{{ route('lpm.nilaicpl') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img src="{{ isset($path[1]) && $path[1] === 'nilaicpl' ? url('admin/assets/media/icons/aside/laporanact.svg') : url('/admin/assets/media/icons/aside/laporandef.svg') }}"
                                    alt="">
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title"
                            style="{{ isset($path[1]) && $path[1] === 'nilaicpl' ? 'color: #F4BE2A' : 'color: #FFFFFF' }}">Nilai
                            CPL</span>
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
