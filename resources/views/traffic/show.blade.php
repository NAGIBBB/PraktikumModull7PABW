<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Laporan Kemacetan - SmartTraffic Finder') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="border-b pb-4">
                    <span class="text-xs uppercase font-bold tracking-wider text-indigo-600">Laporan Pemantauan Lapangan</span>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $trafficReport->lokasi_jalan }}</h3>
                    <p class="text-sm text-gray-500">Dilaporkan oleh: <strong>{{ $trafficReport->nama_pelapor }}</strong> &bull; {{ $trafficReport->created_at->diffForHumans() }} ({{ $trafficReport->created_at->format('d F Y, H:i') }})</p>
                </div>

                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-semibold">Tingkat Kepadatan:</span>
                        <div class="mt-1">
                            @if ($trafficReport->tingkat_kepadatan >= 75)
                                <span class="px-3 py-1 text-sm font-bold rounded-full bg-red-100 text-red-800">Macet Parah ({{ $trafficReport->tingkat_kepadatan }}%)</span>
                            @elseif ($trafficReport->tingkat_kepadatan >= 40)
                                <span class="px-3 py-1 text-sm font-bold rounded-full bg-yellow-100 text-yellow-800">Padat Merayap ({{ $trafficReport->tingkat_kepadatan }}%)</span>
                            @else
                                <span class="px-3 py-1 text-sm font-bold rounded-full bg-green-100 text-green-800">Arus Lancar ({{ $trafficReport->tingkat_kepadatan }}%)</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-semibold">Status Tindakan:</span>
                        <div class="mt-1">
                            @if ($trafficReport->status == 'Menunggu')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-200 text-gray-700">Menunggu Verifikasi</span>
                            @elseif ($trafficReport->status == 'Diproses')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-700">Dalam Penanganan Petugas</span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Selesai / Terurai</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-800 text-sm mb-1">Keterangan / Kronologi Lapangan:</h4>
                    <p class="text-gray-700 bg-white p-3 border rounded-md text-sm">
                        {{ $trafficReport->keterangan ?? 'Tidak ada catatan tambahan untuk laporan ini.' }}
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-800 text-sm mb-2">Dokumentasi Foto Bukti Kondisi Lapangan:</h4>
                    @if ($trafficReport->foto_bukti)
                        <div class="border rounded-lg overflow-hidden max-w-lg shadow-sm">
                            <img src="{{ asset('storage/' . $trafficReport->foto_bukti) }}"
                                 alt="Bukti kondisi lalu lintas {{ $trafficReport->lokasi_jalan }}"
                                 class="w-full h-auto object-cover">
                        </div>
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $trafficReport->foto_bukti) }}" target="_blank"
                               class="text-xs text-indigo-600 hover:underline">
                                Buka Foto Resolusi Penuh di Tab Baru &rarr;
                            </a>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">Tidak ada foto dokumentasi terlampir.</p>
                    @endif
                </div>

                <div class="pt-4 border-t flex items-center justify-between">
                    <div class="space-x-2">
                        <a href="{{ route('traffic-reports.edit', $trafficReport) }}"
                           class="px-4 py-2 bg-amber-500 text-white rounded text-sm font-medium hover:bg-amber-600">
                            Edit Laporan
                        </a>
                        <a href="{{ route('traffic-reports.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm font-medium hover:bg-gray-300">
                            Kembali ke Daftar
                        </a>
                    </div>
                    <form action="{{ route('traffic-reports.destroy', $trafficReport) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:underline"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini beserta file fotonya?')">
                            Hapus Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
