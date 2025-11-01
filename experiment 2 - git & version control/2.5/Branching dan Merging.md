# 2.5 - Branching dan Merging

## Buat Branch Baru

```bash
git branch feature-navigation
git checkout feature-navigation
# atau gunakan: git checkout -b feature-navigation
```

## Tambah Navigation di index.html

```html
<body>
    <nav>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>
    <h1>Hello Git!</h1>
    <p>This is my first project with version control.</p>
</body>
```

## Update CSS untuk Navigation

Tambahkan di `style.css`:

```css
nav ul {
    list-style: none;
    padding: 0;
}

nav li {
    display: inline;
    margin-right: 20px;
}

nav a {
    text-decoration: none;
    color: #007acc;
}
```

## Commit di Feature Branch

```bash
git add .
git commit -m "Add navigation menu"
```

## Merge ke Main Branch

```bash
git checkout main
git merge feature-navigation
git branch -d feature-navigation
```
