# Incredible Portfolio (PHP)

A clean, modern **vanilla PHP** portfolio with a tiny router, shared layout, responsive UI, and a secure contact form (CSRF + validation). Zero external PHP dependencies – deploy anywhere PHP runs.

![PHP >= 8.0](https://img.shields.io/badge/PHP-%3E%3D%208.0-777BB4.svg?logo=php&logoColor=white)
![Framework: None](https://img.shields.io/badge/Framework-None-0F172A)
![License: MIT](https://img.shields.io/badge/License-MIT-10B981)

---

## Features

- **Lightweight:** plain PHP, no frameworks  
- **Simple routing:** `index.php?page=home|projects|about|contact`  
- **Reusable layout:** shared `header.php` / `footer.php` partials  
- **Easy content:** edit one `data/projects.php` array  
- **Secure contact form:** CSRF token + validation  
- **Reliable logging:** messages saved to `storage/messages.csv` (and `mail()` attempted if available)  
- **Modern UI:** responsive grid, cards, accessible colors  

---

## Folder Structure

    incredible-portfolio/
    |-- index.php           # Router (whitelists pages)
    |-- config.php          # Site name, tagline, owner, contact_email
    |-- functions.php       # Helpers: config(), e(), CSRF, mail, save_message
    |-- header.php          # Shared header/layout (top)
    |-- footer.php          # Shared footer/layout (bottom)
    |-- assets/             # Frontend assets
    |   |-- css/
    |   |   `-- style.css
    |   |-- js/
    |   |   `-- main.js
    |   `-- img/
    |       `-- ... your images ...
    |-- pages/              # Individual pages rendered by index.php
    |   |-- home.php
    |   |-- projects.php
    |   |-- about.php
    |   `-- contact.php
    |-- data/
    |   `-- projects.php    # Your projects array
    |-- storage/            # Contact form CSV (auto-created)
    |   `-- messages.csv
    |-- LICENSE
    `-- README.md

---

## Quick Start

### 1) Run locally

From the project root:

    php -S localhost:8000

Then open:

    http://localhost:8000

---

### 2) Configure

Edit `config.php`:

    return [
        'site_name'      => 'Incredible Portfolio',
        'tagline'        => 'Developer - Builder - Learner',
        'owner'          => 'Your Name',
        'contact_email'  => 'you@example.com', // used for mail(); CSV logging is always on
    ];

Update projects in `data/projects.php` (title, description, tech, links, `featured`).

> **Permissions:** Ensure the server can write to `/storage` so `messages.csv` can be created (for example on Linux: `chmod 755 storage` or `775` depending on your user/group).

---

### 3) Add / remove pages

- Create a new file in `pages/` (for example: `pages/services.php`).  
- Whitelist it in `index.php`:

      $allowed = ['home', 'projects', 'about', 'contact', 'services'];

- Link it in the header nav if needed (`header.php`).

---

## Contact Form

- Form lives in `pages/contact.php`.  
- **Security:** CSRF token + server-side validation.  
- **Delivery:** Always logs to `storage/messages.csv` and attempts `mail()` to `contact_email`.  
- **No SMTP by default:** If your host does not allow `mail()`, you still have the CSV log.  
  For SMTP, integrate a mailer (for example PHPMailer) inside `functions.php` as a future enhancement.

---

## Deployment

### Shared Hosting (cPanel / Plesk)

1. Create a domain or subdomain (for example `portfolio.example.com`).  
2. Set the document root to the project directory (where `index.php` lives).  
3. Upload all project files, keeping the structure intact.  
4. Ensure PHP **8.0+** is selected in your hosting panel.

### Apache (VPS)

Example virtual host:

    <VirtualHost *:80>
      ServerName example.com
      DocumentRoot /var/www/incredible-portfolio

      <Directory /var/www/incredible-portfolio>
        AllowOverride All
        Require all granted
      </Directory>

      # PHP handler (varies by setup)
      # ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:9000/var/www/incredible-portfolio/$1
    </VirtualHost>

### Nginx (VPS)

Example server block:

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
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;  # adjust PHP version/socket
      }
    }

---

## Customize the Design

- Styles: `assets/css/style.css` (CSS variables and base styles at the top)  
- JavaScript: `assets/js/main.js` (mobile navigation, small enhancements)  
- Images: replace or add files under `assets/img/`  
- Layout: adjust `header.php` and `footer.php` for branding, navigation, and structure  

The code is intentionally minimal so you can easily adapt it to your own style.

---

## Troubleshooting

- **Blank page / 404**  
  Make sure the server is serving the project directory and `index.php` is used as the entry point.

- **Emails not arriving**  
  Many shared hosts restrict `mail()`. Use the CSV log in `storage/messages.csv` as a fallback,  
  or integrate SMTP with a library like PHPMailer.

- **`messages.csv` not created**  
  Check write permissions on the `storage` directory.

- **Assets not loading**  
  Confirm the paths under `assets/` and ensure filenames and case match exactly.

---

## Roadmap

Ideas for future enhancements:

- SMTP transport via PHPMailer or another mailer  
- Client-side project search and filtering  
- Simple blog or notes section  
- Basic SEO meta tags and Open Graph data  
- Automatic sitemap.xml generation  
- Optional dark mode theme  

## Support My Work

If you find this project helpful and want to support its development, you can buy me a coffee:

[<img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" width="180" />](https://www.buymeacoffee.com/bromites)

---

## License

This project is licensed under the MIT License.  
See the `LICENSE` file for full details.

---

## Credits

Built with vanilla PHP, HTML, CSS, and a little JavaScript.  
Simple to read, simple to deploy, and easy to adapt to your own developer portfolio.
