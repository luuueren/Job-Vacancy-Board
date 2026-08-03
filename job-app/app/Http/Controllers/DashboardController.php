<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::with('company');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhereHas('company', function ($company) use ($search) {

                        $company->where('name', 'like', "%{$search}%");

                    });

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter by Job Type
        |--------------------------------------------------------------------------
        */

        if ($request->filled('type')) {

            $query->where('type', $request->type);

        }

        $jobs = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard', compact('jobs'));
    }
}
