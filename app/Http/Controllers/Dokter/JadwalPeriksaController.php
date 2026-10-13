<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        $jadwal = JadwalPeriksa::where('id_dokter', Auth::id())->get();
        return view('dokter.jadwalperiksa.index', compact('jadwal'));
    }

    public function create()
    {
        return view('dokter.jadwalperiksa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari'        => 'required|string|max:10',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        JadwalPeriksa::create([
            'id_dokter'   => Auth::id(),
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('jadwalperiksa.index')
            ->with('message', 'Jadwal periksa berhasil ditambahkan')
            ->with('type', 'success');
    }

    public function edit(JadwalPeriksa $jadwalPeriksa)
    {
        return view('dokter.jadwalperiksa.edit', compact('jadwalPeriksa'));
    }

    public function update(Request $request, JadwalPeriksa $jadwalPeriksa)
    {
        $request->validate([
            'hari'        => 'required|string|max:10',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwalPeriksa->update([
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('jadwalperiksa.index')
            ->with('message', 'Jadwal periksa berhasil diperbarui')
            ->with('type', 'success');
    }

    public function destroy(JadwalPeriksa $jadwalPeriksa)
    {
        $jadwalPeriksa->delete();

        return redirect()->route('jadwalperiksa.index')
            ->with('message', 'Jadwal periksa berhasil dihapus')
            ->with('type', 'success');
    }
}