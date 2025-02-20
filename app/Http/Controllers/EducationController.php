<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user has a curriculum, if not create one
        if (!$user->curriculum) {
            $curriculum = Curriculum::create([
                'user_id' => $user->id
            ]);
            $user->refresh();
        }

        $validated = $request->validate([
            'level' => 'required|string |min:2|max:255',
            'type' => 'required|string |min:2|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'school' => 'required|string |min:2|max:255',
            'diploma' => 'required|string |min:2|max:255',
            'city' => 'nullable|string|min:2|max:255',
            'country' => 'nullable|string |min:2|max:255',
            'description' => 'nullable|string |min:10|max:255'
        ]);

        $education = $user->curriculum->educations()->create([
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
        $user = Auth::user();

        // Check if user has a curriculum, if not create one
        if (!$user->curriculum) {
            $curriculum = Curriculum::create([
                'user_id' => $user->id
            ]);
            $user->refresh();
        }

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

    public function update(Request $request, Education $education)
    {
        $user = Auth::user();

        if ($education->curriculum->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'level' => 'required|string',
            'type' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'school' => 'required|string',
            'diploma' => 'required|string',
            'description' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string'
        ]);

        $education->update($validated);

        return response()->json([
            'success' => true,
            'education' => $education
        ]);
    }
}
