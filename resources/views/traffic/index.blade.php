<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SmartTraffic Finder - Pemantauan Lalu Lintas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <p class="text-gray-600 text-sm">
                        Modul Tugas Akhir: Kelola pelaporan kemacetan arus lalu lintas cerdas perkotaan secara real-time.
                    </p>
                    <a href="{{ route('traffic-reports.create') }}"
                       class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 font-medium text-sm">
                        + Tambah Laporan Kemacetan
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border text-left text-sm">
                        <thead class="bg-gray-100 uppercase text-xs text-gray-700">
                            <tr>
                                <th class="border p-2 text-center w-12">No</th>
                                <th class="border p-2 text-center w-24">Foto Bukti</th>
                                <th class="border p-2">Lokasi Jalan</th>
                                <th class="border p-2 text-center">Kepadatan</th>
                                <th class="border p-2 text-center">Status</th>
                                <th class="border p-2">Pelapor / Petugas</th>
                                <th class="border p-2">Waktu</th>
                                <th class="border p-2 text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($reports as $report)
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-2 text-center font-medium">
                                        {{ $reports->firstItem() + $loop->index }}
                                    </td>
                                    <td class="border p-2 text-center">
                                        <a href="{{ asset('storage/' . $report->foto_bukti) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $report->foto_bukti) }}"
                                                 alt="{{ $report->lokasi_jalan }}"
                                                 class="w-16 h-12 object-cover rounded shadow-sm border mx-auto">
                                        </a>
                                    </td>
                                    <td class="border p-2 font-semibold text-gray-900">
                                        {{ $report->lokasi_jalan }}
                                        @if ($report->keterangan)
                                            <span class="block font-normal text-xs text-gray-500 truncate max-w-xs">
                                                {{ $report->keterangan }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border p-2 text-center">
                                        @if ($report->tingkat_kepadatan >= 75)
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-700">
                                                Macet ({{ $report->tingkat_kepadatan }}%)
                                            </span>
                                        @elseif ($report->tingkat_kepadatan >= 40)
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-700">
                                                Padat ({{ $report->tingkat_kepadatan }}%)
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-700">
                                                Lancar ({{ $report->tingkat_kepadatan }}%)
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border p-2 text-center">
                                        @if ($report->status == 'Menunggu')
                                            <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700 font-medium">Menunggu</span>
                                        @elseif ($report->status == 'Diproses')
                                            <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700 font-medium">Diproses</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800 font-medium">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        {{ $report->nama_pelapor }}
                                    </td>
                                    <td class="border p-2 text-gray-500 text-xs">
                                        {{ $report->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="border p-2 text-center space-x-1">
                                        <a href="{{ route('traffic-reports.show', $report) }}" class="text-blue-600 hover:underline">Lihat</a> |
                                        <a href="{{ route('traffic-reports.edit', $report) }}" class="text-amber-600 hover:underline">Edit</a> |
                                        <form action="{{ route('traffic-reports.destroy', $report) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline"
                                                    onclick="return confirm('Yakin ingin menghapus laporan lalu lintas ini beserta file fotonya?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="border p-4 text-center text-gray-500">
                                        Belum ada laporan lalu lintas yang tersimpan. Silakan tambah data baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
