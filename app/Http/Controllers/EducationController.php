<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'level' => 'required|string',
            'type' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'school' => 'required|string',
            'diploma' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $user = auth()->user();
        $curriculum = $user->curriculum;

        if (!$curriculum) {
            return response()->json([
                'success' => false,
                'message' => 'Curriculum not found'
            ], 404);
        }

        $education = $curriculum->education()->create([
            ...$validated,
            'status' => 'completed'
        ]);

        return response()->json([
            'success' => true,
            'education' => $education
        ]);
    }

    public function destroy(Education $education)
    {
        $user = auth()->user();
        
        if ($education->curriculum->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $education->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
