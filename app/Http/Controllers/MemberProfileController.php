<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberProfileController extends Controller
{
    public function edit()
    {
        $member = auth()->user()->member;

        return view('member.profile', compact('member'));
    }

    public function update(Request $request)
    {
        $member = auth()->user()->member;

        if (!$member) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Member profile not found.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',

            'health_declaration' => 'nullable|string',
            'no_health_issue' => 'nullable|boolean',

            'emergency_name' => 'nullable|string|max:255',
            'emergency_relationship' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',

            // Password fields
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $validated['no_health_issue'] = $request->has('no_health_issue');

        if ($request->filled('password')) {

            if (!Hash::check($request->current_password, auth()->user()->password)) {
                return back()->withErrors([
                    'current_password' => 'Current password is incorrect.'
                ])->withInput();
            }

            if (Hash::check($request->password, auth()->user()->password)) {
                return back()->withErrors([
                    'password' => 'Your new password must be different from your current password.'
                ])->withInput();
            }
        }        

        $member->update([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'health_declaration' => $validated['health_declaration'] ?? null,
            'no_health_issue' => $validated['no_health_issue'],
            'emergency_name' => $validated['emergency_name'] ?? null,
            'emergency_relationship' => $validated['emergency_relationship'] ?? null,
            'emergency_phone' => $validated['emergency_phone'] ?? null,
        ]);

        if ($request->filled('password')) {

            auth()->user()->update([
                'password' => Hash::make($request->password),
            ]);

        }        

        return back()->with('success', 'Profile updated successfully!');
    }
}
