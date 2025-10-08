<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'menuName' => 'required|string|max:100|unique:menus,menu_name',
            'menuPrice' => 'required|numeric|min:1',
        ], [
            'menuName.unique' => 'Menu name already exists! Please use different name!'
        ]);

        $menu = Menu::create([
            'menu_name' => $validated['menuName'],
            'price' => $validated['menuPrice'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'create',
            'description' => 'Created a new menu: ' . $menu->menu_name . '.'
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'menuName' => 'required|string|max:100|unique:menus,menu_name,' . $id . ',menu_id',
            'menuPrice' => 'required|numeric|min:1'
        ], [
            'menuName.unique' => 'Menu name already exists! Please use different name!'
        ]);

        $menu = Menu::findOrFail($id);
        $menu->menu_name = $validated['menuName'];
        $menu->price = $validated['menuPrice'];
        $menu->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'update',
            'description' => 'Updated a menu: ' . $menu->menu_name . '.'
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu updated successfully!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menuName = $menu->menu_name;
        $menu->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'delete',
            'description' => 'Deleted a menu: ' . $menuName . '.'
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu deleted successfully!');
    }
}
