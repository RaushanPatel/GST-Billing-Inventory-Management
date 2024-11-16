<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Import Carbon

class ApplicationController extends Controller
{
    private const DEFAULT_RECEIVER = 'MR TATA';
    private const DEFAULT_SUBJECT = 'List';

    // Show form to create application
    public function create()
    {
        return view('applications.create');
    }

    // Store application data
    public function store(Request $request)
    {
        $validated = $this->validateApplication($request);

        $applicationData = $this->createApplicationData($validated);

        // Ensure the user is authenticated and add user_id to the application data
        $user = $request->user(); // Get the authenticated user
            if ($user) {
            $applicationData['user_id'] = $user->id;
        } else {
            // Handle case where user is not authenticated (optional)
            return redirect()->route('login')->with('error', 'You must be logged in to create an application.');
        }

        $application = Application::create($applicationData);

        return redirect()
            ->route('bills.create', ['application' => $application->id])
            ->with('success', 'Application created successfully.');
    }

    private function validateApplication(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    }

    private function createApplicationData(array $validated): array
    {
        return array_merge($validated, [
            'date' => Carbon::now(), // Use Carbon to get the current date and time
            'to' => self::DEFAULT_RECEIVER,
            'subject' => self::DEFAULT_SUBJECT,
        ]);
    }
}

