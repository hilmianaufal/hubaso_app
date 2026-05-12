<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->latest()->get();

        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama'        => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('menus', 'public');
        }

        Menu::create([
            'category_id' => $request->category_id,
            'nama'        => $request->nama,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'foto'        => $foto,
        ]);

        return redirect('/menus')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::all();

        return view('menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama'        => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $foto = $menu->foto;

        if ($request->hasFile('foto')) {
            if ($menu->foto) {
                Storage::disk('public')->delete($menu->foto);
            }

            $foto = $request->file('foto')->store('menus', 'public');
        }

        $menu->update([
            'category_id' => $request->category_id,
            'nama'        => $request->nama,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'foto'        => $foto,
        ]);

        return redirect('/menus')->with('success', 'Menu berhasil diupdate');
}

    public function destroy(Menu $menu)
    {
        // hapus foto
        if ($menu->foto) {

            Storage::disk('public')
                    ->delete($menu->foto);
        }

        // hapus data
        $menu->delete();

        return redirect('/menus');
    }
}
