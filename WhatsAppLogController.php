<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsAppLogController extends Controller
{
    public function index(Request $request)
    {
        // Contoh data dummy log WhatsApp (bisa diganti dengan model/database nanti)
        $logs = [
            [
                'id' => 1,
                'recipient_name' => 'Budi Santoso (Wali Murid)',
                'phone' => '+62 812-3456-7890',
                'message' => 'Halo Bapak/Ibu, Ananda Budi hadir di sekolah pada pukul 07:15 WITA.',
                'status' => 'Berhasil',
                'type' => 'Presensi Masuk',
                'time' => '2026-10-05 07:15:20'
            ],
            [
                'id' => 2,
                'recipient_name' => 'Siti Aminah (Wali Murid)',
                'phone' => '+62 898-7654-3210',
                'message' => 'Pengumuman: Libur nasional memperingati hari besar akan dimulai pada hari Rabu.',
                'status' => 'Berhasil',
                'type' => 'Pengumuman Sekolah',
                'time' => '2026-10-04 10:30:00'
            ],
            [
                'id' => 3,
                'recipient_name' => 'Ahmad Fauzi (Wali Murid)',
                'phone' => '+62 856-1122-3344',
                'message' => 'Pemberitahuan SPP bulan Oktober 2026 telah diterbitkan.',
                'status' => 'Gagal',
                'type' => 'Tagihan Keuangan',
                'time' => '2026-10-03 14:00:12'
            ],
        ];

        return view('admin.whatsapp-logs.index', compact('logs'));
    }
}