<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $pesertas = Peserta::unregistered()
            ->with(['instansi', 'pengajuan'])
            ->orderBy('nama', 'asc')
            ->get();

        return view('auth.register', compact('pesertas'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'peserta_id' => ['required', 'exists:pesertas,id'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'peserta_id.required' => 'Pilih data peserta magang Anda.',
            'peserta_id.exists'   => 'Data peserta tidak valid.',
            'email.required'      => 'Email wajib diisi.',
            'email.unique'        => 'Email ini sudah terdaftar.',
            'password.required'   => 'Password wajib diisi.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
        ]);

        $peserta = Peserta::findOrFail($request->peserta_id);

        if (! is_null($peserta->user_id)) {
            return back()->withErrors(['peserta_id' => 'Data peserta ini sudah memiliki akun. Silakan login.'])->withInput();
        }

        DB::transaction(function () use ($request, $peserta) {
            $user = User::create([
                'name'     => $peserta->nama,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => User::ROLE_PESERTA,
            ]);

            $peserta->update([
                'user_id' => $user->id,
            ]);

            event(new Registered($user));

            Auth::login($user);
        });

        return redirect()->route('dashboard');
    }
}
