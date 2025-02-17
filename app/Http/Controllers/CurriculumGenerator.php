<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Browsershot\Browsershot;
use PDF;

class CurriculumGenerator extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        $curriculum = $user->curriculum()->with(['experiences', 'educations', 'languages'])->first();
        $educations = $curriculum->educations;
        $experiences = $curriculum->experiences;
        $languages = $curriculum->languages;
        $html = view('cv', compact('user', 'curriculum', 'educations', 'experiences', 'languages'))->render();
        if ($request->route()->getName() === 'cv-pdf') {
            // $pdf = PDF::loadView('cv-pdf', compact('user', 'curriculum', 'educations', 'experiences', 'languages'));
            // return $pdf->download('cv.pdf');
            Browsershot::html($html)
            ->format('A4') // Format du PDF
            ->save(storage_path('app/public/cv.pdf'));
            return response()->download(storage_path('app/public/cv.pdf'));
        }


        $data = [
            'user' => $user,
            'curriculum' => $curriculum,
            'educations' => $curriculum->educations,
            'experiences' => $curriculum->experiences,
            'languages' => $curriculum->languages
        ];
        return view('cv', $data);
    }
}
