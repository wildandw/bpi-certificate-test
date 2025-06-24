<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function daftardata(Request $request)
    {
        $search = $request->input('search');

        $regis = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->get();

        return view('register-daftar', compact('regis', 'search'));
        
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin', 
        ]);

        return redirect(route('register.daftardata'))->with('success', 'Guru berhasil terdaftar.');
    }

    public function destroyteacher($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Guru berhasil terhapus.');
    }

    // fungsi untuk hapus semua data di toefl iBT
    public function destroyallteacher()
    {
        User::truncate();
        return redirect()->back()->with('success', 'Semua data Guru berhasil terhapus.');
    }

public function updateteacher(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|max:255',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    if ($validator->fails()) {
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }

    $teacher = User::findOrFail($id);
    $teacher->name = $request->name;
    $teacher->email = $request->email;
    $teacher->password = Hash::make($request->password); // Penting!

    $teacher->save();

    return back()->with('success', 'Data Guru berhasil diperbarui.');
}

}
