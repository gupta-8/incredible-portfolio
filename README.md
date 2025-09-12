
# Incredible Portfolio (PHP) 

A clean, modern **vanilla PHP** portfolio with a tiny router, shared layout, responsive UI, and a secure contact form (CSRF + validation). Zero external PHP dependencies - deploy anywhere PHP runs.

<p align="left">
  <img alt="PHP >= 8.0" src="https://img.shields.io/badge/PHP-%3E%3D%208.0-777BB4.svg?logo=php&logoColor=white">
  <img alt="No Framework" src="https://img.shields.io/badge/Framework-None-0F172A">
  <img alt="License MIT" src="https://img.shields.io/badge/License-MIT-10B981">
</p>

---

## Preview
> Replace with real screenshots of your site.
<p align="center">
  <img src="public/assets/img/placeholder.svg" width="720" alt="Homepage preview">
</p>

---

## Features
-  **Lightweight:** plain PHP, no frameworks
-  **Simple routing:** `public/index.php?page=home|projects|about|contact`
-  **Reusable layout:** shared header/footer partials
-  **Easy content:** edit one `app/data/projects.php` array
-  **Secure contact form:** CSRF token + validation
-  **Reliable logging:** messages saved to `storage/messages.csv` (and `mail()` attempted if available)
-  **Modern UI:** responsive grid, cards, accessible colors

---

## Folder Structure
```
incredible-portfolio-php/
|-- public/                 # Document root
|    |-- index.php            # Router (whitelists pages)
|    `-- assets/
|       |-- css/style.css
|       |-- js/main.js
|       `-- img/placeholder.svg
|-- app/
|    |-- config.php           # Site name, tagline, owner, contact_email
|    |-- lib/functions.php    # Helpers: config(), e(), CSRF, mail, save_message
|    |-- partials/
|    |    |-- header.php
|    |    `-- footer.php
|    |-- pages/
|    |    |-- home.php
|    |    |-- projects.php
|    |    |-- about.php
|    |    `-- contact.php
|    `-- data/projects.php    # Your projects array
|-- storage/                # Contact form CSV (auto-created)
|    `-- messages.csv
|-- LICENSE                 # MIT
|-- .gitignore
`-- README.md
```

---

## Quick Start

### 1) Run locally
```bash
# from the project root
php -S localhost:8000 -t public
```
Open **http://localhost:8000**

### 2) Configure
Edit **`app/config.php`**:
```php
return [
    'site_name' => 'Incredible Portfolio',
    'tagline'   => 'Developer - Builder - Learner',
    'owner'     => 'Your Name',
    'contact_email' => 'you@example.com', // used for mail(); CSV logging is always on
];
```
Update projects in **`app/data/projects.php`** (title, description, tech, links, `featured`).

> **Permissions:** Ensure the server can write to `/storage` so `messages.csv` can be created (e.g., Linux: `chmod 755 storage` or `775` depending on your user/group).

### 3) Add / remove pages
- Create a new file in `app/pages/` (e.g., `services.php`).
- Whitelist it in **`public/index.php`**:
  ```php
  $allowed = ['home','projects','about','contact','services'];
  ```
- Link it in the header nav if needed (`app/partials/header.php`).

---

## Contact Form

- Form lives in **`app/pages/contact.php`**
- **Security:** CSRF token + server-side validation
- **Delivery:** Always logs to `storage/messages.csv` and **attempts** `mail()` to `contact_email`
- **No SMTP by default:** If your host doesn't allow `mail()`, you still have the CSV log.  
  For SMTP, integrate a mailer (e.g., PHPMailer) in `app/lib/functions.php` (optional future enhancement).

---

## Deployment

### Shared Hosting (cPanel / Plesk)
1. Create a domain/subdomain (e.g., `portfolio.example.com`).
2. **Set document root to the `public/` folder**.
3. Upload all project files, keeping the structure intact.
4. Ensure PHP **8.0+** is selected in your hosting panel.

### Apache (VPS)
Set the **DocumentRoot** to the `public/` directory:
```apache
<VirtualHost *:80>
  ServerName example.com
  DocumentRoot /var/www/incredible-portfolio-php/public

  <Directory /var/www/incredible-portfolio-php/public>
    AllowOverride All
    Require all granted
  </Directory>

  # PHP handler (varies by setup)
  # ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:9000/var/www/incredible-portfolio-php/public/$1
</VirtualHost>
```

### Nginx (VPS)
```nginx
server {
  listen 80;
  server_name example.com;
  root /var/www/incredible-portfolio-php/public;
  index index.php;

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.2-fpm.sock; # adjust version/socket
  }
}
```

---

## Customize the Design
- Styles: **`public/assets/css/style.css`** (CSS variables at the top)
- Small JS: **`public/assets/js/main.js`** (mobile nav toggle)
- Images: **`public/assets/img/`** (replace the placeholder SVG with your project shots)

---

## Troubleshooting
- **Blank page / 404** → Ensure your web root points to `public/` (not the repo root).
- **No emails arriving** → Hosts often block `mail()`. CSV logging still works. Consider SMTP.
- **`messages.csv` not created** → Make sure `/storage` is writable by the web server user.
- **Assets not loading** → Check relative path `public/assets/...` and case-sensitive filenames.

---

## Roadmap (Optional Enhancements)
- SMTP transport (PHPMailer/SwiftMailer)
- RSS/Blog page
- Project filter/search (client-side)
- Sitemap.xml + basic SEO tags

---

## License
MIT - see [LICENSE](LICENSE).

---

### Credits
Made with love using vanilla PHP. Customize freely and ship it!
