# Electricks Help Center

Customer-facing help documentation portal for Electricks magic devices.

## Overview

This help center provides comprehensive documentation, guides, and support resources for all Electricks products including:

- **Peeking Devices**: PeekSmith 3, Bond, MrCard, SuperPeek, Sharpeek
- **Prediction Watches**: SB Watch series
- **Remote Controls**: Atom Smart Remote, ATC Thumbtip, SB Mote
- **Specialty Devices**: Teleport, Quantum, Spotted Dice, CubeSmith, and more
- **Mobile Apps**: MagiScript, PeekSmith App, TimeSmith, DiceSmith, ScaleSmith

## Features

- **Search Functionality**: Quick search across all documentation
- **Category Navigation**: Organized by device type and topic
- **Markdown Content**: All documentation in easy-to-edit .md files
- **Responsive Design**: Works on all devices
- **SEO Optimized**: Proper meta tags and structure

## Local Development

### Requirements

- PHP 7.4 or higher
- No database required for basic functionality (file-based search)

### Running Locally

```bash
cd help
php -S localhost:8080 router.php
```

Then open http://localhost:8080 in your browser.

## Directory Structure

```
help/
├── config.php                 # Site configuration and navigation
├── index.php                  # Homepage
├── docs.php                   # Documentation viewer
├── router.php                 # Development router
├── api/
│   └── search.php            # Search API endpoint
├── includes/
│   ├── header.php            # Site header
│   ├── footer.php            # Site footer
│   ├── navigation.php        # Navigation builder
│   └── markdown-parser.php   # Markdown parsing
├── assets/
│   ├── css/style.css         # Site styles
│   ├── js/                   # JavaScript files
│   └── images/               # Images and icons
├── vendor/
│   └── parsedown/            # Markdown parser library
└── content/
    └── docs/                 # All documentation content
        ├── getting-started/
        ├── devices/
        │   ├── peeking/
        │   ├── watches/
        │   ├── remotes/
        │   └── specialty/
        ├── apps/
        ├── guides/
        └── support/
```

## Adding Content

### Create a New Article

1. Create a new `.md` file in the appropriate `content/docs/` subdirectory
2. Add frontmatter with title and metadata:

```markdown
---
title: Your Article Title
category: Category Name
updated: 2025-01-25
---

# Your Article Title

Your content here...
```

3. Add the article to navigation in `config.php` under `$NAVIGATION`

### Markdown Features

Supports standard Markdown plus:
- Code blocks with syntax highlighting
- Tables
- Task lists
- Automatic heading IDs for anchor links
- Auto-generated table of contents

## Migration from WordPress

See `scripts/wordpress-migration.php` for automated content extraction and conversion.

## Deployment

### Apache/Nginx

Use `.htaccess` or nginx config to route requests:

**Apache (.htaccess):**
```apache
RewriteEngine On
RewriteBase /

# Route API requests
RewriteRule ^api/(.+)$ api/$1.php [L]

# Route documentation
RewriteRule ^docs/(.+)$ docs.php?path=$1 [L,QSA]

# Route homepage
RewriteRule ^$ index.php [L]
```

**Nginx:**
```nginx
location / {
    try_files $uri $uri/ /index.php?$args;
}

location /docs/ {
    rewrite ^/docs/(.*)$ /docs.php?path=$1 last;
}

location /api/ {
    rewrite ^/api/(.*)$ /api/$1.php last;
}
```

## Search Configuration

Search uses file-based indexing by default. For better performance on large sites, configure MySQL in `config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'electricks_help');
define('DB_USER', 'your_user');
define('DB_PASS', 'your_password');
```

Then run the search indexer:

```bash
php scripts/index-search.php
```

## Support

For technical issues with this help portal:
- Developer Portal: https://developers.electricks.info
- Email: support@electricks.info

## License

© 2025 Electricks Kft. All rights reserved.
