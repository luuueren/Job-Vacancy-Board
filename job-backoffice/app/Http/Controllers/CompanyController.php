<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;




class CompanyController extends Controller
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
        $query = Company::query();

        // Show archived companies only
        if ($request->boolean('archived')) {
            $query->onlyTrashed();
        } else {
            $query->latest();
        }

        $companies = $query
            ->paginate(10)
            ->onEachSide(1);

        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('company.create', [
            'industries' => $this->industries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
    $validatedData = $request->validated();

    // create owner user
    $owner = User::create([
        'name' => $validatedData['owner_name'],
        'email' => $validatedData['owner_email'],
        'password' => Hash::make($validatedData['owner_password']),
        'role' => 'company-owner', // Assuming you have a role field to differentiate user types
    ]);

    // return error if owner creation fails
    if (!$owner) {
        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['owner_creation' => 'Failed to create company owner. Please try again.']);
    }

        // create the company
        $company = Company::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'industry' => $validatedData['industry'],
            'website' => $validatedData['website'] ?? null,
            'ownerId' => $owner->id,
        ]);

        return redirect()
            ->route('company.index')
            ->with('success', 'Company created successfully.');

    }

    /**
     * Display the specified resource.
     */
   public function show(string $id)
{
    $company = Company::findOrFail($id);

    $applications = JobApplication::with(['user', 'jobVacancy'])
        ->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))
        ->get();

    return view('company.show', compact('company', 'applications'));
}

public function showMyCompany()
{
    $company = auth()->user()->company;

    if (! $company) {
        abort(404, 'No company found for this account.');
    }

    $company->load('jobVacancies');

    $applications = JobApplication::with(['user', 'jobVacancy'])
        ->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))
        ->get();

    return view('company.show', compact('company', 'applications'));
}
    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $id)
{
    $company = Company::findOrFail($id);

    return view('company.edit', [
        'company' => $company,
        'industries' => $this->industries,
    ]);
}

public function editMyCompany()
{
    $company = auth()->user()->company;

    if (! $company) {
        abort(404, 'No company found for this account.');
    }

    $company->load('owner');

    return view('company.edit', [
        'company' => $company,
        'industries' => $this->industries,
    ]);
}

    /**
     * Update the specified resource in storage.
     */
   public function update(CompanyUpdateRequest $request, string $id)
{
    $company = Company::findOrFail($id);

    $validated = $request->validated();

    // Update company information
    $company->update([
        'name' => $validated['name'],
        'address' => $validated['address'],
        'industry' => $validated['industry'],
        'website' => $validated['website'] ?? null,
    ]);

    // Update owner name only
    if ($company->owner) {
        $company->owner->update([
            'name' => $validated['owner_name'],
        ]);
    }

    return redirect()
        ->route('company.index')
        ->with('success', 'Company updated successfully.');
}

public function updateMyCompany(CompanyUpdateRequest $request)
{
    $company = auth()->user()->company;

    if (! $company) {
        abort(404, 'No company found for this account.');
    }

    $validated = $request->validated();

    // Update company information
    $company->update([
        'name' => $validated['name'],
        'address' => $validated['address'],
        'industry' => $validated['industry'],
        'website' => $validated['website'] ?? null,
    ]);

    // Update owner information
    $company->owner->update([
        'name' => $validated['owner_name'],
    ]);

    // Update password only if a new one was provided
    if (! empty($validated['owner_password'])) {

        $company->owner->update([
            'password' => Hash::make($validated['owner_password']),
        ]);

    }

    return redirect()
        ->route('my-company.show')
        ->with('success', 'Company updated successfully.');
}

    /**
     * Archive the specified resource.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);

        $company->delete();

        return redirect()
            ->route('company.index')
            ->with('success', 'Company archived successfully.');
    }

    /**
     * Restore the specified resource from archive.
     */
  public function restore(string $id)
{
    $company = Company::onlyTrashed()->findOrFail($id);

    $company->restore();

    return redirect()
        ->route('company.index', ['archived' => true])
        ->with('success', 'Company restored successfully.');
}

}
