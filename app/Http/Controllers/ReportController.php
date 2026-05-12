<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $tanggal = $request->tanggal;

        $orders = Order::with('table')
            ->whereDate('created_at', $tanggal)
            ->get();

        $totalPendapatan = $orders->sum('total');

        return view('reports.index', compact(
            'orders',
            'tanggal',
            'totalPendapatan'
        ));
    }

    public function pdf(Request $request)
    {
        $tanggal = $request->tanggal;

        $orders = Order::with('table')
            ->whereDate('created_at', $tanggal)
            ->get();

        $totalPendapatan = $orders->sum('total');

        $pdf = Pdf::loadView(
            'reports.pdf',
            compact(
                'orders',
                'tanggal',
                'totalPendapatan'
            )
        );

        return $pdf->download(
            'laporan-penjualan.pdf'
        );
    }

    public function excel(Request $request)
    {
        $tanggal = $request->tanggal;

        return Excel::download(

            new ReportExport($tanggal),

            'laporan-penjualan.xlsx'

        );
    }
}