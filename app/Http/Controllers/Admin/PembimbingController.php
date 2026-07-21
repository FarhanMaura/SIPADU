<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PembimbingRequest;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PembimbingController extends Controller
{
    public function index(): View
    {
        $pembimbings = Pembimbing::with('bidang')->paginate(15);

        return view('admin.pembimbing.index', compact('pembimbings'));
    }

    public function create(): View
    {
        $bidangs = Bidang::all();

        return view('admin.pembimbing.create', compact('bidangs'));
    }

    public function store(PembimbingRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->nama,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => User::ROLE_PEMBIMBING,
            ]);

            Pembimbing::create([
                'user_id'   => $user->id,
                'bidang_id' => $request->bidang_id,
                'nip'       => $request->nip,
                'nama'      => $request->nama,
                'no_hp'     => $request->no_hp,
            ]);
        });

        return redirect()->route('admin.pembimbing.index')
            ->with('success', 'Pembimbing berhasil ditambahkan.');
    }

    public function edit(Pembimbing $pembimbing): View
    {
        $bidangs = Bidang::all();

        return view('admin.pembimbing.edit', compact('pembimbing', 'bidangs'));
    }

    public function update(PembimbingRequest $request, Pembimbing $pembimbing): RedirectResponse
    {
        DB::transaction(function () use ($request, $pembimbing) {
            $pembimbing->update([
                'bidang_id' => $request->bidang_id,
                'nip'       => $request->nip,
                'nama'      => $request->nama,
                'no_hp'     => $request->no_hp,
            ]);

            if ($pembimbing->user) {
                $userData = ['name' => $request->nama, 'email' => $request->email];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                $pembimbing->user->update($userData);
            }
        });

        return redirect()->route('admin.pembimbing.index')
            ->with('success', 'Pembimbing berhasil diperbarui.');
    }

    public function destroy(Pembimbing $pembimbing): RedirectResponse
    {
        if ($pembimbing->pesertas()->count() > 0) {
            return redirect()->route('admin.pembimbing.index')
                ->with('error', 'Pembimbing tidak dapat dihapus karena masih memiliki peserta bimbingan.');
        }

        DB::transaction(function () use ($pembimbing) {
            $user = $pembimbing->user;
            $pembimbing->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.pembimbing.index')
            ->with('success', 'Pembimbing berhasil dihapus.');
    }
}
