@extends('layouts.layout')
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row">
                @foreach ($matkul as $item)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body d-grid gap-3">
                                <div class="fs-3 fw-bolder text-center">{{ $item->mata_kuliah }}</div>
                                <a href="{{ route('operator.detail-sub', ['params' => $item->uuid]) }}"
                                    class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection
