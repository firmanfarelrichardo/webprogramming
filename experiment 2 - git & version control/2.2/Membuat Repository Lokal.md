# 2.2 - Membuat Repository Lokal

## Langkah-langkah

### 1. Buat direktori project baru
```bash
mkdir my-web-project
cd my-web-project
```

### 2. Inisialisasi Git repository
```bash
git init
ls -la  # lihat folder .git yang terbentuk
```

### 3. Buat file HTML sederhana
Buat file `index.html`:

```html
<!DOCTYPE html>
<html>
<head>
    <title>My First Git Project</title>
</head>
<body>
    <h1>Hello Git!</h1>
    <p>This is my first project with version control.</p>
</body>
</html>
```

### 4. Check status dan add file
```bash
git status
git add index.html
git status
```
