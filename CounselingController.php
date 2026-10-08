<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counseling;
use App\Models\Student;

class CounselingController extends Controller
{
    public function index()
    {
        $counselings = Counseling::with('student')->orderBy('tanggal', 'desc')->get();
        $students = Student::all();
        return view('counselings.index', compact('counselings', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Prestasi,Pelanggaran,Konseling',
            'deskripsi' => 'required|string',
            'poin' => 'required|integer',
            'tindak_lanjut' => 'nullable|string',
        ]);

        Counseling::create($request->all());

        return redirect()->back()->with('success', 'Catatan Buku BK berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Counseling::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Catatan Buku BK berhasil dihapus!');
    }
}