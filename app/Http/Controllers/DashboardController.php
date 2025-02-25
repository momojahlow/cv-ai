<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Models\Member;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = new UserResource(auth()->user());
        return Inertia::render('Dashboard', [
            'user' => $user,
            'users' => $user->isAdmin() ? UserResource::collection(Member::all()) : []
        ]);
    }
}
