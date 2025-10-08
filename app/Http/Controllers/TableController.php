<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $table = Table::create([
            'table_capacity' => $validated['tableCapacity'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'create',
            'description' => 'Created a new table: Table #' . $table->table_id . '.'
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

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'update',
            'description' => 'Updated a table: Table #' . $table->table_id . '.'
        ]);

        return redirect()->route('table.index')->with('success', 'Table updated successfully!');
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $tableId = $table->table_id;
        $table->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'delete',
            'description' => 'Deleted a table: Table #' . $tableId . '.'
        ]);

        return redirect()->route('table.index')->with('success', 'Table deleted successfully!');
    }
}
