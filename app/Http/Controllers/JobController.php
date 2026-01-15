<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Occupation;
use App\Models\JobCategory;
use App\Http\Requests\Job\StoreJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;

class JobController extends Controller
{
    public function index()
    {
        return view('admin.job.index');
    }

    public function create()
    {
        $categories = JobCategory::where('status', true)->orderBy('title')->get();
        return view('admin.job.create', compact('categories'));
    }

    public function store(StoreJobRequest $request)
    {
        $data = $request->validated();

        // Handle date fields
        if ($request->has('posted_at') && $request->posted_at) {
            $data['posted_at'] = \Carbon\Carbon::parse($request->posted_at);
        }
        if ($request->has('expires_at') && $request->expires_at) {
            $data['expires_at'] = \Carbon\Carbon::parse($request->expires_at);
        }

        Occupation::create($data);
        return redirect()->route('jobs.index')->with('success', 'Job created successfully');
    }

    public function edit(Occupation $job)
    {
        $categories = JobCategory::where('status', true)->orderBy('title')->get();
        return view('admin.job.edit', compact('job', 'categories'));
    }

    public function update(UpdateJobRequest $request, Occupation $job)
    {
        $data = $request->validated();

        // Handle date fields
        if ($request->has('posted_at') && $request->posted_at) {
            $data['posted_at'] = \Carbon\Carbon::parse($request->posted_at);
        } else {
            $data['posted_at'] = null;
        }
        if ($request->has('expires_at') && $request->expires_at) {
            $data['expires_at'] = \Carbon\Carbon::parse($request->expires_at);
        } else {
            $data['expires_at'] = null;
        }

        $job->update($data);
        return redirect()->route('jobs.index')->with('success', 'Job updated successfully');
    }
}

