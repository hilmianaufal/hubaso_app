<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        // total order hari ini
        $totalOrderHariIni = Order::whereDate(
            'created_at',
            Carbon::today()
        )->count();

        // total pendapatan hari ini
        $totalPendapatanHariIni = Order::whereDate(
            'created_at',
            Carbon::today()
        )->sum('total');

        // total menu
        $totalMenu = Menu::count();

        // total order pending
        $totalPending = Order::where(
            'status',
            'pending'
        )->count();

        $topMenus = OrderItem::select(
        'menu_id',
        DB::raw('SUM(qty) as total_qty')
            )
            ->with('menu')
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();
        /*
        |--------------------------------------------------------------------------
        | MENU TERLARIS
        |--------------------------------------------------------------------------
        */

        $menuTerlaris = OrderItem::select('menu_id')
            ->selectRaw('SUM(qty) as total_qty')
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | GRAFIK PENJUALAN
        |--------------------------------------------------------------------------
        */

        $ordersChart = Order::selectRaw('DATE(created_at) as tanggal')
            ->selectRaw('COUNT(*) as total_order')
            ->selectRaw('SUM(total) as total_pendapatan')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->take(7)
            ->get();

        $labels = [];

        $orderData = [];

        $pendapatanData = [];

        foreach ($ordersChart as $chart) {

            $labels[] = $chart->tanggal;

            $orderData[] = $chart->total_order;

            $pendapatanData[] =
                $chart->total_pendapatan;
        }

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'totalOrderHariIni',
            'totalPendapatanHariIni',
            'totalMenu',
            'totalPending',
            'menuTerlaris',
            'labels',
            'orderData',
            'pendapatanData',
            'topMenus'
        ));
    }
}