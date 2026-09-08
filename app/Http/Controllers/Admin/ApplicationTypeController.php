<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationTypeController extends Controller
{
    public function index(): View
    {
        $applicationTypes = ApplicationType::withCount('stages', 'projects')->latest()->get();

        return view('admin.application-types.index', compact('applicationTypes'));
    }

    public function create(): View
    {
        return view('admin.application-types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $applicationType = ApplicationType::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.application-types.show', $applicationType)
            ->with('status', "Ariza turi yaratildi. Endi bosqichlarni qo'shing.");
    }

    public function show(ApplicationType $applicationType): View
    {
        $applicationType->load('stages.tasks.defaultResponsibleUser');

        $staff = \App\Models\User::role(\App\Support\Roles::MASUL_XODIM)->orderBy('full_name')->get();

        return view('admin.application-types.show', compact('applicationType', 'staff'));
    }

    public function edit(ApplicationType $applicationType): View
    {
        return view('admin.application-types.edit', compact('applicationType'));
    }

    public function update(Request $request, ApplicationType $applicationType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $applicationType->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.application-types.index')->with('status', 'Ariza turi yangilandi.');
    }

    public function destroy(ApplicationType $applicationType): RedirectResponse
    {
        if ($applicationType->projects()->exists()) {
            return back()->with('error', "Bu ariza turi bo'yicha loyihalar mavjud, shuning uchun o'chirib bo'lmaydi. Uni nofaol qilishingiz mumkin.");
        }

        $applicationType->delete();

        return redirect()->route('admin.application-types.index')->with('status', "Ariza turi o'chirildi.");
    }
}
