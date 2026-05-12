<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements
    FromCollection,
    WithHeadings
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        return Order::whereDate(
                'created_at',
                $this->tanggal
            )
            ->get([
                'id',
                'nama_customer',
                'jenis_pesanan',
                'total',
                'status',
                'payment_status',
                'created_at'
            ]);
    }

    public function headings(): array
    {
        return [

            'ID',
            'Customer',
            'Jenis Pesanan',
            'Total',
            'Status Order',
            'Status Pembayaran',
            'Tanggal'

        ];
    }
}