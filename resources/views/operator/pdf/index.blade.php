<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF CPL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        @foreach ($data['kode_cpl'] as $thead)
                            <th>{{ $thead }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if (empty($data['data']))
                        <tr>
                            <td colspan="{{ 2 + count($data['kode_cpl']) }}" class="text-center">No data available in
                                table</td>
                        </tr>
                    @else
                        @foreach ($data['data'] as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['nama_mahasiswa'] }}</td>
                                @foreach ($data['kode_cpl'] as $cpl)
                                    <td>{{ $item[$cpl] ?? 'N/A' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

        </div>
    </div>
</body>

</html>
