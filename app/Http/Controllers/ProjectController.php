<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::with('applicationType')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function show(Request $request, Project $project): View
    {
        $this->authorize('view', $project);

        $project->load([
            'applicationType',
            'user',
            'stages.tasks.responsibleUser',
            'stages.tasks.latestDocument',
        ]);

        return view('projects.show', compact('project'));
    }
}
