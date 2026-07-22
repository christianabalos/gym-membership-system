<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberRequestController extends Controller
{
    public function memberIndex()
    {
        $member = Member::where('user_id', Auth::id())->first();

        $requests = MemberRequest::with(['member', 'user'])
            ->where('member_id', $member?->id)
            ->latest()
            ->get();

        return view('requests.index', compact('requests'));
    }

    public function create()
    {
        return view('requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $member = Member::where('user_id', Auth::id())->first();

        if (!$member) {
            return redirect()
                ->route('member.dashboard')
                ->withErrors(['member' => 'Member profile not found.']);
        }

        MemberRequest::create([
            'user_id' => Auth::id(),
            'member_id' => $member->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect('/member/requests')
            ->with('success', 'Request sent to admin successfully.');
    }

    public function adminIndex()
    {
        $requests = MemberRequest::with(['member', 'user'])
            ->latest()
            ->get();

        return view('requests.admin-index', compact('requests'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,resolved,rejected',
        ]);

        $memberRequest = MemberRequest::findOrFail($id);

        $memberRequest->update([
            'status' => $request->status,
        ]);

        return redirect('/admin/member-requests')
            ->with('success', 'Request status updated successfully.');
    }

    public function destroy(MemberRequest $memberRequest)
    {
        $memberRequest->delete();

        return redirect('/admin/member-requests')
            ->with('success', 'Request deleted successfully.');
    }
}