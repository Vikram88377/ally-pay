<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $auditLogs = AuditLog::with('user')
            ->when($request->action, function ($query) use ($request) {
                $query->where('action', $request->action);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $actions = AuditLog::query()
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('admin.audit-logs.index', compact(
            'auditLogs',
            'actions'
        ));
    }

    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user');

        return view('admin.audit-logs.show', compact('auditLog'));
    }
}