<?php

namespace App\Http\Controllers;

use App\Models\TrafficReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrafficReportController extends Controller
{
    /**
     * READ: Menampilkan daftar pemantauan kemacetan lalu lintas (SmartTraffic Finder)
     */
    public function index()
    {
        $reports = TrafficReport::with('user')->latest()->paginate(5);
        return view('traffic.index', compact('reports'));
    }

    /**
     * CREATE: Menampilkan formulir input pelaporan arus lalu lintas baru
     */
    public function create()
    {
        return view('traffic.create');
    }

    /**
     * STORE: Memvalidasi dan menyimpan data laporan lalu lintas beserta unggahan foto bukti kondisi jalan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor'      => 'required|string|max:255',
            'lokasi_jalan'      => 'required|string|max:255',
            'tingkat_kepadatan' => 'required|integer|min:0|max:100',
            'status'            => 'required|in:Menunggu,Diproses,Selesai',
            'keterangan'        => 'nullable|string',
            'foto_bukti'        => 'required|image|mimes:jpg,jpeg,png|max:2048', // Maksimal 2 MB
        ]);

        $path = $request->file('foto_bukti')->store('foto_traffic', 'public');

        $validated['user_id'] = Auth::id();
        $validated['foto_bukti'] = $path;

        TrafficReport::create($validated);

        return redirect()->route('traffic-reports.index')
            ->with('success', 'Laporan arus lalu lintas berhasil ditambahkan beserta bukti visual.');
    }

    /**
     * READ: Menampilkan detail pantauan lalu lintas beserta pratinjau foto resolusi penuh
     */
    public function show(TrafficReport $trafficReport)
    {
        return view('traffic.show', compact('trafficReport'));
    }

    /**
     * UPDATE: Menampilkan form pengubahan data laporan dan penggantian foto bukti
     */
    public function edit(TrafficReport $trafficReport)
    {
        return view('traffic.edit', compact('trafficReport'));
    }

    /**
     * UPDATE: Memperbarui data laporan serta menghapus foto lama jika pengguna mengunggah foto baru
     */
    public function update(Request $request, TrafficReport $trafficReport)
    {
        $validated = $request->validate([
            'nama_pelapor'      => 'required|string|max:255',
            'lokasi_jalan'      => 'required|string|max:255',
            'tingkat_kepadatan' => 'required|integer|min:0|max:100',
            'status'            => 'required|in:Menunggu,Diproses,Selesai',
            'keterangan'        => 'nullable|string',
            'foto_bukti'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_bukti')) {
            // Hapus file fisik lama di storage disk public
            if ($trafficReport->foto_bukti) {
                Storage::disk('public')->delete($trafficReport->foto_bukti);
            }
            $validated['foto_bukti'] = $request->file('foto_bukti')->store('foto_traffic', 'public');
        }

        $trafficReport->update($validated);

        return redirect()->route('traffic-reports.index')
            ->with('success', 'Data laporan lalu lintas berhasil diperbarui.');
    }

    /**
     * DELETE: Menghapus file fisik di storage dan rekaman data di basis data
     */
    public function destroy(TrafficReport $trafficReport)
    {
        if ($trafficReport->foto_bukti) {
            Storage::disk('public')->delete($trafficReport->foto_bukti);
        }

        $trafficReport->delete();

        return redirect()->route('traffic-reports.index')
            ->with('success', 'Laporan lalu lintas beserta foto bukti berhasil dihapus dari sistem.');
    }
}
