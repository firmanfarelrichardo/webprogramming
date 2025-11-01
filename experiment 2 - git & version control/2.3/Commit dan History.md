# 2.3 - Commit dan History

## Commit Pertama

```bash
git commit -m "Initial commit: Add index.html"
git log
git log --oneline
```

## Tambah File CSS

Buat file `style.css`:

```css
/* style.css */
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-color: #f0f0f0;
}

h1 {
    color: #333;
}
```

## Update index.html

Tambahkan link CSS di `<head>`:

```html
<head>
    <title>My First Git Project</title>
    <link rel="stylesheet" href="style.css">
</head>
```

## Commit Perubahan

```bash
git add .
git commit -m "Add CSS styling and link to index.html"
git log --oneline
```
