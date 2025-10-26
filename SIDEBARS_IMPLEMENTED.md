# Reusable Sidebars Implementation

## Overview

The help site now supports reusable sidebars that match the exact structure from electricks.info. Sidebars are defined in `sidebars.json` and can be referenced by pages using frontmatter metadata.

## How It Works

### 1. Sidebar Definitions (`sidebars.json`)

All sidebar structures are stored in `/sidebars.json`:

```json
{
  "945e687": {
    "id": "945e687",
    "name": "SB Watch Sidebar",
    "sections": [
      {
        "heading": "General",
        "links": [...]
      }
    ]
  }
}
```

### 2. Page Metadata

Pages specify which sidebar to use via frontmatter:

```yaml
---
title: Troubleshooting
sidebar: "945e687"
---
```

### 3. Rendering

The system automatically:
- Checks if a page has `sidebar` metadata
- Loads the sidebar from `sidebars.json`
- Renders it in the right column
- Highlights the current page
- Falls back to product navigation if no sidebar is specified

## Available Sidebars

Currently crawled from electricks.info (16 unique sidebars):

| ID | Name | Sections | Links |
|----|------|----------|-------|
| `945e687` | SB Watch Sidebar | 4 | 24 |
| `297a4df` | PeekSmith 3 Sidebar | 5 | 37 |
| `6bc33bd` | Teleport Sidebar | 6 | 25 |
| `a56f609` | Bond Sidebar | 4 | 14 |
| `aa887b8` | Atom Remote Sidebar | 4 | 44 |
| `8f9b47b` | SB Mote Sidebar | 1 | 4 |
| `47c53eb` | Spotted Dice Sidebar | 3 | 8 |
| `11a9eac` | CubeSmith Sidebar | 4 | 24 |
| `6b7f096` | GhostMove Sidebar | 3 | 10 |
| `ee4bc46` | SoulMate Sidebar | 4 | 22 |
| `b05d384` | Vision Sidebar | 1 | 3 |
| `6e331f5` | Mental Wave Sidebar | 2 | 12 |
| `5072f56` | LunaCards Sidebar | 5 | 17 |
| `ba330b3` | NFC RFID Sidebar | 1 | 3 |
| `a93aec4` | MagiScript Sidebar | 5 | 45 |
| `7211048` | ScaleSmith App Sidebar | 3 | 8 |

## Pages Using Sidebars

### SB Watch (45 pages)
- `/docs/sbwatch.md` (First Steps)
- All pages in `/docs/sbwatch/` directory
- Using sidebar: `945e687`

## Crawler Scripts

### Main Scraper (Recommended)
The PHP scraper crawls all products and extracts all sidebars automatically:

```bash
cd scripts
php scrape-navigation.php
```

This will:
- Scrape product information from /docs/
- Extract all Elementor sidebar structures
- Save to `sidebars.json`
- Save navigation data to `navigation-scraped.json`

### Python Alternatives

**Discover All Sidebars:**
```bash
cd scripts
python3 discover-sidebars.py
```

**Extract Specific Sidebar:**
```bash
cd scripts
python3 crawl-sidebars.py https://electricks.info/docs/quantum/ sidebar-id
```

**Add Sidebar to Pages:**
```bash
cd scripts
python3 add-sidebar-meta.py ../content/docs/docs/quantum 945e687
```

## File Structure

```
help/
├── sidebars.json                    # Sidebar definitions
├── content/docs/docs/
│   ├── sbwatch.md                   # sidebar: "945e687"
│   └── sbwatch/
│       ├── troubleshooting.md       # sidebar: "945e687"
│       └── ...
├── includes/
│   └── navigation.php               # buildReusableSidebar()
├── docs.php                         # Checks frontmatter for sidebar
├── assets/css/
│   └── style.css                    # .reusable-sidebar styles
└── scripts/
    ├── discover-sidebars.py         # Crawl electricks.info
    ├── crawl-sidebars.py            # Extract single sidebar
    └── add-sidebar-meta.py          # Add metadata to files
```

## CSS Styling

Sidebars use the same simple style as the table of contents:

- Clean, minimal design
- Uppercase section headings
- Hover effects
- Active page highlighting (orange)
- Icon support (emojis)

## Adding New Sidebars

1. **Crawl from electricks.info:**
   ```bash
   cd scripts
   python3 discover-sidebars.py https://electricks.info/docs/product-name/
   ```

2. **Get the sidebar ID from output**

3. **Add to your pages:**
   ```bash
   python3 add-sidebar-meta.py ../content/docs/docs/product-name sidebar-id
   ```

## Technical Implementation

### PHP Functions (`includes/navigation.php`)

- `buildReusableSidebar($sidebarId, $currentPath)` - Renders sidebar from JSON
- Falls back gracefully if sidebar doesn't exist

### Page Rendering (`docs.php`)

```php
if (isset($frontMatter['sidebar'])) {
    echo buildReusableSidebar($frontMatter['sidebar'], $requestedPath);
} else {
    echo buildProductPageNav($requestedPath);
}
```

### CSS Classes

- `.reusable-sidebar` - Container
- `.docs-group-nav` - Content wrapper
- `h2.wp-block-heading` - Section headings
- `p` - Link containers
- `p.active` - Current page
- `p.highlight` - Highlighted links

## Benefits

✓ Single source of truth for sidebar navigation
✓ Easy to update across all pages
✓ Automatic crawling from electricks.info
✓ Matches exact structure from main site
✓ Clean, maintainable code
✓ Extensible for future products
