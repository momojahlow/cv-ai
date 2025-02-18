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
    public function __invoke(Request $request, $color = 'primary')
    {
        $user = auth()->user();
        $curriculum = $user->curriculum()->with(['experiences', 'educations', 'languages'])->first();

        if (!$curriculum) {
            abort(404, "Curriculum not found.");
        }

        $educations = $curriculum->educations;
        $experiences = $curriculum->experiences;
        $languages = $curriculum->languages;

        if ($request->route()->getName() === 'curriculum.pdf') { // Ensure route name matches
            // Ensure directory exists
            if (!Storage::exists('public/cv')) {
                Storage::makeDirectory('public/cv');
            }

            // Generate HTML
            $html = view('cv', compact('user', 'curriculum', 'educations', 'experiences', 'languages', 'color'))->render();

            // Save PDF
            $pdfPath = Storage::path("public/cv/cv-{$user->id}.pdf");
            Browsershot::html($html)
                ->format('A4')
                ->save($pdfPath);

            return response()->download($pdfPath);
        }
        return view('cv', compact('user', 'curriculum', 'educations', 'experiences', 'languages', 'color'));
    }
}
