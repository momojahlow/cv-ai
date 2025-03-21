<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

use PDF;

class CurriculumGenerator extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request,$id ,$color)
    {
        $user = User::find($id);        
        if (!$user) {
            abort(404, "User not found.");
        }
        $curriculum = $user->curriculum()->with(['experiences', 'educations', 'languages'])->first();
        // dd($curriculum);
        if (!$curriculum) {
            return redirect()->route('curriculum.index')->with('error', 'Complétez dabord votre cv.');
        }

        $educations = $curriculum->educations;
        $experiences = $curriculum->experiences;
        $languages = $curriculum->languages;
        $hobbies = $curriculum->hobbies;

        if ($request->route()->getName() === 'curriculum.pdf') { 
            if (!Storage::disk('public')->exists('cv')) {
                // Storage::makeDirectory('public/cv');
                Storage::disk('public')->makeDirectory('cv');
            }
            // dd($color);
            $html = view('cv-pdf', compact('user', 'curriculum', 'educations', 'experiences', 'languages', 'hobbies', 'color'))->render();

            // Save PDF
            $pdfRelativePath = "cv/cv-{$user->id}.pdf";
            $pdfPath = Storage::disk('public')->path($pdfRelativePath);
            // $pdfPath = Storage::path("public/cv/cv-{$user->id}.pdf");
            Browsershot::html($html)
                ->format('A4')
                ->save($pdfPath);

            return response()->download($pdfPath);
        }
        return view('cv', compact('user', 'curriculum', 'educations', 'experiences', 'languages', 'hobbies', 'color'));
    }
}

