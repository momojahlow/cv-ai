<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;

class HobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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

        $curriculum->hobbies()->create($validated);

        return redirect()->back()->with('success', 'Hobby added successfully');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hobby $hobby)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $hobby->update($validated);

        return redirect()->back()->with('success', 'Hobby updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hobby $hobby)
    {
        $hobby->delete();

        return redirect()->back()->with('success', 'Hobby deleted successfully');
    }
}
