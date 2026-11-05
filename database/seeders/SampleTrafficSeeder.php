<?php

namespace Database\Seeders;

use App\Models\TrafficReport;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleTrafficSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            return;
        }

        $reports = [
            [
                'nama_pelapor' => 'Muhammad Nagib',
                'lokasi_jalan' => 'Jl. Telekomunikasi Terusan Buah Batu',
                'tingkat_kepadatan' => 85,
                'status' => 'Diproses',
                'keterangan' => 'Kepadatan arus kendaraan roda dua dan empat di gerbang masuk utama Telkom University menjelang jam kuliah pagi.',
            ],
            [
                'nama_pelapor' => 'Bripka Haryanto (Dishub)',
                'lokasi_jalan' => 'Simpang Lima Garut - Bandung',
                'tingkat_kepadatan' => 90,
                'status' => 'Diproses',
                'keterangan' => 'Antrean kendaraan mengular sepanjang 1.2 KM akibat perbaikan median jalan dan peningkatan volume bus antar kota.',
            ],
            [
                'nama_pelapor' => 'Siti Nurhaliza',
                'lokasi_jalan' => 'Jl. Soekarno-Hatta (Depan MIM / MTC)',
                'tingkat_kepadatan' => 65,
                'status' => 'Menunggu',
                'keterangan' => 'Arus lalu lintas padat merayap di lajur cepat arah barat akibat penyempitan jalan.',
            ],
            [
                'nama_pelapor' => 'Ahmad Fauzi',
                'lokasi_jalan' => 'Jl. Dr. Djunjunan (Pintu Tol Pasteur)',
                'tingkat_kepadatan' => 75,
                'status' => 'Diproses',
                'keterangan' => 'Lonjakan kendaraan masuk ke arah kota Bandung di akhir pekan, kecepatan rata-rata 10 km/jam.',
            ],
            [
                'nama_pelapor' => 'Dewi Safitri',
                'lokasi_jalan' => 'Jl. Ir. H. Djuanda (Dago Bawah)',
                'tingkat_kepadatan' => 30,
                'status' => 'Selesai',
                'keterangan' => 'Arus lalu lintas lancar terkendali dua arah, cuaca cerah tanpa hambatan.',
            ],
            [
                'nama_pelapor' => 'Rizky Pratama',
                'lokasi_jalan' => 'Jl. R.E. Martadinata (Riau Heritage)',
                'tingkat_kepadatan' => 25,
                'status' => 'Selesai',
                'keterangan' => 'Kondisi jalan ramai lancar, petugas telah mengurai parkir liar di bahu jalan.',
            ],
        ];

        $existingImg = storage_path('app/public/uploads/s4d6h4pyQrMhJk30cNbJpNITTyYFNMMFuNKKw9gZ.png');
        $imgBytes = file_exists($existingImg) ? file_get_contents($existingImg) : base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');

        $dir = storage_path('app/public/foto_traffic');
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        foreach ($reports as $r) {
            $hash = Str::random(40) . '.png';
            $filepath = 'foto_traffic/' . $hash;
            file_put_contents(storage_path('app/public/' . $filepath), $imgBytes);

            TrafficReport::create([
                'user_id' => $user->id,
                'nama_pelapor' => $r['nama_pelapor'],
                'lokasi_jalan' => $r['lokasi_jalan'],
                'tingkat_kepadatan' => $r['tingkat_kepadatan'],
                'status' => $r['status'],
                'keterangan' => $r['keterangan'],
                'foto_bukti' => $filepath,
            ]);
        }
    }
}
