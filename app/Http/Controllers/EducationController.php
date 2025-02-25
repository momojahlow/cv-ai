<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EducationController extends Controller
{
    use AuthorizesRequests;
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

        $user->curriculum->educations()->create([
            ...$validated,
            'status' => 'completed'
        ]);

        return back()->with('success', 'Education added successfully');
    }

    public function destroy(Education $education)
    {
        // $this->authorize('delete', $education);
        if (!Gate::allows('delete', $education)) {
            return back()->withErrors([
                'message' => 'Vous ne pouvez pas supprimer cette formation.',
            ]);
        }

        // $education->delete();

        return redirect()->back()->with('success', 'Education deleted successfully');
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
            'level' => 'required|string | min:2|max:255',
            'type' => 'required|string | min:2|max:255',
            'start_date' => 'required|string | min:2|max:255',
            'end_date' => 'required|string | min:2|max:255',
            'school' => 'required|string | min:2|max:255',
            'diploma' => 'required|string | min:2|max:255',
            'description' => 'nullable|string | min:2|max:255',
            'city' => 'nullable|string | min:2|max:255',
            'country' => 'nullable|string | min:2|max:255'
        ]);

        $education->update($validated);

        return  redirect()->back()->with('success', 'Education updated successfully');
    }
}
