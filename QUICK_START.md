# Help Portal - Quick Start Guide

## 🎉 What's New

Your Electricks Help Center now features:

✨ **Animated hero** with floating knowledge particles (books, lightbulbs, sparks)
🟣 **Purple theme** matching the developer portal aesthetic
🔍 **Prominent search bar** with live results and keyboard shortcuts
📦 **Larger category icons** (72px) with beautiful hover effects
📱 **Fully responsive** design for all devices

---

## 🚀 View Your New Design

### Start Local Server

```bash
cd /Users/boogie/Workspace/electricks-site/help
php -S localhost:8080 router.php
```

### Open in Browser

```
http://localhost:8080
```

You should see:
1. **Purple animated hero** with floating particles
2. **Large centered search bar** with ⌘K shortcut
3. **Colorful category cards** with 72px icons
4. **Featured articles grid** with read times
5. **Purple CTA section** at the bottom

---

## 🎨 Design Highlights

### Hero Section
- Deep purple gradient background (indigo → purple)
- Animated floating particles (books, lightbulbs, sparks, questions, gears)
- Large centered title: "How can we **help you?**"
- Prominent search bar (650px wide)
- Popular search tags below search

### Category Cards
- **8 categories** displayed in responsive grid
- **72×72px icons** with colored backgrounds
- Smooth hover effects (lift + glow + icon rotation)
- Article count in footer
- Purple-pink gradient top border on hover

### Search Features
- Live search with dropdown results
- Keyboard shortcut: **⌘K** (Mac) or **Ctrl+K** (Windows)
- Debounced for performance (300ms)
- Highlighted search terms in results
- Press **Escape** to close

### Colors
```
Primary Purple:  #9333ea
Purple Light:    #a855f7
Indigo Dark:     #1e1b4b
Indigo Medium:   #312e81
Pink Accent:     #ec4899
```

---

## 📁 New Files

```
help/
├── assets/
│   ├── css/
│   │   └── help-theme.css          ← 650 lines of purple theme CSS
│   └── js/
│       ├── knowledge-animation.js  ← Floating particles animation
│       └── home-search.js          ← Search functionality
├── index.php                        ← Completely redesigned homepage
└── DESIGN_UPDATES.md               ← Full design documentation
```

---

## 🔧 Customization

### Change Animation Colors

Edit `assets/js/knowledge-animation.js`:

```javascript
// Line ~140: Change particle colors
this.drawBook(ctx); // Purple books
this.drawLightbulb(ctx); // Yellow bulbs
this.drawSpark(ctx); // Pink sparks
```

### Change Theme Colors

Edit `assets/css/help-theme.css`:

```css
:root {
    --purple-600: #9333ea;  /* Primary color */
    --indigo-900: #1e1b4b;  /* Dark background */
    /* ... modify as needed */
}
```

### Add More Categories

Edit `config.php` in the `$NAVIGATION` array:

```php
'new-category' => [
    'title' => 'New Category',
    'description' => 'Description here',
    'icon' => 'star',
    'icon_color' => 'blue',
    'items' => [
        'article-1' => 'Article Name',
    ]
]
```

### Adjust Animation Speed

Edit `assets/js/knowledge-animation.js`, line ~18:

```javascript
this.speed = 0.2 + Math.random() * 0.5; // Make faster or slower
```

---

## 📱 Responsive Design

### Desktop (> 1024px)
- Hero: 600px height
- Categories: 3+ columns
- Articles: 3 columns
- Full search: 650px wide

### Tablet (768px - 1024px)
- Hero: 600px height
- Categories: 2 columns
- Articles: 2 columns
- Search: 100% width

### Mobile (< 768px)
- Hero: 500px height
- Categories: 1 column
- Articles: 1 column
- Search: Full width
- Stacked CTA buttons

---

## 🎯 Key Features

### Search Functionality
- **Endpoint**: `/api/search?q=query`
- **Minimum**: 2 characters
- **Debounce**: 300ms delay
- **Shortcuts**: ⌘K / Ctrl+K to focus, Escape to close

### Animation
- **Canvas-based**: 60fps smooth animation
- **Particle types**: 5 different shapes
- **Auto-scaling**: Adjusts to viewport size
- **Performance**: GPU-accelerated

### Category Cards
- **Hover effects**: Lift, glow, rotate icon
- **Color coding**: Each category has unique color
- **Clickable**: Navigate to first article
- **Stats**: Shows article count

---

## 🐛 Troubleshooting

### Animation Not Showing
- Check browser console for errors
- Verify `knowledge-animation.js` is loading
- Make sure canvas element has ID `knowledgeCanvas`

### Search Not Working
- Verify `/api/search.php` endpoint exists
- Check network tab for API errors
- Ensure proper CORS headers

### Styles Not Applied
- Clear browser cache (Cmd+Shift+R / Ctrl+Shift+R)
- Check `help-theme.css` is loading
- Verify CSS file path is correct

### Icons Not Showing
- Phosphor Icons CDN must be accessible
- Check `<script src="https://unpkg.com/@phosphor-icons/web@2.0.3"></script>`
- Try loading page without ad blockers

---

## 🚀 Deployment Checklist

Before going live:

- [ ] Test search functionality
- [ ] Verify all links work
- [ ] Check mobile responsiveness
- [ ] Test on multiple browsers
- [ ] Validate HTML/CSS
- [ ] Check page load speed
- [ ] Enable HTTPS
- [ ] Set up monitoring
- [ ] Create 301 redirects from old URLs
- [ ] Update main site links

---

## 📊 Performance

### Target Metrics
- Page load: < 2 seconds
- Animation: 60fps
- Search response: < 500ms
- Lighthouse score: > 90

### Optimization Tips
- Use CDN for assets
- Enable Gzip compression
- Minify CSS/JS (optional)
- Optimize images
- Cache static assets

---

## 💡 Pro Tips

1. **Test Search**: Type "peeksmith" to see live results
2. **Try Keyboard Shortcut**: Press ⌘K anywhere on page
3. **Hover Categories**: Watch icons rotate and lift
4. **Mobile View**: Check DevTools responsive mode
5. **Watch Animation**: Notice particles float and pulse

---

## 📚 Documentation

- **Full Design Docs**: `DESIGN_UPDATES.md`
- **Deployment Guide**: `DEPLOYMENT.md`
- **Project README**: `README.md`
- **Dev Portal**: Compare with `../developers/`

---

## 🎨 Design Philosophy

The new design emphasizes:

1. **Knowledge & Learning**: Visual metaphors (books, lightbulbs)
2. **Ease of Use**: Prominent search, clear categories
3. **Brand Consistency**: Purple theme matches dev portal
4. **Modern Aesthetic**: Smooth animations, clean cards
5. **Accessibility**: High contrast, keyboard navigation

---

## 🆘 Need Help?

- **Issues**: Check browser console for errors
- **Questions**: Review `DESIGN_UPDATES.md`
- **Bugs**: Check `help/README.md` troubleshooting
- **Custom**: Edit CSS variables in `help-theme.css`

---

## ✨ What's Next?

Consider adding:

1. Dark mode toggle
2. Search autocomplete
3. Trending articles section
4. User feedback widget
5. Chat support integration
6. Video tutorials
7. Interactive device demos

---

**Enjoy your new Help Portal!** 🎉

The design is modern, functional, and ready for your users.
