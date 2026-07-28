<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryUpdateRequest;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobCategory::query();

        // Show archived categories only
        if ($request->boolean('archived')) {
            $query->onlyTrashed();
        } else {
            $query->latest();
        }

        $categories = $query
            ->paginate(10)
            ->onEachSide(1);

        return view('job-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        JobCategory::create($request->validated());

        return redirect()
            ->route('category.index')
            ->with('success', 'Job category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = JobCategory::findOrFail($id);

        return view('job-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        $category = JobCategory::findOrFail($id);

        $category->update($request->validated());

        return redirect()
            ->route('category.index')
            ->with('success', 'Job category updated successfully.');
    }

    /**
     * Archive the specified resource.
     */
    public function destroy(string $id)
    {
        $category = JobCategory::findOrFail($id);

        $category->delete();

        return redirect()
            ->back()
            ->with('success', 'Job category archived successfully.');
    }

    /**
     * Restore the specified resource from archive.
     */
  public function restore(string $id)
{
    $category = JobCategory::onlyTrashed()->findOrFail($id);

    $category->restore();

    return redirect()
        ->route('category.index', ['archived' => true])
        ->with('success', 'Job category restored successfully.');
}

}
