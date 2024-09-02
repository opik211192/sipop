<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Models\JabatanDetail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['jabatan', 'jabatanDetail'])->get();
        return view('users.index', compact('users'));   
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        return view('users.create', compact('jabatans'));
    }

    public function getJabatanDetails($jabatan_id)
    {
        $details = JabatanDetail::where('jabatan_id', $jabatan_id)->get();
        return response()->json($details);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'jabatan_id' => 'nullable',
            'jabatan_detail_id' => 'nullable',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'jabatan_id' => $request->jabatan_id,
            'jabatan_detail_id' => $request->jabatan_detail_id
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $jabatans = Jabatan::all();
        $jabatanDetails = JabatanDetail::where('jabatan_id', $user->jabatan_id)->get();
        return view('users.edit', compact('user', 'jabatans', 'jabatanDetails'));
    }

   public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'jabatan_id' => 'nullable',
            'jabatan_detail_id' => 'nullable',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->jabatan_id = $request->jabatan_id;
        $user->jabatan_detail_id = $request->jabatan_detail_id;

        // Hanya memperbarui password jika diisi
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
