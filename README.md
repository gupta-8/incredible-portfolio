# Modern PHP Portfolio
A clean, modern portfolio template using vanilla PHP.

## Features
- Root-level **index.php**, **header.php**, **footer.php**
- Pages: Home, Projects, About, Contact
- Responsive, modern design with light/dark toggle
- Contact form with CSRF + CSV fallback + `mail()` attempt
- No external PHP dependencies

## Run
```bash
php -S localhost:8000
```
Open http://localhost:8000

## Configure
- Edit `config.php` (name, tagline, email, socials)
- Edit `data/projects.php` to add projects
- Replace `assets/img/placeholder.svg` as needed

## Deploy
Upload all files to a PHP host (cPanel, Plesk, Render, etc.).
