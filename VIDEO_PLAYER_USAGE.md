# Video Player Integration for Help Site

The help site has its own standalone video player that works independently from the main videos site.

## Features

- ✅ Self-contained (no dependencies on main site code)
- ✅ YouTube iframe scaling to hide "More videos" overlay
- ✅ Custom controls with play/pause, progress bar, fullscreen
- ✅ Optional video cover with click-to-play
- ✅ Fetches video metadata from main site API
- ✅ Multiple videos on same page support
- ✅ Responsive design
- ✅ No external CSS dependencies (inline styles)

## Basic Usage

```php
<?php
require_once __DIR__ . '/includes/video-player.php';

// Simple video
render_help_video('dQw4w9WgXcQ');
?>
```

## With Options

```php
<?php
render_help_video('dQw4w9WgXcQ', [
    'autoplay' => false,      // Auto-start playback
    'show_cover' => true,     // Show thumbnail cover
    'width' => '100%',        // Container width
    'max_width' => '900px'    // Maximum width
]);
?>
```

## Example: In a Documentation Page

Create a file `/help/content/docs/tutorials/example.php`:

```php
<?php
require_once __DIR__ . '/../../../../config.php';
require_once __DIR__ . '/../../../../includes/video-player.php';

$pageTitle = "Video Tutorial Example";
$pageDescription = "Learn how to use this feature";

include __DIR__ . '/../../../../includes/header.php';
?>

<div class="doc-content">
    <h1><?php echo $pageTitle; ?></h1>

    <p>Watch this video to learn how to use this feature:</p>

    <?php render_help_video('wK7Z-IqFF9Y', [
        'max_width' => '800px'
    ]); ?>

    <h2>Step-by-Step Guide</h2>
    <p>After watching the video, follow these steps...</p>
</div>

<?php include __DIR__ . '/../../../../includes/footer.php'; ?>
```

## Example: Multiple Videos

```php
<?php
require_once __DIR__ . '/includes/video-player.php';
?>

<h2>Part 1: Introduction</h2>
<?php render_help_video('video1'); ?>

<h2>Part 2: Advanced Features</h2>
<?php render_help_video('video2'); ?>

<h2>Part 3: Tips & Tricks</h2>
<?php render_help_video('video3'); ?>
```

## How It Works

1. **Standalone Component**: All CSS is inline, no external dependencies
2. **YouTube API**: Fetches video metadata from `https://electricks.info/videos/api/video-title.php`
3. **IFrame Scaling**: Uses the same 180% height trick to hide YouTube's UI
4. **Isolated JavaScript**: Each video gets unique IDs, no conflicts
5. **Auto-initialization**: YouTube IFrame API loads automatically

## Configuration

The component connects to the main site API at:
```
https://electricks.info/videos/api/video-title.php?v=VIDEO_ID
```

Change the domain in `/help/includes/video-player.php` line 32:
```php
$main_site_url = 'https://electricks.info'; // Change to actual domain
```

## Benefits Over Regular YouTube Embed

- ✅ No "More videos" overlay when paused
- ✅ Cleaner look with custom controls
- ✅ Consistent with main site design
- ✅ Better user experience
- ✅ Click-to-play with thumbnail cover
- ✅ Shows video title and description

## Browser Support

Works in all modern browsers:
- Chrome/Edge
- Firefox
- Safari
- Mobile browsers

## Notes

- Video ID is the YouTube video ID (11 characters)
- Cover images are fetched from YouTube CDN
- The player automatically handles API loading
- Each player is fully isolated from others on the page
