@extends('layouts.layout')
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row mb-2" style="row-gap: 20px">
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="fs-5 fw-bolder text-center text-capitalize">Semester 1</div>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="{{ route('operator.matkulsubcpmk', ['params' => 1]) }}"
                                    class="btn btn-primary p-3 py-2">Lihat Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="fs-5 fw-bolder text-center text-capitalize">Semester 2</div>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="{{ route('operator.matkulsubcpmk', ['params' => 2]) }}"
                                    class="btn btn-primary p-3 py-2">Lihat Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="fs-5 fw-bolder text-center text-capitalize">Semester 3</div>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="{{ route('operator.matkulsubcpmk', ['params' => 3]) }}"
                                    class="btn btn-primary p-3 py-2">Lihat Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="fs-5 fw-bolder text-center text-capitalize">Semester 4</div>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="{{ route('operator.matkulsubcpmk', ['params' => 4]) }}"
                                    class="btn btn-primary p-3 py-2">Lihat Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="fs-5 fw-bolder text-center text-capitalize">Semester 5</div>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="{{ route('operator.matkulsubcpmk', ['params' => 5]) }}"
                                    class="btn btn-primary p-3 py-2">Lihat Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="fs-5 fw-bolder text-center text-capitalize">Semester 6</div>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="{{ route('operator.matkulsubcpmk', ['params' => 6]) }}"
                                    class="btn btn-primary p-3 py-2">Lihat Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="fs-5 fw-bolder text-center text-capitalize">Semester 7</div>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="{{ route('operator.matkulsubcpmk', ['params' => 7]) }}"
                                    class="btn btn-primary p-3 py-2">Lihat Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="fs-5 fw-bolder text-center text-capitalize">Semester 8</div>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="{{ route('operator.matkulsubcpmk', ['params' => 8]) }}"
                                    class="btn btn-primary p-3 py-2">Lihat Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection
