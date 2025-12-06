<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
public function edit()
{
    $user = auth::user();

    // Ambil data siswa yang user_id = auth()->id()
    $siswa = Siswa::where('user_id', $user->id)->first();

    return view('profile.edit', compact(
        'user' ,
        'siswa' ));
}

    public function updateAkun(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6',
        ]);

        $user = Auth::user();
        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }

    /**
     * Update Biodata Siswa
     */
    public function updateSiswa(Request $request)
    {
        $request->validate([
            'telp' => 'required|string',
            'telp_orangtua' => 'required|string',
            'alamat' => 'nullable|string',
        ]);

        $siswa = Siswa::where('user_id', Auth::id())->firstOrFail();

        $siswa->update([
            'telp' => $request->telp,
            'telp_orangtua' => $request->telp_orangtua,
            'alamat' => $request->alamat,
        ]);

        return back()->with('status', 'siswa-updated');
    }


}
