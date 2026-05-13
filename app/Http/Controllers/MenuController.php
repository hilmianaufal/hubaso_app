<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private function uploadFolder()
    {
        return base_path('../public_html/hubaso/uploads/menus');
    }

    private function uploadFile($file)
    {
        $folder = $this->uploadFolder();

        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $file->move($folder, $filename);

        return 'uploads/menus/' . $filename;
    }

    private function deleteFile($path)
    {
        if (!$path) {
            return;
        }

        $filePath = base_path('../public_html/hubaso/' . $path);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

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
            $foto = $this->uploadFile($request->file('foto'));
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
            $this->deleteFile($menu->foto);

            $foto = $this->uploadFile($request->file('foto'));
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
        $this->deleteFile($menu->foto);

        $menu->delete();

        return redirect('/menus')->with('success', 'Menu berhasil dihapus');
    }
}