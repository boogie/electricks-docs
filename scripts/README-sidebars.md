# Sidebar Management Scripts

This directory contains scripts to manage reusable sidebars for the help site.

## Scripts

### 1. `crawl-sidebars.py`
Extracts sidebar structure from a specific electricks.info page.

**Usage:**
```bash
cd scripts
python3 crawl-sidebars.py <url> [sidebar_id]
```

**Example:**
```bash
python3 crawl-sidebars.py https://electricks.info/docs/sbwatch/ 6bc33bd
```

**What it does:**
- Fetches the specified URL
- Extracts the sidebar element with the given ID
- Parses the structure (headings, links, icons)
- Saves to `sidebars.json`

---

### 2. `discover-sidebars.py`
Discovers all unique sidebars across multiple documentation pages.

**Usage:**
```bash
cd scripts
python3 discover-sidebars.py [urls...]
```

**Example:**
```bash
python3 discover-sidebars.py https://electricks.info/docs/sbwatch/ https://electricks.info/docs/quantum/
```

**What it does:**
- Crawls multiple documentation pages
- Finds all sidebar elements (by data-id)
- Extracts unique sidebar structures
- Saves all sidebars to `sidebars.json`

**Default pages crawled (if no URLs provided):**
- SB Watch
- SB Watch 2
- PeekSmith 3
- Quantum
- Teleport
- TimeSmith App

---

### 3. `add-sidebar-meta.py`
Adds sidebar metadata to markdown files.

**Usage:**
```bash
cd scripts
python3 add-sidebar-meta.py <directory> <sidebar_id>
```

**Example:**
```bash
python3 add-sidebar-meta.py ../content/docs/docs/sbwatch 6bc33bd
```

**What it does:**
- Scans all `.md` files in the directory
- Adds `sidebar: "sidebar_id"` to frontmatter
- Skips files that already have sidebar metadata

---

## Workflow

### Adding a new sidebar from electricks.info:

1. **Discover sidebar ID:**
   - Inspect the page on electricks.info
   - Find the sidebar element's `data-id` attribute
   - Example: `data-id="6bc33bd"`

2. **Extract the sidebar:**
   ```bash
   cd scripts
   python3 crawl-sidebars.py https://electricks.info/docs/sbwatch/ 6bc33bd
   ```

3. **Add sidebar to pages:**
   ```bash
   python3 add-sidebar-meta.py ../content/docs/docs/sbwatch 6bc33bd
   ```

4. **Verify:**
   - Check `sidebars.json` was updated
   - Visit local site to see the sidebar

### Discovering all sidebars at once:

```bash
cd scripts
python3 discover-sidebars.py
```

This will crawl all major product pages and extract all unique sidebars.

---

## File Structure

```
help/
├── sidebars.json              # Central sidebar definitions
├── content/docs/docs/
│   ├── sbwatch/
│   │   ├── troubleshooting.md (sidebar: "6bc33bd")
│   │   └── ...
│   └── quantum/
│       └── ...
└── scripts/
    ├── crawl-sidebars.py      # Extract single sidebar
    ├── discover-sidebars.py   # Discover all sidebars
    └── add-sidebar-meta.py    # Add metadata to files
```

---

## sidebars.json Format

```json
{
  "6bc33bd": {
    "id": "6bc33bd",
    "name": "SB Watch Documentation Sidebar",
    "sections": [
      {
        "heading": "General",
        "links": [
          {
            "icon": "📃",
            "text": "First Steps",
            "url": "/docs/sbwatch/",
            "highlight": true
          }
        ]
      }
    ]
  }
}
```

---

## Requirements

```bash
pip install requests beautifulsoup4
```
