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
        // Last 30 days active users (job-seeker role)
        $activeUsers = User::where('role', 'job-seeker')
            ->whereNotNull('last_login_at')
            ->where('last_login_at', '>=', now()->subDays(30))
            ->count();

        // Total active job vacancies (not archived)
        $activeJobVacancies = JobVacancy::count();

        // Total job applications (not archived)
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

        // Conversion rates
        // Top Converting Job Posts
        $conversionRates = JobVacancy::with('company')
            ->withCount('jobApplications as totalCount')
            ->having('totalCount', '>', 0)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get()
            ->map(function (JobVacancy $job) {

                if ($job->viewCount > 0) {
                    $job->conversionRate = round(
                        ($job->totalCount / $job->viewCount) * 100,
                        2
                    );
                } else {
                    $job->conversionRate = 0;
                }

                return $job;
            });


        return view('dashboard.index', compact('analytics','mostAppliedJobs','conversionRates'));
    }
}
