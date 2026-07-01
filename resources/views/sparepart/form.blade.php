@csrf

<div class="form-group">
    <label for="nama_sparepart">Nama Sparepart</label>
    <input class="form-control" id="nama_sparepart" type="text" name="nama_sparepart" value="{{ old('nama_sparepart', $sparepart->nama_sparepart ?? '') }}" required>
    @error('nama_sparepart')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="gambar_sparepart">Gambar Sparepart</label>
    @if (isset($sparepart) && $sparepart->gambar_sparepart)
        <div class="image-preview">
            <img src="{{ asset('storage/' . $sparepart->gambar_sparepart) }}" alt="{{ $sparepart->nama_sparepart }}">
        </div>
    @endif
    <input class="form-control" id="gambar_sparepart" type="file" name="gambar_sparepart" accept="image/png,image/jpeg,image/webp">
    <small class="help-text">Format: JPG, PNG, atau WEBP. Maksimal 2 MB.</small>
    @error('gambar_sparepart')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="kode_sparepart">Kode Sparepart</label>
    <input class="form-control" id="kode_sparepart" type="text" name="kode_sparepart" value="{{ old('kode_sparepart', $sparepart->kode_sparepart ?? $randomCode ?? '') }}" required {{ isset($sparepart) ? '' : 'readonly' }}>
    @error('kode_sparepart')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="harga">Harga</label>
    <input class="form-control" id="harga" type="number" name="harga" min="0" step="1" value="{{ old('harga', $sparepart->harga ?? '') }}" required>
    @error('harga')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="stok">Stok Barang</label>
    <input class="form-control" id="stok" type="number" name="stok" min="0" step="1" value="{{ old('stok', $sparepart->stok ?? 0) }}" required>
    @error('stok')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<div class="actions">
    <button class="btn btn-primary" type="submit">Simpan</button>
    <a class="btn btn-light" href="{{ route('sparepart.index') }}">Kembali</a>
</div>
