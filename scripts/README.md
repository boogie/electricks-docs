# Electricks Documentation Crawler

Unified crawler that extracts both documentation content and sidebar structures from electricks.info.

## Overview

The `crawl-docs.php` script combines the functionality of the previous `scrape-navigation.php` and `wordpress-migration.php` scripts into one powerful tool.

## What It Does

1. ✅ **Crawls documentation pages** from electricks.info
2. ✅ **Converts HTML to Markdown** with proper formatting
3. ✅ **Extracts Elementor sidebars** (navigation structures)
4. ✅ **Saves sidebars** to `sidebars.json`
5. ✅ **Automatically adds sidebar metadata** to all markdown files
6. ✅ **Supports local sidebar overrides** when Elementor widgets don’t match the product

## Usage

### Full Crawl (Recommended)
Crawl everything - both content and sidebars:
```bash
php crawl-docs.php
```

### Content Only
Only crawl and convert documentation pages:
```bash
php crawl-docs.php --docs-only
```

### Sidebars Only
Only extract sidebar structures:
```bash
php crawl-docs.php --sidebars-only
```

### Local Sidebar Overrides Only
Only rebuild the sidebars defined in `config/sidebar-overrides.php` (useful when Elementor output is wrong) and update markdown metadata:
```bash
php crawl-docs.php --local-sidebars-only
```

### Dry Run
Preview what would be done without making changes:
```bash
php crawl-docs.php --dry-run
```

### Help
```bash
php crawl-docs.php --help
```

## What Gets Crawled

The crawler processes **23 products**:
- peeksmith-3
- bond
- mrcard
- sbwatch
- sb-watch-2
- atom-remote
- sbmote
- teleport
- quantum
- spotted-dice
- cubesmith
- ghostmove
- soulmate
- ray
- vision
- mental-wave
- lunacards
- nfc-rfid
- magiscript
- peeksmith-app
- timesmith-app
- dicesmith-app
- scalesmith-app

## Output

### Documentation Files
Markdown files are created in:
```
content/docs/docs/
├── sbwatch.md
├── sbwatch/
│   ├── troubleshooting.md
│   ├── calibration.md
│   └── ...
├── teleport.md
├── teleport/
│   └── ...
└── ...
```

### Sidebar Definitions
All sidebars are saved to:
```
sidebars.json
```

### Markdown Frontmatter
Each markdown file includes:
```yaml
---
title: Troubleshooting
updated: 2025-10-26
author: Electricks
category: guides
sidebar: "945e687"
---
```

## Features

### Content Extraction
- ✅ Converts HTML to clean Markdown
- ✅ Preserves images, links, headings
- ✅ Handles YouTube embeds
- ✅ Removes Elementor markup
- ✅ Cleans up whitespace

### Sidebar Extraction
- ✅ Finds all Elementor widget sidebars
- ✅ Extracts sections and links
- ✅ Captures icons (emojis)
- ✅ Detects highlighted items
- ✅ Converts URLs to relative paths
- ✅ Applies local overrides from `config/sidebar-overrides.php` when Elementor data is wrong

### Automatic Updates
- ✅ Adds `sidebar:` to frontmatter
- ✅ Updates all product files
- ✅ Handles nested directories
- ✅ Skips files that already have sidebars
- ✅ Safe and reversible

## Example Output

```
=== Electricks Documentation Crawler ===

Mode: ALL
Dry Run: NO

=== Crawling Documentation Pages ===

Crawling: sbwatch
  ✅ sbwatch.md
  ✅ sbwatch/troubleshooting.md
  ✅ sbwatch/calibration.md
  ... (45 files)

=== Extracting Elementor Sidebars ===

Scraping: sbwatch
  ✅ Found sidebar: 945e687

✅ Saved 16 sidebars to sidebars.json

=== Adding Sidebar Metadata to Markdown Files ===

Sidebar 945e687: sbwatch, sb-watch-2, timesmith-app
  ✅ sbwatch.md
  ✅ sbwatch/troubleshooting.md
  ... (45 files)

=== Crawl Complete ===
Pages crawled: 401
Sidebars extracted: 16
Markdown files updated: 401
Errors: 0
```

## When to Run

Run the crawler when:
- 🆕 Adding new products
- 🔄 Content updated on electricks.info
- 📝 Sidebars changed on main site
- 🐛 Need to sync structures

## Sidebar Overrides

Not every product page ships with the correct Elementor sidebar (DiceSmith App is a good example). Add overrides to `config/sidebar-overrides.php` to describe these special cases. Each entry supports:

- `mode`: `local` (generate from markdown directories) or `alias` (point to another ID)
- `sidebar_id` / `name`: how the sidebar is stored in frontmatter and `sidebars.json`
- Optional `icons` and `section_headings` for quick customization

Run `php crawl-docs.php --local-sidebars-only` whenever you modify the override file to regenerate the sidebar JSON and update the relevant markdown frontmatter.

## Performance

- **Full crawl:** ~5-10 minutes (includes 1s delay per page)
- **Sidebars only:** ~2-3 minutes
- **Docs only:** ~5-7 minutes

The crawler is respectful and includes 1-second delays between requests.

## Troubleshooting

**Q: Files not being created?**
- Check write permissions on `content/docs/docs/`
- Ensure directories exist or can be created

**Q: Sidebars not extracted?**
- Verify electricks.info is accessible
- Check that pages have Elementor widgets with data-id attributes

**Q: Want to force re-extract everything?**
```bash
# Remove all existing content
rm -rf ../content/docs/docs/*

# Remove sidebar metadata
find ../content/docs -name "*.md" -exec sed -i '' '/^sidebar:/d' {} \;

# Run full crawl
php crawl-docs.php
```

## Comparison to Old Scripts

| Feature | Old Scripts | New Unified Crawler |
|---------|-------------|---------------------|
| Files | 8 separate scripts | 1 script |
| Commands | Multiple steps | Single command |
| Language | Python + PHP | PHP only |
| Maintenance | High | Low |
| Speed | Slower | Faster |
| Automation | Manual | Fully automatic |

## Migrated From

The following scripts have been replaced and removed:
- ❌ `scrape-navigation.php` (merged)
- ❌ `wordpress-migration.php` (merged)
- ❌ `crawl-sidebars.py` (replaced)
- ❌ `discover-sidebars.py` (replaced)
- ❌ `add-sidebar-meta.py` (integrated)
- ❌ `add-all-sidebars.php` (integrated)
- ❌ `test-markdown-update.php` (obsolete)
- ❌ `add-sidebars-to-subdirs.sh` (integrated)

## Dependencies

- PHP 7.4+ with cURL extension
- Write permissions to `content/` and `sidebars.json`

No Python required! No external packages needed!

---

**Last Updated:** 2025-10-26
**Version:** 2.0 (Unified Crawler)
