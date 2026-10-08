<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\AcademicYear;

class AcademicSettingController extends Controller
{
    // Menampilkan halaman pengaturan (Mapel & Tahun Ajaran)
    public function index()
    {
        $subjects = Subject::all();
        $academicYears = AcademicYear::all();
        return view('academic.settings', compact('subjects', 'academicYears'));
    }

    // Simpan Mata Pelajaran Baru
    public function storeSubject(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:subjects,kode_mapel',
            'nama_mapel' => 'required|string|max:255',
        ]);

        Subject::create([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
        ]);

        return redirect()->back()->with('success_subject', 'Mata pelajaran berhasil ditambahkan!');
    }

    // Simpan Tahun Ajaran Baru
    public function storeAcademicYear(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:50',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        // Jika diset aktif, nonaktifkan yang lain (opsional)
        if ($request->has('is_active')) {
            AcademicYear::where('is_active', true)->update(['is_active' => false]);
        }

        AcademicYear::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->back()->with('success_year', 'Tahun ajaran berhasil ditambahkan!');
    }

    // Hapus Mata Pelajaran
    public function destroySubject($id)
    {
        Subject::findOrFail($id)->delete();
        return redirect()->back()->with('success_subject', 'Mata pelajaran berhasil dihapus!');
    }

    // Hapus Tahun Ajaran
    public function destroyAcademicYear($id)
    {
        AcademicYear::findOrFail($id)->delete();
        return redirect()->back()->with('success_year', 'Tahun ajaran berhasil dihapus!');
    }
}