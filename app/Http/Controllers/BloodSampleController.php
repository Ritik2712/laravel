<?php

namespace App\Http\Controllers;

use App\Models\BloodSample;
use Illuminate\Http\Request;

class BloodSampleController extends Controller
{
    public function index()
    {
        return BloodSample::with('hospital')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'blood_type' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $sample = BloodSample::create([
            'hospital_id' => auth()->id(),
            'blood_type' => $request->blood_type,
            'quantity' => $request->quantity,
        ]);

        return response()->json($sample, 201);
    }

    public function update(Request $request, BloodSample $bloodSample)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $bloodSample->update([
            'quantity' => $ bloodSample->quantity + $request->quantity,
        ]);

        return response()->json($bloodSample);
    }

    public function destroy(BloodSample $bloodSample)
    {
        if ($bloodSample->hospital_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bloodSample->delete();
        return response()->json(null, 204);
    }
}