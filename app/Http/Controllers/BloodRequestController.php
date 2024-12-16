<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\BloodSample;
use Illuminate\Http\Request;

class BloodRequestController extends Controller
{
    public function index()
    {
        return BloodRequest::with(['bloodSample', 'receiver'])
            ->whereHas('bloodSample', function ($query) {
                $query->where('hospital_id', auth()->id());
            })
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'blood_sample_id' => 'required|exists:blood_samples,id',
        ]);

        $bloodSample = BloodSample::findOrFail($request->blood_sample_id);

        $bloodRequest = BloodRequest::create([
            'blood_sample_id' => $request->blood_sample_id,
            'receiver_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return response()->json($bloodRequest, 201);
    }

    public function update(Request $request, BloodRequest $bloodRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        if ($bloodRequest->bloodSample->hospital_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bloodRequest->update([
            'status' => $request->status,
        ]);

        if ($request->status === 'approved') {
            $bloodRequest->bloodSample->decrement('quantity');
        }

        return response()->json($bloodRequest);
    }
}