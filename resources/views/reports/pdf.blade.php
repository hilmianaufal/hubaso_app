<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Laporan PDF</title>

    <style>

        body {

            font-family: sans-serif;

            font-size: 14px;
        }

        table {

            width: 100%;

            border-collapse: collapse;

            margin-top: 20px;
        }

        table, th, td {

            border: 1px solid black;
        }

        th, td {

            padding: 8px;

            text-align: left;
        }

        h2, h4 {

            margin: 0;
        }

    </style>

</head>
<body>

<h2>
    Laporan Penjualan
</h2>

<h4>
    Tanggal:
    {{ $tanggal }}
</h4>

<h4>
    Total Pendapatan:
    Rp {{ number_format($totalPendapatan) }}
</h4>

<table>

    <thead>

        <tr>

            <th>No</th>
            <th>Meja</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>

        </tr>

    </thead>

    <tbody>

        @foreach($orders as $order)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $order->table->nomor_meja }}
            </td>

            <td>
                {{ $order->nama_customer }}
            </td>

            <td>
                Rp {{ number_format($order->total) }}
            </td>

            <td>
                {{ $order->status }}
            </td>

        </tr>

        @endforeach

    </tbody>

</table>

</body>
</html>