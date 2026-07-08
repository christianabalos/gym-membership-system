<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with(['user', 'memberships.trainer'])->latest()->get();

        if (request()->is('api/*')) {
            return response()->json($members);
        }

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable',
            'address' => 'nullable',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable',
        ]);

        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
        ]);

        $member = Member::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
        ]);

        if (request()->is('api/*')) {
            return response()->json([
                'message' => 'Member added successfully.',
                'data' => $member->load('user'),
            ], 201);
        }

        return redirect()->route('members.index')
            ->with('success', 'Member added successfully.');
    }

    public function show(Member $member)
    {
        $member->load('user');

        if (request()->is('api/*')) {
            return response()->json($member);
        }

        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'full_name' => 'required',
            'phone' => 'nullable',
            'address' => 'nullable',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable',
        ]);

        $member->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
        ]);

        if ($member->user) {
            $member->user->update([
                'name' => $request->full_name,
            ]);
        }

        if (request()->is('api/*')) {
            return response()->json([
                'message' => 'Member updated successfully.',
                'data' => $member->load('user'),
            ]);
        }

        return redirect()->route('members.index')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        if ($member->user) {
            $member->user->delete();
        }

        $member->delete();

        if (request()->is('api/*')) {
            return response()->json([
                'message' => 'Member deleted successfully.',
            ]);
        }

        return redirect()->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }
}