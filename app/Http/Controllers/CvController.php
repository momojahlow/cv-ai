public function generatePdf()
{
    $user = auth()->user()->load([
        'curriculum.experiences',
        'curriculum.educations',
        'curriculum.languages',
        'curriculum.competencies', // Add this line
        'curriculum.hobbies',      // Add this line
        // ... other relationships
    ]);

    $pdf = PDF::loadView('cv-pdf', [
        'user' => $user,
        'curriculum' => $user->curriculum
    ]);

    return $pdf->download('cv.pdf');
}