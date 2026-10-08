<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('student')->orderBy('tanggal', 'desc')->get();
        $students = Student::all();
        return view('attendances.index', compact('attendances', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Sakit,Izin,Alpa',
            'keterangan' => 'nullable|string',
        ]);

        Attendance::create($request->all());

        return redirect()->back()->with('success', 'Data presensi berhasil dicatat!');
    }

    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data presensi berhasil dihapus!');
    }
}