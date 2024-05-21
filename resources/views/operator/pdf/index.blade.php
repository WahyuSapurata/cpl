<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }

        .info-box {
            margin-bottom: 20px;
        }

        .info-box p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div>
        <div class="info-box">
            <table>
                <tr>
                    <td><strong>Mata Kuliah</strong></td>
                    <td><strong>:</strong></td>
                    <td><strong>{{ $mata_kuliah->mata_kuliah }}</strong></td>
                </tr>
                <tr>
                    <td><strong>Kode</strong></td>
                    <td><strong>:</strong></td>
                    <td><strong>{{ $mata_kuliah->kode_mk }}</strong></td>
                </tr>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode CPL</th>
                        <th>Nilai IK x Bobot</th>
                        <th>Jumlah Bobot IK</th>
                        <th>Nilai CPL</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($combanedCpl->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No data available in table</td>
                        </tr>
                    @else
                        @foreach ($combanedCpl as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kode_cpl }}</td>
                                <td>{{ $item->nilai_ik }}</td>
                                <td>{{ $item->bobot_ik }}</td>
                                <td>{{ $item->nilai_cpl }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
