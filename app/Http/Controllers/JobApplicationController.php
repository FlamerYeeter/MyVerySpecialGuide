<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class JobApplicationController extends Controller
{
    public function submit(Request $request)
    {
        // Collect form data
        $data = $request->all();
        $user_id = 'user1234'; // Temporary user ID

        // Initialize Firebase
        $firebase = (new Factory)
            ->withServiceAccount(base_path('firebase.json')) // Download your Firebase service account and put as firebase.json
            ->withDatabaseUri('https://<your-database-name>.firebaseio.com'); // Replace with your Firebase DB URL

        $database = $firebase->createDatabase();

        // Save application data
        $database
            ->getReference('applications/' . $user_id)
            ->push($data);

        return redirect()->route('job.application.submit')->with('success', 'Application submitted!');
    }
}
