<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Laporan Arus Lalu Lintas (SmartTraffic Finder)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('traffic-reports.update', $trafficReport) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="nama_pelapor" value="Nama Pelapor / Petugas Lapangan" />
                        <x-text-input id="nama_pelapor" name="nama_pelapor" type="text" class="mt-1 block w-full"
                                      :value="old('nama_pelapor', $trafficReport->nama_pelapor)" required />
                        <x-input-error :messages="$errors->get('nama_pelapor')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="lokasi_jalan" value="Lokasi Ruas Jalan" />
                        <x-text-input id="lokasi_jalan" name="lokasi_jalan" type="text" class="mt-1 block w-full"
                                      :value="old('lokasi_jalan', $trafficReport->lokasi_jalan)" required />
                        <x-input-error :messages="$errors->get('lokasi_jalan')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="tingkat_kepadatan" value="Tingkat Kepadatan Arus (0 - 100%)" />
                            <x-text-input id="tingkat_kepadatan" name="tingkat_kepadatan" type="number" min="0" max="100" class="mt-1 block w-full"
                                          :value="old('tingkat_kepadatan', $trafficReport->tingkat_kepadatan)" required />
                            <x-input-error :messages="$errors->get('tingkat_kepadatan')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="status" value="Status Penanganan" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="Menunggu" {{ old('status', $trafficReport->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Diproses" {{ old('status', $trafficReport->status) == 'Diproses' ? 'selected' : '' }}>Diproses (Rekayasa Lalin)</option>
                                <option value="Selesai" {{ old('status', $trafficReport->status) == 'Selesai' ? 'selected' : '' }}>Selesai (Normal)</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="keterangan" value="Keterangan Kondisi & Penyebab Kemacetan (Opsional)" />
                        <textarea id="keterangan" name="keterangan" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('keterangan', $trafficReport->keterangan) }}</textarea>
                        <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-700 uppercase mb-1">Foto Bukti Saat Ini:</p>
                        @if ($trafficReport->foto_bukti)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $trafficReport->foto_bukti) }}"
                                     alt="{{ $trafficReport->lokasi_jalan }}"
                                     class="w-48 h-32 object-cover rounded shadow border">
                            </div>
                        @endif
                        <x-input-label for="foto_bukti" value="Ganti Foto Bukti (Kosongkan jika tidak ingin mengubah foto)" />
                        <input id="foto_bukti" name="foto_bukti" type="file" accept="image/jpeg,image/png,image/jpg"
                               class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm">
                        <x-input-error :messages="$errors->get('foto_bukti')" class="mt-2" />
                    </div>

                    <div class="flex items-center space-x-3 mt-6">
                        <x-primary-button>Perbarui Data</x-primary-button>
                        <a href="{{ route('traffic-reports.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
