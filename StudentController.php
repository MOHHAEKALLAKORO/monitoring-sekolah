<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;

class StudentController extends Controller
{
    public function dashboard()
    {
        $totalStudents = Student::count();
        $today = date('Y-m-d');
        
        $todayAttendances = Attendance::where('date', $today)->get();
        $totalHadir = $todayAttendances->where('status', 'Hadir')->count();
        $totalIzin = $todayAttendances->where('status', 'Izin')->count();
        $totalSakit = $todayAttendances->where('status', 'Sakit')->count();
        $totalAlpha = $todayAttendances->where('status', 'Alpha')->count();

        return view('dashboard', compact('totalStudents', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpha', 'today'));
    }

    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:students,nisn',
            'name' => 'required',
            'class' => 'required',
            'parent_phone' => 'required',
        ]);

        Student::create($request->all());

        return redirect('/students')->with('success', 'Data siswa berhasil ditambahkan!');
    }
}