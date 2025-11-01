# 2.4 - Remote Repository dengan GitHub

## Langkah-langkah

### 1. Buat repository baru di GitHub
- Buka [GitHub](https://github.com)
- Klik tombol "New Repository"
- Isi nama repository
- Klik "Create Repository"

### 2. Hubungkan repository lokal ke remote

```bash
git remote add origin https://github.com/username/my-web-project.git
git remote -v
```

### 3. Push ke remote repository

```bash
git push -u origin main
```

### 4. Verifikasi di GitHub
- Buka repository di GitHub
- Lihat file yang ter-upload
