<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationType;
use App\Models\Project;
use App\Models\User;
use App\Support\Roles;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::with(['user', 'applicationType'])
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->when($request->query('application_type_id'), fn ($q, $id) => $q->where('application_type_id', $id))
            ->when($request->query('responsible_user_id'), function ($q, $responsibleId) {
                $q->whereHas('stages.tasks', fn ($tq) => $tq->where('responsible_user_id', $responsibleId));
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.projects.index', [
            'projects' => $projects,
            'applicationTypes' => ApplicationType::orderBy('name')->get(),
            'staff' => User::role(Roles::MASUL_XODIM)->orderBy('full_name')->get(),
            'filters' => $request->only(['status', 'application_type_id', 'responsible_user_id']),
        ]);
    }
}
