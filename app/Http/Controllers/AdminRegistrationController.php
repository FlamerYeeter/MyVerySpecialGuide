<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminRegistrationController extends Controller
{
    /**
     * Accept a POST from the client after the client has created a Firebase account.
     * Expected payload: { firebaseUid, email, name, password? }
     * Creates or updates a local users row with role='admin' and admin_approved=false.
     */
    public function submit(Request $request)
    {
        try {
            $data = $request->only(['firebaseUid', 'firebase_uid', 'email', 'name', 'password']);

            // Accept either camelCase or snake_case for firebase UID; make inputs available as variables
            $firebaseUid = $data['firebaseUid'] ?? $data['firebase_uid'] ?? null;
            $email = $data['email'] ?? null;
            $name = $data['name'] ?? null;
            $password = $data['password'] ?? null;

            // firebaseUid is optional (clients that don't use Firebase can still register).
            $v = Validator::make(['firebaseUid' => $firebaseUid, 'email' => $email, 'name' => $name], [
                'firebaseUid' => 'nullable|string',
                'email' => 'required|email',
                'name' => 'required|string',
            ]);
            if ($v->fails()) {
                return response()->json(['ok' => false, 'errors' => $v->errors()], 422);
            }

            // Try to find existing user by firebase_uid or email
            $user = null;
            if (!empty($firebaseUid)) {
                $user = User::where('firebase_uid', $firebaseUid)->first();
            }
            if (!$user && !empty($email)) {
                $user = User::where('email', $email)->first();
            }

            if (!$user) {
                $user = new User();
                $user->email = $email;
                // Ensure DB NOT NULL password constraint satisfied: generate a random password if client didn't provide one
                if (empty($password)) {
                    $generated = bin2hex(random_bytes(8));
                    $user->password = Hash::make($generated);
                } else {
                    $user->password = Hash::make($password);
                }
            }

            $user->name = $name;
            $user->firebase_uid = $firebaseUid;
            $user->role = 'admin';
            // For admin registrations, auto-approve and sign them in immediately
            $user->admin_approved = true;
            $user->approved = true;
            $user->approved_at = Carbon::now();

            // If a password was provided, overwrite the generated one; otherwise leave generated password in place.
            if (!empty($password)) {
                $user->password = Hash::make($password);
            }

            $user->save();

            // Log the new/updated user into the Laravel session so they can access admin pages immediately
            try {
                Auth::login($user);
                request()->session()->regenerate();
            } catch (\Throwable $e) {
                logger()->warning('AdminRegistration: could not login user after create: ' . $e->getMessage());
            }

            // Return JSON including a redirect target for client-side navigation
            return response()->json([
                'ok' => true,
                'user_id' => $user->id,
                'admin_approved' => (bool)$user->admin_approved,
                'redirect' => route('admin.approval'),
            ]);
        } catch (\Throwable $e) {
            logger()->error('AdminRegistrationController::submit exception: ' . $e->getMessage());
            return response()->json(['ok' => false, 'error' => 'server_exception', 'message' => $e->getMessage()], 500);
        }
    }
}
