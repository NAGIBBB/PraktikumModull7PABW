<?php

namespace Database\Seeders;

use App\Models\Upload;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleUploadSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            return;
        }

        $sampleFiles = [
            ['judul' => 'Laporan Praktikum', 'keterangan' => 'Laporan dalam format PDF.', 'filename' => 'laporan_praktikum.pdf', 'ext' => 'pdf'],
            ['judul' => 'Poster Seminar', 'keterangan' => 'Poster kegiatan seminar.', 'filename' => 'poster_seminar.png', 'ext' => 'png'],
            ['judul' => 'Jadwal Kuliah', 'keterangan' => null, 'filename' => 'jadwal_kuliah.pdf', 'ext' => 'pdf'],
            ['judul' => 'Dokumentasi 1', 'keterangan' => null, 'filename' => 'dokumentasi_1.jpg', 'ext' => 'jpg'],
            ['judul' => 'Dokumentasi 2', 'keterangan' => null, 'filename' => 'dokumentasi_2.jpg', 'ext' => 'jpg'],
        ];

        $existingImg = storage_path('app/public/uploads/s4d6h4pyQrMhJk30cNbJpNITTyYFNMMFuNKKw9gZ.png');
        $imgBytes = file_exists($existingImg) ? file_get_contents($existingImg) : base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');

        foreach ($sampleFiles as $s) {
            $hash = Str::random(40) . '.' . $s['ext'];
            $filepath = 'uploads/' . $hash;
            $fullPath = storage_path('app/public/' . $filepath);
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }
            if ($s['ext'] === 'pdf') {
                file_put_contents($fullPath, "%PDF-1.4\n1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] >>\nendobj\nxref\n0 4\n0000000000 65535 f \n0000000010 00000 n \n0000000060 00000 n \n0000000117 00000 n \ntrailer\n<< /Size 4 /Root 1 0 R >>\nstartxref\n193\n%%EOF");
            } else {
                file_put_contents($fullPath, $imgBytes);
            }

            Upload::create([
                'user_id' => $user->id,
                'judul' => $s['judul'],
                'keterangan' => $s['keterangan'],
                'filename' => $s['filename'],
                'filepath' => $filepath,
            ]);
        }
    }
}
