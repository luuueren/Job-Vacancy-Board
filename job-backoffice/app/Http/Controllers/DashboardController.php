<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index()
{
    if (auth()->user()->role === 'admin') {

        $data = $this->adminDashboard();

    } else {

        $data = $this->companyOwnerDashboard();

    }

    return view('dashboard.index', $data);
}

private function adminDashboard(): array
{
    // Last 30 days active users
    $activeUsers = User::where('role', 'job-seeker')
        ->whereNotNull('last_login_at')
        ->where('last_login_at', '>=', now()->subDays(30))
        ->count();

    // Total active job vacancies
    $activeJobVacancies = JobVacancy::count();

    // Total applications
    $totalApplications = JobApplication::count();

    $analytics = [
        'activeUsers' => $activeUsers,
        'activeJobVacancies' => $activeJobVacancies,
        'totalApplications' => $totalApplications,
    ];

    // Most Applied Jobs
    $mostAppliedJobs = JobVacancy::with('company')
        ->withCount('jobApplications as totalCount')
        ->orderByDesc('totalCount')
        ->limit(5)
        ->get();

    // Conversion Rates
    $conversionRates = JobVacancy::with('company')
        ->withCount('jobApplications as totalCount')
        ->having('totalCount', '>', 0)
        ->orderByDesc('totalCount')
        ->limit(5)
        ->get()
        ->map(function (JobVacancy $job) {

            $job->conversionRate = $job->viewCount > 0
                ? round(($job->totalCount / $job->viewCount) * 100, 2)
                : 0;

            return $job;
        });

    return compact(
        'analytics',
        'mostAppliedJobs',
        'conversionRates'
    );
}

private function companyOwnerDashboard(): array
{
    $company = auth()->user()->company;

    // Active job vacancies
    $activeJobVacancies = JobVacancy::where('companyId', $company->id)
        ->count();

    // Total applications
    $totalApplications = JobApplication::whereHas(
        'jobVacancy',
        function ($query) use ($company) {

            $query->where('companyId', $company->id);

        }
    )->count();

    $analytics = [
        'activeUsers' => null,
        'activeJobVacancies' => $activeJobVacancies,
        'totalApplications' => $totalApplications,
    ];

    // Most Applied Jobs
    $mostAppliedJobs = JobVacancy::where('companyId', $company->id)
        ->withCount('jobApplications as totalCount')
        ->orderByDesc('totalCount')
        ->limit(5)
        ->get();

    // Conversion Rates
    $conversionRates = JobVacancy::where('companyId', $company->id)
        ->withCount('jobApplications as totalCount')
        ->having('totalCount', '>', 0)
        ->orderByDesc('totalCount')
        ->limit(5)
        ->get()
        ->map(function (JobVacancy $job) {

            $job->conversionRate = $job->viewCount > 0
                ? round(($job->totalCount / $job->viewCount) * 100, 2)
                : 0;

            return $job;
        });

    return compact(
        'analytics',
        'mostAppliedJobs',
        'conversionRates'
    );
}



}
