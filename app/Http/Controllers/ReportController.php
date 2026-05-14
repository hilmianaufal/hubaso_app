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
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $orders = Order::with(['table', 'user'])
            ->whereBetween('created_at', [
                $tanggalMulai . ' 00:00:00',
                $tanggalSelesai . ' 23:59:59',
            ])
            ->get();

        $totalPendapatan = $orders->sum('total');

        return view('reports.index', compact(
            'orders',
            'tanggalMulai',
            'tanggalSelesai',
            'totalPendapatan'
        ));
    }
        public function pdf(Request $request)
        {
            $tanggalMulai = $request->tanggal_mulai;
            $tanggalSelesai = $request->tanggal_selesai;

            $orders = Order::with(['table', 'user'])
                ->whereBetween('created_at', [
                    $tanggalMulai . ' 00:00:00',
                    $tanggalSelesai . ' 23:59:59',
                ])
                ->get();

            $totalPendapatan = $orders->sum('total');

            return Pdf::loadView('reports.pdf', compact(
                'orders',
                'tanggalMulai',
                'tanggalSelesai',
                'totalPendapatan'
            ))->download('laporan-penjualan.pdf');
        }

        public function excel(Request $request)
        {
            $tanggalMulai = $request->tanggal_mulai;
            $tanggalSelesai = $request->tanggal_selesai;

            return Excel::download(
                new ReportExport($tanggalMulai, $tanggalSelesai),
                'laporan-penjualan.xlsx'
            );
        }
}