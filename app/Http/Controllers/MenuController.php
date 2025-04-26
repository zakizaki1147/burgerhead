<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::paginate(10);
        return view('menu', [
            'title' => 'Menu',
            'menus' => $menus
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menuName' => 'required|string|max:100',
            'menuPrice' => 'required|numeric|min:1',
        ]);

        Menu::create([
            'menu_name' => $validated['menuName'],
            'price' => $validated['menuPrice'],
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'menuName' => 'required|string|max:100',
            'menuPrice' => 'required|numeric|min:1'
        ]);

        $menu = Menu::findOrFail($id);
        $menu->menu_name = $validated['menuName'];
        $menu->price = $validated['menuPrice'];
        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Menu updated successfully!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu deleted successfully!');
    }
}
