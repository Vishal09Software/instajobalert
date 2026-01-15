<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobType;
use App\Http\Requests\JobType\StoreJobTypeRequest;
use App\Http\Requests\JobType\UpdateJobTypeRequest;

class JobTypeController extends Controller
{
    public function index()
    {
        return view('admin.job-type.index');
    }

    public function create()
    {
        return view('admin.job-type.create');
    }

    public function store(StoreJobTypeRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        JobType::create($data);
        return redirect()->route('job-types.index')->with('success', 'Job type created successfully');
    }

    public function edit(JobType $jobType)
    {
        return view('admin.job-type.edit', compact('jobType'));
    }

    public function update(UpdateJobTypeRequest $request, JobType $jobType)
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        $jobType->update($data);
        return redirect()->route('job-types.index')->with('success', 'Job type updated successfully');
    }
}

