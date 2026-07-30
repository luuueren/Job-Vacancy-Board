<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationCreateRequest;
use App\Http\Requests\JobApplicationUpdateRequest;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobApplication::with([
            'user',
            'resume',
            'jobVacancy'
        ]);

        if ($request->boolean('archived')) {
            $query->onlyTrashed();
        } else {
            $query->latest();
        }

        $jobApplications = $query
            ->paginate(10)
            ->onEachSide(1);

        return view('job-application.index', compact('jobApplications'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::with([
            'user',
            'resume',
            'jobVacancy'
        ])->findOrFail($id);

        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);

        return view('job-application.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdateRequest $request, string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);

        $jobApplication->update($request->validated());

        return redirect()
            ->route('application.index')
            ->with('success', 'Job application updated successfully.');
    }

    /**
     * Archive the specified resource.
     */
   public function destroy(string $id)
{
    $jobApplication = JobApplication::findOrFail($id);

    $jobApplication->delete();

    return redirect()
        ->route('application.index')
        ->with('success', 'Job application archived successfully.');
}

    /**
     * Restore the specified resource.
     */
    public function restore(string $id)
    {
        $jobApplication = JobApplication::onlyTrashed()->findOrFail($id);

        $jobApplication->restore();

        return redirect()
            ->route('application.index', ['archived' => true])
            ->with('success', 'Job application restored successfully.');
    }
}
