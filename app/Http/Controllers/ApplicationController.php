<?php

namespace App\Http\Controllers;

use App\Contracts\SmsServiceInterface;
use App\Models\ApplicationType;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function create(): View
    {
        $applicationTypes = ApplicationType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('applications.create', compact('applicationTypes'));
    }

    public function store(Request $request, ApplicationType $applicationType, SmsServiceInterface $sms): RedirectResponse
    {
        abort_unless($applicationType->is_active, 404);

        $user = $request->user();

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:32'],
        ]);

        $project = DB::transaction(function () use ($applicationType, $user, $validated) {
            $project = Project::create([
                'application_type_id' => $applicationType->id,
                'user_id' => $user->id,
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'status' => 'jarayonda',
                'progress_percent' => 0,
            ]);

            foreach ($applicationType->stages()->with('tasks')->get() as $stageTemplate) {
                $stage = $project->stages()->create([
                    'name' => $stageTemplate->name,
                    'order' => $stageTemplate->order,
                    'status' => 'kutilmoqda',
                ]);

                foreach ($stageTemplate->tasks as $taskTemplate) {
                    $stage->tasks()->create([
                        'name' => $taskTemplate->name,
                        'description' => $taskTemplate->description,
                        'responsible_user_id' => $taskTemplate->default_responsible_user_id,
                        'status' => 'kutilmoqda',
                        'order' => $taskTemplate->order,
                    ]);
                }
            }

            return $project;
        });

        $sms->send($user->phone, "Arizangiz qabul qilindi: \"{$applicationType->name}\". Loyiha holatini tizimda kuzatib boring.", $user);

        return redirect()->route('projects.show', $project)
            ->with('status', "Arizangiz muvaffaqiyatli yuborildi.");
    }
}
