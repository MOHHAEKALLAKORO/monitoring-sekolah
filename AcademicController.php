<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Student;

class AcademicController extends Controller
{
    public function index()
    {
        // Mengambil data nilai, relasi ke siswa, mapel, dan tahun ajaran
        $grades = Grade::with(['student', 'subject', 'academicYear'])->get();
        $subjects = Subject::all();
        $academicYears = AcademicYear::all();
        $students = Student::all();

        return view('academic.index', compact('grades', 'subjects', 'academicYears', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'subject_id' => 'required',
            'academic_year_id' => 'required',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
        ]);

        // Kalkulasi Nilai Akhir (Contoh: Tugas 30%, UTS 30%, UAS 40%)
        $nilaiAkhir = ($request->nilai_tugas * 0.3) + ($request->nilai_uts * 0.3) + ($request->nilai_uas * 0.4);

        // Tentukan Predikat
        $predikat = 'C';
        if ($nilaiAkhir >= 85) {
            $predikat = 'A';
        } elseif ($nilaiAkhir >= 75) {
            $predikat = 'B';
        }

        Grade::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'academic_year_id' => $request->academic_year_id,
            'nilai_tugas' => $request->nilai_tugas,
            'nilai_uts' => $request->nilai_uts,
            'nilai_uas' => $request->nilai_uas,
            'nilai_akhir' => $nilaiAkhir,
            'predikat' => $predikat,
        ]);

        return redirect()->back()->with('success', 'Data nilai berhasil ditambahkan!');
    }
}