<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationTypeStage;
use App\Models\ApplicationTypeTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApplicationTypeTaskController extends Controller
{
    public function store(Request $request, ApplicationTypeStage $stage): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'default_responsible_user_id' => ['nullable', 'exists:users,id'],
        ]);

        $nextOrder = $stage->tasks()->max('order') + 1;

        $stage->tasks()->create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'default_responsible_user_id' => $validated['default_responsible_user_id'] ?? null,
            'order' => $nextOrder,
        ]);

        return back()->with('status', "Vazifa qo'shildi.");
    }

    public function update(Request $request, ApplicationTypeTask $task): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'default_responsible_user_id' => ['nullable', 'exists:users,id'],
            'order' => ['required', 'integer', 'min:0'],
        ]);

        $task->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'default_responsible_user_id' => $validated['default_responsible_user_id'] ?? null,
            'order' => $validated['order'],
        ]);

        return back()->with('status', 'Vazifa yangilandi.');
    }

    public function destroy(ApplicationTypeTask $task): RedirectResponse
    {
        $task->delete();

        return back()->with('status', "Vazifa o'chirildi.");
    }
}
