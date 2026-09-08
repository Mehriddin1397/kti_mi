<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\User;
use App\Support\Roles;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->hasRole(Roles::ADMIN)) {
            return view('dashboard.admin', [
                'totalProjects' => Project::count(),
                'activeProjects' => Project::where('status', 'jarayonda')->count(),
                'finishedProjects' => Project::where('status', 'yakunlangan')->count(),
                'totalUsers' => User::count(),
                'recentProjects' => Project::with(['user', 'applicationType'])
                    ->latest()
                    ->take(8)
                    ->get(),
            ]);
        }

        if ($user->hasRole(Roles::MASUL_XODIM)) {
            $tasksQuery = ProjectTask::with(['stage.project.user'])
                ->where('responsible_user_id', $user->id);

            $status = $request->query('status');

            if ($status) {
                $tasksQuery->where('status', $status);
            }

            return view('dashboard.staff', [
                'tasks' => $tasksQuery->latest()->paginate(15)->withQueryString(),
                'currentStatus' => $status,
                'counts' => [
                    'kutilmoqda' => ProjectTask::where('responsible_user_id', $user->id)->where('status', 'kutilmoqda')->count(),
                    'jarayonda' => ProjectTask::where('responsible_user_id', $user->id)->where('status', 'jarayonda')->count(),
                    'qaytarildi' => ProjectTask::where('responsible_user_id', $user->id)->where('status', 'qaytarildi')->count(),
                    'tasdiqlandi' => ProjectTask::where('responsible_user_id', $user->id)->where('status', 'tasdiqlandi')->count(),
                ],
            ]);
        }

        return view('dashboard.applicant', [
            'projects' => Project::with('applicationType')
                ->where('user_id', $user->id)
                ->latest()
                ->get(),
        ]);
    }
}
