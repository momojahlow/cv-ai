<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CorrectorSection extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        
        $user->load('curriculum');
        $user->load('curriculum.experiences');
        $user->load('curriculum.educations');

        $data = [
            'user' => $user,
            'curriculum' => $user->curriculum,
            'education' => $user->curriculum?->educations ?? [],
            'experience' => $user->curriculum?->experiences ?? [],
            'formations' => session('formations', [])
        ];

        if ($request->route()->getName() === 'cv-pdf') {
            $pdf = PDF::loadView('cv-pdf', $data);
            return $pdf->download('cv.pdf');
        }

        return view('cv', $data);
    }
}
