<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::paginate(10);
        return view('table', [
            'title' => 'Table',
            'tables' => $tables
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tableCapacity' => 'required|in:2,4,8',
        ]);

        Table::create([
            'table_capacity' => $validated['tableCapacity'],
        ]);

        return redirect()->route('table.index')->with('success', 'Table added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tableCapacity' => 'required|in:2,4,8',
        ]);

        $table = Table::findOrFail($id);
        $table->table_capacity = $validated['tableCapacity'];
        $table->save();

        return redirect()->route('table.index')->with('success', 'Table updated successfully!');
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return redirect()->route('table.index')->with('success', 'Table deleted successfully!');
    }
}
