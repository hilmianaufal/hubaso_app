@extends('layouts.app')

@section('content')

<style>
    body {
        background: #0f172a;
    }

    .qris-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
    }

    .qris-card {
        background: white;
        border-radius: 36px;
        padding: 40px;
        max-width: 520px;
        width: 100%;
        text-align: center;
        box-shadow: 0 25px 60px rgba(0,0,0,.25);
    }

    .qris-total {
        font-size: 42px;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 24px;
    }

    .qris-image {
        background: #f8fafc;
        border-radius: 28px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .confirm-btn {
        border: none;
        width: 100%;
        border-radius: 22px;
        padding: 18px;
        background: linear-gradient(135deg,#16a34a,#22c55e);
        color: white;
        font-size: 18px;
        font-weight: 800;
    }
</style>

<div class="qris-container">

    <div class="qris-card">

        <div style="font-size:64px;" class="mb-3">
            📱
        </div>

        <h2 class="fw-bold mb-2">
            Pembayaran QRIS
        </h2>

        <p class="text-muted mb-4">
            Silakan scan QRIS untuk melakukan pembayaran
        </p>

        <div class="qris-total">
            Rp {{ number_format($order->total) }}
        </div>

        <div class="qris-image">

            {{-- GANTI DENGAN QRIS ASLI --}}
            <img src="{{ asset('qris/qris.jpeg') }}"
                 style="width:100%; max-width:300px;">

        </div>

        <div class="alert alert-warning rounded-4 mb-4">

            <strong>Menunggu Pembayaran</strong>
            <br>

            Pastikan customer sudah melakukan transfer QRIS.

        </div>

        <form action="/kasir/qris/{{ $order->id }}/confirm"
              method="POST">

            @csrf

            <button class="confirm-btn">

                ✅ Konfirmasi Pembayaran

            </button>

        </form>

    </div>

</div>

@endsection