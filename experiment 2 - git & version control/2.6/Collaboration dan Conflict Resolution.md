# 2.6 - Collaboration dan Conflict Resolution

## Simulasi Perubahan dari Remote

### 1. Edit file langsung di GitHub
- Buka repository di GitHub
- Klik file yang ingin diedit
- Klik tombol "Edit" (icon pensil)
- Commit perubahan di web interface

### 2. Pull perubahan ke local

```bash
git pull origin main
```

## Resolving Conflicts

### 1. Buat perubahan lokal yang bertentangan
- Edit baris yang sama di file lokal
- Commit perubahan lokal

### 2. Coba push (akan error)

```bash
git push origin main  # akan error karena ada perubahan di remote
```

### 3. Pull perubahan (akan ada conflict)

```bash
git pull origin main  # akan muncul conflict
```

### 4. Resolve conflict

- Edit file yang conflict
- Hapus conflict markers:
  - `<<<<<<<` HEAD
  - `=======`
  - `>>>>>>>` branch-name
- Pilih kode yang benar atau gabungkan keduanya

### 5. Add dan commit hasil resolve

```bash
git add .
git commit -m "Resolve merge conflict"
git push origin main
```

## Tips Menghindari Conflict

- Selalu pull sebelum mulai coding
- Komunikasi dengan tim tentang file yang sedang dikerjakan
- Commit dan push secara teratur
- Gunakan branch untuk feature baru
