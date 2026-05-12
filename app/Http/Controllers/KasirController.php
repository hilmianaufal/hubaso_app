<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'table',
            'items.menu'
        ])->latest()->get();

        return view('kasir.orders', compact('orders'));
    }
        private function generateQueue()
        {
            $lastOrder = Order::latest()->first();

            if (!$lastOrder) {
                return 'A001';
            }

            $lastNumber = (int) substr($lastOrder->queue_number, 1);

            $newNumber = $lastNumber + 1;

            return 'A' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }
    public function updateStatus(Request $request,
                                 Order $order)
    {
        $order->update([
            'status' => $request->status
        ]);

        return back();
    }
    public function updatePayment(Request $request,
                              Order $order)
    {
        $order->update([

            'payment_status' =>
                $request->payment_status

        ]);

        return back();
    }

    public function kitchen()
    {
      $orders = Order::with(['items.menu', 'table'])
        ->whereIn('status', ['pending', 'diproses'])
        ->latest()
        ->get();

        return view('kitchen.index',
                    compact('orders'));
    }

   public function done(Order $order)
    {
        $order->update([
            'status' => 'selesai'
        ]);

        return back()->with('success', 'Pesanan selesai');
    }

    public function destroyOrder(Order $order)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $order->items()->delete();
    $order->delete();

    return back()->with('success', 'Order berhasil dihapus');
}

public function dashboard()
{
    $today = now()->toDateString();

    $totalOrderHariIni = Order::whereDate('created_at', $today)
        ->count();

    $pendingPayment = Order::where('payment_status', 'unpaid')
        ->count();

    $totalCash = Order::where('payment_method', 'cash')
        ->where('payment_status', 'paid')
        ->whereDate('created_at', $today)
        ->sum('total');

    $totalQris = Order::where('payment_method', 'qris')
        ->where('payment_status', 'paid')
        ->whereDate('created_at', $today)
        ->sum('total');

    return view('kasir.dashboard', compact(
        'totalOrderHariIni',
        'pendingPayment',
        'totalCash',
        'totalQris'
    ));
}


public function manualOrder()
{
    $menus = Menu::with('category')->get();

    $categories = Category::all();

    return view('kasir.manual-order', compact(
        'menus',
        'categories'
    ));
}

public function storeManualOrder(Request $request)
{
    $request->validate([
        'nama_customer'   => 'required|string|max:255',
        'jenis_pesanan'   => 'required|in:Makan Di Tempat,Bungkus',
        'nomor_meja'      => 'nullable|string|max:255',
        'payment_method'  => 'required|in:cash,qris,debit',
        'catatan'         => 'nullable|string|max:500',
    ]);

    $cart = session('cart', []);

    if (empty($cart)) {
        return back()->withErrors([
            'cart' => 'Keranjang masih kosong'
        ]);
    }

    $total = 0;

    foreach ($cart as $id => $item) {
        $menu = Menu::find($id);

        if (!$menu) {
            return back()->withErrors([
                'menu' => 'Menu tidak ditemukan'
            ]);
        }

        if ($menu->stok < $item['qty']) {
            return back()->withErrors([
                'stok' => $menu->nama . ' stok tidak mencukupi'
            ]);
        }

        $total += $item['harga'] * $item['qty'];
    }

    $order = Order::create([
        'restaurant_table_id' => null,
        'nomor_meja_manual'  => $request->jenis_pesanan == 'Makan Di Tempat'
            ? $request->nomor_meja
            : null,
        'nama_customer'      => $request->nama_customer,
        'jenis_pesanan'      => $request->jenis_pesanan,
        'catatan'            => $request->catatan,
        'total'              => $total,
        'status'             => 'pending',
        'payment_status'     => 'paid',
        'payment_method'     => $request->payment_method,
        'queue_number'       => $this->generateQueue(),
    ]);

    foreach ($cart as $id => $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id'  => $id,
            'qty'      => $item['qty'],
            'harga'    => $item['harga'],
            'subtotal' => $item['harga'] * $item['qty'],
        ]);

        $menu = Menu::find($id);
        $menu->decrement('stok', $item['qty']);
    }

    session()->forget('cart');

    return redirect('/invoice/' . $order->id);
}

    public function process(Order $order)
    {
        $order->update([
            'status' => 'diproses'
        ]);

        return back()->with('success', 'Pesanan sedang dimasak');
    }


}