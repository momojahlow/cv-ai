<?php

namespace App\Http\Controllers;

use App\Models\Competency;
use Illuminate\Http\Request;

class CompetencyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $user = auth()->user();
        $curriculum = $user->curriculum ?? $user->curriculum()->firstOrCreate([]);

        $curriculum->competencies()->create($validated);

        return redirect()->back()->with('success', 'Competency added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competency $competency)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $competency->update($validated);

        return redirect()->back()->with('success', 'Competency updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Competency $competency)
    {
        $competency->delete();
        return redirect()->back()->with('success', 'Hobby deleted successfully');
    }
}
