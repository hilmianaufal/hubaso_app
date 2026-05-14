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
            ->where('payment_status', 'paid')
            ->whereIn('status', ['pending', 'diproses'])
            ->latest()
            ->get();

        return view('kitchen.index', compact('orders'));
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
            'cart' => 'Keranjang masih kosong',
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

            'subtotal'           => $total,
            'discount_type'      => null,
            'discount_value'     => 0,
            'discount_amount'    => 0,
            'total'              => $total,

            'status'             => 'pending',
            'payment_status'     => 'unpaid',
            'payment_method'     => $request->payment_method,
            'bayar'              => null,
            'kembalian'          => null,
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

    return redirect('/kasir/payment/' . $order->id);
}

    public function process(Order $order)
    {
        $order->update([
            'status' => 'diproses'
        ]);

        return back()->with('success', 'Pesanan sedang dimasak');
    }

    public function paymentPage(Order $order)
{
    $order->load('items.menu');

    return view('kasir.payment', compact('order'));
}

public function processPayment(Request $request, Order $order)
{
    $request->validate([
        'payment_method' => 'required|in:cash,qris,debit',
        'discount_type' => 'nullable|in:nominal,percent',
        'discount_value' => 'nullable|numeric|min:0',
    ]);

    $subtotal = $order->subtotal ?? $order->total;

    $discountType = $request->discount_type;
    $discountValue = (int) ($request->discount_value ?? 0);

    $discountAmount = 0;

    if ($discountType === 'percent') {
        $discountAmount = round($subtotal * $discountValue / 100);
    }

    if ($discountType === 'nominal') {
        $discountAmount = $discountValue;
    }

    if ($discountAmount > $subtotal) {
        $discountAmount = $subtotal;
    }

    $totalAkhir = $subtotal - $discountAmount;

    if ($request->payment_method == 'qris') {
        $order->update([
            'subtotal'        => $subtotal,
            'discount_type'   => $discountType,
            'discount_value'  => $discountValue,
            'discount_amount' => $discountAmount,
            'total'           => $totalAkhir,
            'payment_method'  => 'qris',
            'payment_status'  => 'waiting_verification',
        ]);

        return redirect('/kasir/qris/' . $order->id);
    }

    $request->validate([
        'bayar' => 'required|numeric|min:0',
    ]);

    $bayar = (int) $request->bayar;

    if ($bayar < $totalAkhir) {
        return back()->withErrors([
            'bayar' => 'Uang bayar kurang. Total setelah diskon Rp ' . number_format($totalAkhir, 0, ',', '.')
        ])->withInput();
    }

    $kembalian = $bayar - $totalAkhir;

    $order->update([
        'subtotal'        => $subtotal,
        'discount_type'   => $discountType,
        'discount_value'  => $discountValue,
        'discount_amount' => $discountAmount,
        'total'           => $totalAkhir,
        'payment_status'  => 'paid',
        'payment_method'  => $request->payment_method,
        'bayar'           => $bayar,
        'kembalian'       => $kembalian,
    ]);

    return redirect('/invoice/' . $order->id)
        ->with('success', 'Pembayaran berhasil');
}



public function showQrisPage(Order $order)
{
    return view('kasir.qris', compact('order'));
}

public function confirmQrisPayment(Order $order)
{
    $order->update([
        'payment_status' => 'paid',
    ]);

    return redirect('/invoice/' . $order->id)
        ->with('success', 'QRIS berhasil diverifikasi');
}

}