<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditLogsController extends Controller
{
    public function index()
    {
        $auditLogs = AuditLog::with('user:id,name')->latest()->paginate();
        return view('dashboard.setting.auditLogs.index', compact('auditLogs'));
    } //end of index

    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user:id,name');
        return view('dashboard.setting.auditLogs.show', compact('auditLog'));
    } //end of show
}//end of controller
