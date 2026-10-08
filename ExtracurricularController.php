<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extracurricular;
use App\Models\Student;

class ExtracurricularController extends Controller
{
    public function index()
    {
        $extracurriculars = Extracurricular::with('student')->latest()->get();
        $students = Student::all();
        return view('extracurriculars.index', compact('extracurriculars', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'nama_ekskul' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'tahun_ajaran' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        Extracurricular::create($request->all());

        return redirect()->back()->with('success', 'Data ekstrakurikuler berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Extracurricular::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data ekstrakurikuler berhasil dihapus!');
    }
}