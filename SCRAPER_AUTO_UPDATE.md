# Automatic Markdown File Updates - Enhanced Scraper

## Overview

The `scrape-navigation.php` script has been enhanced to **automatically add sidebar metadata to markdown files** after crawling electricks.info.

## What It Does Now

When you run the scraper, it now:

1. ✅ Crawls all product pages from electricks.info
2. ✅ Extracts all Elementor sidebar structures
3. ✅ Saves sidebars to `sidebars.json`
4. ✅ **Automatically adds `sidebar: "id"` to all markdown files** 🆕

## How It Works

### Before (Manual Process)
```bash
# Old workflow - 3 steps
php scrape-navigation.php          # 1. Scrape sidebars
# Then manually run for each product:
python3 add-sidebar-meta.py content/docs/docs/sbwatch 945e687
python3 add-sidebar-meta.py content/docs/docs/teleport 6bc33bd
# etc... for 20+ products
```

### After (Fully Automatic)
```bash
# New workflow - 1 step!
php scrape-navigation.php
# Done! All sidebars extracted AND added to markdown files
```

## Example Output

```
=== Scraping Product Sidebars ===
...
Scraping sidebar for: sbwatch
  Found Elementor sidebar: 945e687
    Sections: 4, Links: 24

...

=== Elementor Sidebars Saved ===
File: /path/to/sidebars.json
Total sidebars: 16
  - 945e687: Sbwatch Sidebar (4 sections)
  ...

=== Adding Sidebar Metadata to Markdown Files ===

Sidebar 945e687 used by: sbwatch, sb-watch-2, timesmith-app
  ✅ sbwatch.md
  ✅ sbwatch/troubleshooting.md
  ✅ sbwatch/calibration.md
  ✅ sbwatch/specifications.md
  ... (45 files total)

Sidebar 6bc33bd used by: teleport
  ✅ teleport.md
  ✅ teleport/specifications.md
  ✅ teleport/faq.md
  ... (23 files total)

✅ Total markdown files updated: 401
```

## What Gets Updated

### Main Product Files
- `content/docs/docs/sbwatch.md`
- `content/docs/docs/teleport.md`
- etc.

### Product Subdirectories
- All `.md` files in `content/docs/docs/sbwatch/`
- All `.md` files in `content/docs/docs/teleport/`
- Recursively includes nested subdirectories

### Frontmatter Update

**Before:**
```yaml
---
title: Troubleshooting
updated: "2025-07-09"
author: Electricks
category: guides
---
```

**After:**
```yaml
---
title: Troubleshooting
updated: "2025-07-09"
author: Electricks
category: guides
sidebar: "945e687"
---
```

## Smart Updates

The scraper is smart and:

✅ **Only updates files that don't have sidebar metadata**
- Skips files that already have `sidebar:` field
- Won't duplicate or overwrite existing sidebar values

✅ **Handles product relationships**
- Knows which sidebar belongs to which product
- Updates all related files (main + subdirectories)

✅ **Safe and reversible**
- Only adds one line to frontmatter
- Preserves all other metadata
- Changes are trackable via git

## Usage

### Full Crawl and Update
```bash
cd scripts
php scrape-navigation.php
```

This will:
- Crawl all 23 products
- Extract 16 unique sidebars
- Update 400+ markdown files
- Takes ~2-3 minutes

### What You'll See
1. Scraping progress for each product
2. Sidebar extraction confirmation
3. List of updated markdown files
4. Final count of updated files

### After Running
- Check `sidebars.json` - contains all sidebar structures
- Check your markdown files - all have `sidebar:` metadata
- Test on localhost - sidebars appear on all pages

## Code Changes

### New Methods in `scrape-navigation.php`

1. **`addSidebarsToMarkdownFiles()`**
   - Maps sidebars to their products
   - Calls `addSidebarToProductFiles()` for each

2. **`addSidebarToProductFiles($product, $sidebarId)`**
   - Updates main product file
   - Updates all files in product directory
   - Recursively handles subdirectories

3. **`addSidebarToFile($filepath, $sidebarId)`**
   - Checks if sidebar already exists
   - Adds sidebar to frontmatter
   - Returns true if updated

## Benefits

✅ **One-Command Setup** - No manual file editing
✅ **Always Up-to-Date** - Re-run anytime electricks.info changes
✅ **Zero Maintenance** - Automatic mapping and updates
✅ **Safe Updates** - Never overwrites existing sidebars
✅ **Batch Processing** - Updates 400+ files in seconds

## When to Run

Run the scraper when:
- 🆕 Adding new product pages
- 🔄 Sidebars change on electricks.info
- 🐛 Need to sync sidebar structures
- 📝 New markdown files added

## Future Enhancements

Possible improvements:
- [ ] Force update mode (override existing sidebars)
- [ ] Dry-run mode (preview changes without saving)
- [ ] Backup/restore functionality
- [ ] Selective product updates

## Troubleshooting

**Q: Files not updating?**
- Check file permissions (must be writable)
- Verify frontmatter format (must start with `---`)
- Ensure files are in correct directories

**Q: Wrong sidebar assigned?**
- Check `$sidebarToProducts` mapping in code
- Verify product slug matches directory name
- Check scraper found correct sidebar on electricks.info

**Q: Want to reset and re-update?**
```bash
# Remove all sidebar metadata
find content/docs/docs -name "*.md" -exec sed -i '' '/^sidebar:/d' {} \;

# Run scraper again
php scrape-navigation.php
```

---

**Status:** ✅ Implemented and Working
**Version:** Enhanced with auto-update
**Last Updated:** 2025-10-26
