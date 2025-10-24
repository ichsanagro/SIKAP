# TODO: Perbaiki Controller AdminProdi untuk Menghapus Validasi dan Penyimpanan Prodi

- [x] Hapus validasi 'prodi' => 'required|string|max:255' dari method storeStudent
- [x] Hapus field 'prodi' => $request->prodi dari User::create di method storeStudent
