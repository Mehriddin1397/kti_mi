<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\SmsServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Roles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::with('roles')
            ->when($request->query('role'), fn ($q, $role) => $q->role($role))
            ->orderBy('full_name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => Roles::labels(),
            'currentRole' => $request->query('role'),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', ['roles' => Roles::labels()]);
    }

    public function store(Request $request, SmsServiceInterface $sms): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:32', 'unique:users,phone'],
            'role' => ['required', Rule::in(Roles::all())],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $password = $validated['password'] ?? Str::password(10);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'password' => Hash::make($password),
            'initial_password' => $password,
            'is_active' => true,
        ]);

        $user->assignRole($validated['role']);

        $message = "Hurmatli mustaqil izlanuvchi! Siz uchun platformada shaxsiy kabinet yaratildi.Login: {$user->phone} Parol: {$password} Platforma:https://ilm.uzkti.uz Iltimos, login va parolingizni begona shaxslarga bermang.";
        $sms->send($user->phone, $message, $user);

        return redirect()->route('admin.users.index')
            ->with('status', "Foydalanuvchi yaratildi. Vaqtinchalik parol: {$password}");
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Roles::labels(),
            'currentRole' => $user->roles->first()?->name,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:32', Rule::unique('users', 'phone')->ignore($user->id)],
            'role' => ['required', Rule::in(Roles::all())],
            'password' => ['nullable', 'string', 'min:6'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $user->full_name = $validated['full_name'];
        $user->phone = $validated['phone'];
        $user->is_active = $request->boolean('is_active', true);

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
            $user->initial_password = $validated['password'];
        }

        $user->save();
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('status', "Foydalanuvchi ma'lumotlari yangilandi.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', "O'zingizni o'chira olmaysiz.");
        }

        $user->update(['is_active' => false]);

        return back()->with('status', "Foydalanuvchi nofaollashtirildi.");
    }
}
