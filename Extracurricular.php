<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $fillable = [
        'student_id',
        'nama_ekskul',
        'jabatan',
        'tahun_ajaran',
        'keterangan'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}