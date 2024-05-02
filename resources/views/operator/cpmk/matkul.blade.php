@extends('layouts.layout')
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row mb-2" style="row-gap: 20px">
                @foreach ($matkul as $item)
                    <div class="col-md-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="fs-5 fw-bolder text-center text-capitalize">{{ $item->mata_kuliah }}</div>
                                <div class="d-flex justify-content-center mt-2">
                                    <a href="{{ route('operator.cpmk', ['params' => $item->uuid]) }}"
                                        class="btn btn-primary p-3 py-2">Lihat Daftar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection
