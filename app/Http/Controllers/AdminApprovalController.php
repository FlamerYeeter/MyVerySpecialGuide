<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdminApprovalController extends Controller
{
    // List pending approvals for roles of interest
    public function pending(Request $request)
    {
        // roles that require admin approval
        $roles = ['admin', 'expert', 'company', 'guardian', 'user'];
        $q = User::whereIn('role', $roles)
            ->where(function($q) {
                $q->where('approved', false)->orWhereNull('approved');
            })
            ->orderBy('created_at', 'asc')
            ->limit(200);

        $users = $q->get(['id','name','email','role','firebase_uid','created_at','admin_approved','approved','approved_at']);
        return response()->json(['ok' => true, 'pending' => $users]);
    }

    // Approve a given user id
    public function approve(Request $request, $id)
    {
        $actor = $request->user();
        if (!$actor) return response()->json(['ok' => false, 'error' => 'unauthenticated'], 401);

        // Only an already approved admin can approve others
        if (($actor->role ?? null) !== 'admin' || !($actor->approved ?? false) || !($actor->admin_approved ?? false)) {
            return response()->json(['ok' => false, 'error' => 'forbidden'], 403);
        }

        $user = User::find($id);
        if (!$user) return response()->json(['ok' => false, 'error' => 'not_found'], 404);

        $user->approved = true;
        $user->approved_at = Carbon::now();
        // If this is an admin user, also flip admin_approved
        if (($user->role ?? null) === 'admin') {
            $user->admin_approved = true;
        }
        $user->save();

        return response()->json(['ok' => true, 'user_id' => $user->id, 'approved' => true]);
    }

    // Reject a given user id (marks approved=false and optionally adds a note)
    public function reject(Request $request, $id)
    {
        $actor = $request->user();
        if (!$actor) return response()->json(['ok' => false, 'error' => 'unauthenticated'], 401);
        if (($actor->role ?? null) !== 'admin' || !($actor->approved ?? false) || !($actor->admin_approved ?? false)) {
            return response()->json(['ok' => false, 'error' => 'forbidden'], 403);
        }

        $user = User::find($id);
        if (!$user) return response()->json(['ok' => false, 'error' => 'not_found'], 404);

        $user->approved = false;
        // If admin, ensure admin_approved false too
        if (($user->role ?? null) === 'admin') $user->admin_approved = false;
        $user->save();

        return response()->json(['ok' => true, 'user_id' => $user->id, 'approved' => false]);
    }
}
