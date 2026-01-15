<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Http\Requests\Skill\StoreSkillRequest;
use App\Http\Requests\Skill\UpdateSkillRequest;

class SkillController extends Controller
{
    public function index()
    {
        return view('admin.skill.index');
    }

    public function create()
    {
        return view('admin.skill.create');
    }

    public function store(StoreSkillRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        Skill::create($data);
        return redirect()->route('skills.index')->with('success', 'Skill created successfully');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skill.edit', compact('skill'));
    }

    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        $skill->update($data);
        return redirect()->route('skills.index')->with('success', 'Skill updated successfully');
    }
}

