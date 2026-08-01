<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;


class JobVacancyController extends Controller
{
     /**
     * Display a listing of the resource.
     */

    public $industries = [
            'Technology',
            'Finance',
            'Healthcare',
            'Education',
            'Retail',
            'Manufacturing',
            'Hospitality',
            'Transportation',
            'Energy',
            'Telecommunications',
        ];
  public function index(Request $request)
{
    $query = JobVacancy::query();

    // Company Owner: only jobs belonging to his company
    if (auth()->user()->role === 'company-owner') {

        $company = auth()->user()->company;

        $query->where('companyId', $company->id);

    }

    // Show archived job vacancies only
    if ($request->boolean('archived')) {

        $query->onlyTrashed();

    } else {

        $query->latest();

    }

    $jobVacancies = $query
        ->paginate(10)
        ->onEachSide(1);

    return view('job-vacancy.index', compact('jobVacancies'));
}

    /**
     * Show the form for creating a new resource.
     */
    /**
 * Show the form for creating a new resource.
 */
public function create()
{
    $categories = JobCategory::orderBy('name')->get();

    $companies = auth()->user()->role === 'admin'
        ? Company::orderBy('name')->get()
        : collect();

    return view('job-vacancy.create', compact('companies', 'categories'));
}

/**
 * Store a newly created resource in storage.
 */
public function store(JobVacancyCreateRequest $request)
{
   $validated = $request->validated();

if (auth()->user()->role === 'company-owner') {
    $validated['companyId'] = auth()->user()->company->id;
}

JobVacancy::create($validated);

return redirect()
    ->route('job-vacancy.index')
    ->with('success', 'Job vacancy created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job-vacancy.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $jobVacancy = JobVacancy::findOrFail($id);

    $categories = JobCategory::orderBy('name')->get();

    $companies = auth()->user()->role === 'admin'
        ? Company::orderBy('name')->get()
        : collect();

    return view('job-vacancy.edit', compact(
        'jobVacancy',
        'companies',
        'categories'
    ));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $validated = $request->validated();

        if (auth()->user()->role === 'company-owner') {
            $validated['companyId'] = $jobVacancy->companyId;
        }


        $jobVacancy->update($validated);

        return redirect()
            ->route('job-vacancy.index')
            ->with('success', 'Job vacancy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        return redirect()
            ->route('job-vacancy.index')
            ->with('success', 'Job vacancy deleted successfully.');
    }

    public function restore(string $id)
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();

        return redirect()
            ->route('job-vacancy.index')
            ->with('success', 'Job vacancy restored successfully.');
    }

}
