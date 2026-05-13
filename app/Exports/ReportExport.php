<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportExport implements FromCollection
{
    protected $tanggalMulai;
    protected $tanggalSelesai;

    public function __construct($tanggalMulai, $tanggalSelesai)
    {
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalSelesai = $tanggalSelesai;
    }

    public function collection()
    {
        return Order::with('table')
            ->whereBetween('created_at', [
                $this->tanggalMulai . ' 00:00:00',
                $this->tanggalSelesai . ' 23:59:59',
            ])
            ->get()
            ->map(function ($order) {

                return [

                    'Queue' => $order->queue_number,

                    'Customer' => $order->nama_customer,

                    'Jenis Pesanan' => $order->jenis_pesanan,

                    'Meja / Bungkus' =>
                        $order->jenis_pesanan == 'Bungkus'
                            ? 'Bungkus'
                            : ($order->table->nomor_meja
                                ?? $order->nomor_meja_manual
                                ?? '-'),

                    'Total' => $order->total,

                    'Status' => $order->status,

                    'Pembayaran' => $order->payment_status,

                    'Tanggal' => $order->created_at->format('d-m-Y H:i'),
                ];
            });
    }
}