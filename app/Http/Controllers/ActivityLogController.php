<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activityLogs = ActivityLog::latest()->paginate(20);
        return view('activity-log', [
            'title' => 'Activity Log',
            'activityLogs' => $activityLogs
        ]);
    }
}
