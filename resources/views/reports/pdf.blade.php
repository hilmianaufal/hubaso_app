<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            color: #1e40af;
        }

        .header p {
            margin: 5px 0 0;
            color: #6b7280;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary td {
            padding: 10px;
            border: none;
        }

        .summary-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 12px;
        }

        .summary-label {
            color: #6b7280;
            font-size: 11px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: bold;
            color: #1d4ed8;
            margin-top: 4px;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.report th {
            background: #1e40af;
            color: white;
            padding: 9px;
            font-size: 11px;
            text-align: left;
        }

        table.report td {
            padding: 9px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        table.report tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-diproses {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-selesai {
            background: #dcfce7;
            color: #166534;
        }

        .footer {
            margin-top: 25px;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Laporan Penjualan</h2>
    <p>HUBASO Restaurant POS</p>
</div>

<table class="summary">
    <tr>
        <td width="50%">
            <div class="summary-label">Rentang Tanggal</div>
            <div class="summary-value">
                {{ \Carbon\Carbon::parse($tanggalMulai)->format('d M Y') }}
                -
                {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d M Y') }}
            </div>
        </td>

        <td width="50%">
            <div class="summary-box">
                <div class="summary-label">Total Pendapatan</div>
                <div class="summary-value">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </div>
            </div>
        </td>
    </tr>
</table>

<table class="report">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%">Tipe</th>
            <th width="20%">Customer</th>
            <th width="20%">Meja / Bungkus</th>
            <th width="20%" class="text-right">Total</th>
            <th width="20%">Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    {{ $order->jenis_pesanan ?? '-' }}
                </td>

                <td>
                    {{ $order->nama_customer ?? '-' }}
                </td>

                <td>
                    @if($order->jenis_pesanan == 'Bungkus')
                        Bungkus
                    @else
                        Meja {{ $order->table->nomor_meja ?? $order->nomor_meja_manual ?? '-' }}
                    @endif
                </td>

                <td class="text-right">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </td>

                <td>
                    @if($order->status == 'pending')
                        <span class="badge badge-pending">Pending</span>
                    @elseif($order->status == 'diproses')
                        <span class="badge badge-diproses">Diproses</span>
                    @elseif($order->status == 'selesai')
                        <span class="badge badge-selesai">Selesai</span>
                    @else
                        {{ $order->status ?? '-' }}
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:20px;">
                    Tidak ada data penjualan.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Dicetak otomatis oleh HUBASO POS
</div>

</body>
</html>