# Electricks Help Center - Deployment Guide

This document provides instructions for deploying the Electricks Help Center to production.

## Prerequisites

- PHP 7.4 or higher
- Apache or Nginx web server
- SSL certificate (for HTTPS)
- Domain: help.electricks.info

## Local Development

### Testing Locally

```bash
cd help
php -S localhost:8080 router.php
```

Open http://localhost:8080 in your browser.

### Development Workflow

1. Edit markdown files in `content/docs/`
2. Test locally with PHP server
3. Commit changes to git
4. Deploy to production

## Production Deployment

### Option 1: Apache with .htaccess

1. **Upload files** to web server
   ```bash
   rsync -avz --exclude '.git' --exclude '.DS_Store' \
     help/ user@server:/var/www/help.electricks.info/
   ```

2. **Set permissions**
   ```bash
   chmod 755 /var/www/help.electricks.info
   chmod 644 /var/www/help.electricks.info/.htaccess
   chmod 644 /var/www/help.electricks.info/*.php
   ```

3. **Configure Apache virtual host**
   ```apache
   <VirtualHost *:443>
       ServerName help.electricks.info
       DocumentRoot /var/www/help.electricks.info

       SSLEngine on
       SSLCertificateFile /path/to/cert.pem
       SSLCertificateKeyFile /path/to/key.pem

       <Directory /var/www/help.electricks.info>
           Options -Indexes +FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>

       ErrorLog ${APACHE_LOG_DIR}/help.electricks.info-error.log
       CustomLog ${APACHE_LOG_DIR}/help.electricks.info-access.log combined
   </VirtualHost>

   <VirtualHost *:80>
       ServerName help.electricks.info
       Redirect permanent / https://help.electricks.info/
   </VirtualHost>
   ```

4. **Restart Apache**
   ```bash
   sudo systemctl restart apache2
   ```

### Option 2: Nginx

1. **Upload files** (same as Apache)

2. **Configure Nginx**
   ```nginx
   server {
       listen 443 ssl http2;
       server_name help.electricks.info;
       root /var/www/help.electricks.info;
       index index.php;

       ssl_certificate /path/to/cert.pem;
       ssl_certificate_key /path/to/key.pem;

       # Security headers
       add_header X-Frame-Options "SAMEORIGIN" always;
       add_header X-XSS-Protection "1; mode=block" always;
       add_header X-Content-Type-Options "nosniff" always;

       # Static files
       location ~* \.(css|js|png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot|ico|webp|pdf)$ {
           expires 1y;
           add_header Cache-Control "public, immutable";
       }

       # API routes
       location ~ ^/api/(.+)$ {
           try_files /api/$1.php =404;
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $document_root/api/$1.php;
           include fastcgi_params;
       }

       # Documentation routes
       location ~ ^/docs/(.+)$ {
           try_files $uri /docs.php?path=$1;
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_index docs.php;
           fastcgi_param SCRIPT_FILENAME $document_root/docs.php;
           fastcgi_param QUERY_STRING path=$1;
           include fastcgi_params;
       }

       # Main index
       location / {
           try_files $uri $uri/ /index.php$is_args$args;
       }

       # PHP processing
       location ~ \.php$ {
           try_files $uri =404;
           fastcgi_split_path_info ^(.+\.php)(/.+)$;
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
           include fastcgi_params;
       }

       # Deny access to sensitive files
       location ~ /\. {
           deny all;
       }

       location ~ \.(md|sql)$ {
           deny all;
       }
   }

   server {
       listen 80;
       server_name help.electricks.info;
       return 301 https://$server_name$request_uri;
   }
   ```

3. **Test and restart Nginx**
   ```bash
   sudo nginx -t
   sudo systemctl restart nginx
   ```

## Content Migration

### Migrate from WordPress

Run the migration script:

```bash
cd help/scripts
php wordpress-migration.php \
  --wordpress-url=https://electricks.info \
  --output-dir=../content/docs \
  --dry-run
```

Review the output, then run without `--dry-run`:

```bash
php wordpress-migration.php \
  --wordpress-url=https://electricks.info \
  --output-dir=../content/docs
```

### Manual Content Creation

Create markdown files following the template:

```markdown
---
title: Article Title
category: Category Name
updated: 2025-01-25
---

# Article Title

Content here...
```

Place in appropriate directory under `content/docs/`.

## Post-Deployment Checklist

### Test Core Functionality

- [ ] Homepage loads correctly
- [ ] Search works
- [ ] Documentation pages render
- [ ] Navigation works
- [ ] Images load
- [ ] CSS/JS loads
- [ ] Mobile responsive
- [ ] SSL certificate valid

### Test Documentation

- [ ] All sample pages load
- [ ] Markdown renders correctly
- [ ] Internal links work
- [ ] External links work
- [ ] Code blocks highlighted
- [ ] Images display
- [ ] Table of contents works

### Performance

- [ ] Page load time < 2 seconds
- [ ] Images optimized
- [ ] CSS/JS minified (optional)
- [ ] Gzip compression enabled
- [ ] Browser caching configured

### SEO

- [ ] Meta descriptions present
- [ ] Proper heading hierarchy
- [ ] Alt tags on images
- [ ] Sitemap generated
- [ ] robots.txt configured
- [ ] 301 redirects from old URLs

### Security

- [ ] HTTPS enabled and working
- [ ] Security headers configured
- [ ] File permissions correct
- [ ] Directory listing disabled
- [ ] Sensitive files protected

## Ongoing Maintenance

### Content Updates

1. Edit markdown files
2. Test locally
3. Deploy to production
4. Verify changes live

### Monitoring

- Check error logs regularly
- Monitor server resources
- Track search queries
- Review user feedback

### Backup Strategy

**Daily backups**:
- Content markdown files
- Configuration files

**Weekly backups**:
- Full site backup
- Database (if using)

**Backup location**: Off-site storage

## DNS Configuration

Point `help.electricks.info` to your server:

```
Type: A
Name: help
Value: [Your server IP]
TTL: 3600
```

Or use CNAME if using CDN:

```
Type: CNAME
Name: help
Value: [Your CDN endpoint]
TTL: 3600
```

## SSL Certificate

### Using Let's Encrypt

```bash
sudo certbot --apache -d help.electricks.info
# or
sudo certbot --nginx -d help.electricks.info
```

### Auto-renewal

```bash
sudo certbot renew --dry-run
```

Add to cron:
```bash
0 0 * * 0 /usr/bin/certbot renew --quiet
```

## Monitoring & Analytics

### Server Monitoring

- Set up uptime monitoring
- Configure error alerting
- Monitor disk space
- Track bandwidth usage

### Analytics (Optional)

Add Google Analytics or similar to `includes/footer.php`:

```php
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'GA_TRACKING_ID');
</script>
```

## Troubleshooting

### 404 Errors

- Check .htaccess is being read
- Verify mod_rewrite enabled (Apache)
- Check nginx configuration syntax
- Verify file paths are correct

### Blank Pages

- Check PHP error logs
- Verify PHP version compatibility
- Check file permissions
- Enable error display temporarily

### Slow Performance

- Enable caching
- Optimize images
- Minify CSS/JS
- Use CDN for assets
- Increase PHP memory limit

## Support

For deployment issues:
- Check server error logs
- Review configuration
- Contact hosting provider
- Email: support@electricks.info

## Next Steps

After deployment:

1. **Populate content**
   - Run WordPress migration
   - Create missing device docs
   - Add all guides and support pages

2. **Set up redirects**
   - Map old WordPress URLs to new paths
   - Test all redirects

3. **Announce launch**
   - Update main site links
   - Email customers
   - Post in Facebook groups

4. **Monitor feedback**
   - Watch for broken links
   - Address user questions
   - Iterate based on usage

---

**Ready to launch!** 🚀
