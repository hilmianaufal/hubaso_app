<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class RestaurantTableController extends Controller
{
    public function index()
    {
        $tables = RestaurantTable::latest()->get();

        return view('tables.index', compact('tables'));
    }

    public function create()
    {
    return view('tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|string|max:50|unique:restaurant_tables,nomor_meja',
        ]);

        RestaurantTable::create([
            'nomor_meja' => $request->nomor_meja
        ]);

        return redirect('/tables')->with('success', 'Meja berhasil ditambahkan');
    }

    public function destroy(RestaurantTable $table)
        {
            $table->delete();

            return redirect()
                ->route('tables.index')
                ->with('success', 'Meja berhasil dihapus');
        }
}
