<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Counseling;
use App\Models\Student;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter bulan & tahun dari request, default ke bulan dan tahun saat ini
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Ambil data presensi pada bulan & tahun tersebut
        $attendances = Attendance::with('student')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        // Ambil data catatan BK pada bulan & tahun tersebut
        $counselings = Counseling::with('student')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $students = Student::all();

        return view('reports.index', compact('attendances', 'counselings', 'students', 'bulan', 'tahun'));
    }
}