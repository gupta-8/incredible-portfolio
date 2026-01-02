# Incredible Portfolio (PHP)

**A modern, framework-free PHP portfolio** — tiny router, reusable layout, responsive UI, and a secure contact form.  
**Zero external PHP dependencies** • Deploy anywhere PHP runs 🚀

<p>
  <img alt="PHP" src="https://img.shields.io/badge/PHP-%3E%3D%208.0-777BB4.svg?logo=php&logoColor=white" />
  <img alt="Framework" src="https://img.shields.io/badge/Framework-None-0F172A" />
  <img alt="License" src="https://img.shields.io/badge/License-MIT-10B981" />
</p>

---

## Highlights

- **Lightweight:** plain PHP, no frameworks
- **Simple routing:** `index.php?page=home|projects|about|contact`
- **Reusable layout:** shared `header.php` / `footer.php`
- **Easy content editing:** update one `data/projects.php` array
- **Secure contact form:** CSRF token + server-side validation
- **Reliable logging:** saves messages to `storage/messages.csv` *(and attempts `mail()` if available)*
- **Modern UI:** responsive layout, clean cards, accessible colors

---

## Requirements

- **PHP 8.0+**
- A server that can run PHP (local PHP server, shared hosting, VPS, etc.)
- Write permission for `/storage` (for saving contact messages)

---

## Quick Start

### Run locally

From the project root:

```bash
php -S localhost:8000
```

Open:

```text
http://localhost:8000
```

---

## Project Structure

```text
incredible-portfolio/
├─ index.php           # Router (whitelists pages)
├─ config.php          # Site config: name, tagline, owner, contact_email
├─ functions.php       # Helpers: config(), e(), CSRF, mail, save_message
├─ header.php          # Shared header/layout (top)
├─ footer.php          # Shared footer/layout (bottom)
├─ assets/
│  ├─ css/
│  │  └─ style.css
│  ├─ js/
│  │  └─ main.js
│  └─ img/
│     └─ preview.png   # Add your screenshot here
├─ pages/
│  ├─ home.php
│  ├─ projects.php
│  ├─ about.php
│  └─ contact.php
├─ data/
│  └─ projects.php     # Your projects array
├─ storage/
│  └─ messages.csv     # Contact form CSV (auto-created)
├─ LICENSE
└─ README.md
```

---

## Customize

### 1) Update site details

Edit `config.php`:

```php
return [
  'site_name'     => 'Incredible Portfolio',
  'tagline'       => 'Developer • Builder • Learner',
  'owner'         => 'Your Name',
  'contact_email' => 'you@example.com', // used for mail(); CSV logging is always on
];
```

### 2) Add your projects

Edit `data/projects.php` to update:
- title
- description
- tech
- links
- `featured`

### 3) Add / remove pages

- Add a new file inside `pages/` (example: `pages/services.php`)
- Whitelist it in `index.php`:

```php
$allowed = ['home', 'projects', 'about', 'contact', 'services'];
```

- Add it to navigation (in `header.php`) if needed

---

## Contact Form

- Page: `pages/contact.php`
- Security: **CSRF token + server-side validation**
- Delivery:
  - Always logs to `storage/messages.csv`
  - Attempts `mail()` to `contact_email` (if supported by hosting)

> Many hosts restrict `mail()`. The CSV log is your reliable fallback.  
> For SMTP, adding a mailer (like PHPMailer) is a great future upgrade.

---

## Deployment

<details>
<summary><b>Shared Hosting (cPanel / Plesk)</b></summary>

- Upload the project where `index.php` is in the document root  
- Select PHP **8.0+** in hosting settings  
- Ensure `/storage` is writable

</details>

<details>
<summary><b>Apache (VPS) — Example VirtualHost</b></summary>

```apache
<VirtualHost *:80>
  ServerName example.com
  DocumentRoot /var/www/incredible-portfolio

  <Directory /var/www/incredible-portfolio>
    AllowOverride All
    Require all granted
  </Directory>
</VirtualHost>
```

</details>

<details>
<summary><b>Nginx (VPS) — Example Server Block</b></summary>

```nginx
server {
  listen 80;
  server_name example.com;

  root /var/www/incredible-portfolio;
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

</details>

---

## Security Notes

### Protect `/storage` (IMPORTANT)

`storage/messages.csv` contains private messages.  
Make sure `/storage` **is not accessible from the public web**.

#### Apache option: block with `.htaccess`

Create `storage/.htaccess`:

```apache
Require all denied
Deny from all
```

#### Nginx option: block with location rule

```nginx
location ^~ /storage/ {
  deny all;
  return 404;
}
```

### Permissions note

If messages aren’t being saved, it’s usually storage permissions.
- Ensure `/storage` is writable by the server user.

---

## License

MIT — see `LICENSE`

---

## Credits

Built with **vanilla PHP + HTML + CSS + a little JS**.
