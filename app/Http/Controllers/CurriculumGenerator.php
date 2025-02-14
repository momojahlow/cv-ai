<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CurriculumGenerator extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user()->load([
            'curriculum.experiences',
            'curriculum.educations'
        ]);

        $data = [
            'user' => $user,
            'curriculum' => $user->curriculum,
            'educations' => $user->curriculum->educations ?? [],
            'experiences' => $user->curriculum->experiences ?? [],
        ];
        dd($data);

        if ($request->route()->getName() === 'cv-pdf') {
            $pdf = PDF::loadView('cv-pdf', $data);
            return $pdf->download('cv-pdf.pdf');
        }
        return view('cv-pdf', $data);
    }
}
