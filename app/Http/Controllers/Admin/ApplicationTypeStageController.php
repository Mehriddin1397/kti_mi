<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationType;
use App\Models\ApplicationTypeStage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApplicationTypeStageController extends Controller
{
    public function store(Request $request, ApplicationType $applicationType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $nextOrder = $applicationType->stages()->max('order') + 1;

        $applicationType->stages()->create([
            'name' => $validated['name'],
            'order' => $nextOrder,
        ]);

        return back()->with('status', "Bosqich qo'shildi.");
    }

    public function update(Request $request, ApplicationType $applicationType, ApplicationTypeStage $stage): RedirectResponse
    {
        abort_unless($stage->application_type_id === $applicationType->id, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:0'],
        ]);

        $stage->update($validated);

        return back()->with('status', 'Bosqich yangilandi.');
    }

    public function destroy(ApplicationType $applicationType, ApplicationTypeStage $stage): RedirectResponse
    {
        abort_unless($stage->application_type_id === $applicationType->id, 404);

        $stage->delete();

        return back()->with('status', "Bosqich o'chirildi.");
    }
}
