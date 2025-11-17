# Use official Apache + PHP image
FROM php:8.2-apache

# Enable Apache modules if you ever need .htaccess rules
RUN a2enmod rewrite

# Copy everything into Apache doc root
WORKDIR /var/www/html
COPY . /var/www/html

# (Optional) basic PHP config tweaks can go here
# RUN echo "upload_max_filesize=10M\npost_max_size=10M" > /usr/local/etc/php/conf.d/uploads.ini

# Apache listens on port 80 by default.
# Render will usually detect this automatically.
EXPOSE 80
