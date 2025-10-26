<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\FirestoreAdminService;

class AdminAssignmentController extends Controller
{
    protected $fs;

    public function __construct(FirestoreAdminService $fs)
    {
        $this->fs = $fs;
    }

    // Show list and simple form
    public function index(Request $request)
    {
        $assignments = $this->fs->listAssignments();
        return view('admin.admin-manage-admins', ['assignments' => $assignments]);
    }

    // Assign a UID as admin
    public function store(Request $request)
    {
        $this->validate($request, [
            'firebase_uid' => 'required|string',
            'email' => 'nullable|email',
        ]);

        $uid = $request->input('firebase_uid');
        $email = $request->input('email');
        $assignedBy = auth()->check() ? (string)auth()->id() : 'system';

        $ok = $this->fs->assign($uid, $email, $assignedBy);
        if ($ok) {
            return redirect()->route('admin.admins')->with('status', 'Assigned admin: ' . $uid);
        }
        return redirect()->route('admin.admins')->with('error', 'Failed to assign admin. Check service account and network.');
    }

    // Revoke admin by UID
    public function destroy(Request $request, $uid)
    {
        $revokedBy = auth()->check() ? (string)auth()->id() : 'system';
        $ok = $this->fs->revoke($uid, $revokedBy);
        if ($ok) {
            return redirect()->route('admin.admins')->with('status', 'Revoked admin: ' . $uid);
        }
        return redirect()->route('admin.admins')->with('error', 'Failed to revoke admin.');
    }
}
