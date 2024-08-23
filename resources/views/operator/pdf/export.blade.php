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
                        <th>Kode CPL</th>
                        <th>Deskripsi</th>
                        <th>Ketercapaian CPL</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        function render($data)
                        {
                            // Memastikan bahwa nilai adalah angka
                            $number = floatval($data);
                            if (!is_numeric($number)) {
                                return $data;
                            }

                            // Membulatkan angka ke dua desimal
                            return number_format($number, 2);
                        }

                    @endphp
                    @if (empty($summedData))
                        <tr>
                            <td class="text-center">No data available in table</td>
                        </tr>
                    @else
                        @foreach ($summedData as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['kode_cpl'] }}</td>
                                <td>{{ $item['deskripsi'] }}</td>
                                <td>{{ render($item['nilai']) }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

        </div>
    </div>
</body>

</html>
