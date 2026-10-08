<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Counseling;

class ReportCardController extends Controller
{
  public function index(Request $request)
{
    $semester = $request->input('semester', 'Ganjil');
    $tahun_ajaran = $request->input('tahun_ajaran', '2025/2026');
    $selectedClass = $request->input('class'); // Menangkap kelas yang dipilih dari dropdown

    // Ambil daftar kelas unik untuk dropdown
    $classes = Student::select('class')->distinct()->whereNotNull('class')->get();

    // Query data siswa/nilai dengan filter kelas jika dipilih
    $query = Student::query(); // Sesuaikan dengan model utama yang menampilkan data di tabel (bisa Student atau Grade/ReportCard)

    if ($selectedClass) {
        $query->where('class', $selectedClass);
    }

    $students = $query->get(); // Atau $grades = $query->paginate(10); tergantung variabel yang Anda gunakan di view

   return view('report-cards.index', compact('classes', 'semester', 'tahun_ajaran', 'students', 'selectedClass'));
}
    public function show($id, Request $request)
    {
        $student = Student::findOrFail($id);
        $semester = $request->input('semester', 'Ganjil');
        
        // Rekap presensi siswa tertentu
        $attendances = Attendance::where('student_id', $id)->get();
        $totalHadir = $attendances->where('status', 'Hadir')->count();
        $totalSakit = $attendances->where('status', 'Sakit')->count();
        $totalIzin = $attendances->where('status', 'Izin')->count();
        $totalAlpa = $attendances->where('status', 'Alpa')->count();

        // Rekap catatan BK
        $counselings = Counseling::where('student_id', $id)->get();

        return view('report-cards.show', compact('student', 'semester', 'totalHadir', 'totalSakit', 'totalIzin', 'totalAlpa', 'counselings'));
    }
}