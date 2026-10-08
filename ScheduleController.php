<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Subject;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('subject')->orderBy('jam_mulai')->get();
        $subjects = Subject::all();
        return view('schedules.index', compact('schedules', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'subject_id' => 'required',
            'kelas' => 'required|string|max:50',
            'ruangan' => 'nullable|string|max:50',
        ]);

        Schedule::create($request->all());

        return redirect()->back()->with('success', 'Jadwal pelajaran berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jadwal pelajaran berhasil dihapus!');
    }
}