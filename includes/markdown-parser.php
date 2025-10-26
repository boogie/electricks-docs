<?php
/**
 * Markdown Parser with Enhanced Features
 * Wraps Parsedown with custom features for code highlighting and navigation
 */

require_once BASE_PATH . '/vendor/parsedown/Parsedown.php';

class ElectricksMarkdownParser extends Parsedown {

    /**
     * Override blockFencedCodeComplete to prevent leading/trailing whitespace
     */
    protected function blockFencedCodeComplete($Block)
    {
        // Call parent implementation
        $Block = parent::blockFencedCodeComplete($Block);

        // Remove leading/trailing whitespace from code content
        if (isset($Block['element']['element']['text'])) {
            $Block['element']['element']['text'] = trim($Block['element']['element']['text']);
        }

        return $Block;
    }

    /**
     * Parse markdown file and return HTML
     */
    public static function parseFile($filePath) {
        if (!file_exists($filePath)) {
            return null;
        }

        $markdown = file_get_contents($filePath);
        $parser = new self();

        // Enable line breaks
        $parser->setBreaksEnabled(true);

        // Apply typographic improvements before parsing
        $markdown = self::improveTypography($markdown);

        return $parser->text($markdown);
    }

    /**
     * Improve typography by replacing straight quotes, dashes, etc.
     * with proper typographic characters
     */
    public static function improveTypography($text) {
        // Define typographic characters
        $ldquo = "\u{201C}"; // Left double quote "
        $rdquo = "\u{201D}"; // Right double quote "
        $lsquo = "\u{2018}"; // Left single quote '
        $rsquo = "\u{2019}"; // Right single quote '
        $mdash = "\u{2014}"; // Em dash —
        $hellip = "\u{2026}"; // Ellipsis …
        $times = "\u{00D7}"; // Multiplication ×
        $copy = "\u{00A9}"; // Copyright ©
        $reg = "\u{00AE}"; // Registered ®
        $trade = "\u{2122}"; // Trademark ™

        // Protect front matter, code blocks and inline code from replacements
        $frontMatter = null;
        $codeBlocks = [];
        $inlineCode = [];

        // Extract and protect YAML front matter
        if (preg_match('/^---\s*\n(.*?)\n---\s*\n/s', $text, $matches)) {
            $frontMatter = $matches[0];
            $text = preg_replace('/^---\s*\n.*?\n---\s*\n/s', '___FRONT_MATTER___', $text, 1);
        }

        // Extract and protect fenced code blocks
        $text = preg_replace_callback('/```[\s\S]*?```/', function($matches) use (&$codeBlocks) {
            $placeholder = '___CODE_BLOCK_' . count($codeBlocks) . '___';
            $codeBlocks[$placeholder] = $matches[0];
            return $placeholder;
        }, $text);

        // Extract and protect inline code
        $text = preg_replace_callback('/`[^`]+`/', function($matches) use (&$inlineCode) {
            $placeholder = '___INLINE_CODE_' . count($inlineCode) . '___';
            $inlineCode[$placeholder] = $matches[0];
            return $placeholder;
        }, $text);

        // Em-dashes: -- becomes —
        $text = str_replace('--', $mdash, $text);

        // Ellipsis: ... becomes …
        $text = str_replace('...', $hellip, $text);

        // Multiplication sign: 2x3 becomes 2×3
        $text = preg_replace('/(\d+)\s*x\s*(\d+)/i', '$1' . $times . '$2', $text);

        // Copyright, Registered, Trademark
        $text = str_replace(['(c)', '(C)'], $copy, $text);
        $text = str_replace(['(r)', '(R)'], $reg, $text);
        $text = str_replace(['(tm)', '(TM)'], $trade, $text);

        // Smart quotes - double quotes
        // Opening double quote after whitespace or at start
        $text = preg_replace('/(\s|^)"/', '$1' . $ldquo, $text);
        // Closing double quote before whitespace, punctuation, or at end
        $text = preg_replace('/"(\s|[.,;:!?]|$)/', $rdquo . '$1', $text);
        // Any remaining " becomes closing quote
        $text = str_replace('"', $rdquo, $text);

        // Smart quotes - single quotes (apostrophes and quotes)
        // Common contractions and possessives - use right single quote
        $text = preg_replace("/(\w)'(\w)/", '$1' . $rsquo . '$2', $text); // can't, don't, it's
        $text = preg_replace("/(\w)'s\b/", '$1' . $rsquo . 's', $text);   // possessive

        // Opening single quote after whitespace or at start
        $text = preg_replace("/(\s|^)'/", '$1' . $lsquo, $text);
        // Closing single quote before whitespace, punctuation, or at end
        $text = preg_replace("/'(\s|[.,;:!?]|$)/", $rsquo . '$1', $text);
        // Any remaining ' becomes right single quote (apostrophe)
        $text = str_replace("'", $rsquo, $text);

        // Restore front matter
        if ($frontMatter !== null) {
            $text = str_replace('___FRONT_MATTER___', $frontMatter, $text);
        }

        // Restore code blocks
        foreach ($codeBlocks as $placeholder => $code) {
            $text = str_replace($placeholder, $code, $text);
        }

        // Restore inline code
        foreach ($inlineCode as $placeholder => $code) {
            $text = str_replace($placeholder, $code, $text);
        }

        return $text;
    }

    /**
     * Extract table of contents from markdown
     */
    public static function extractTOC($filePath) {
        if (!file_exists($filePath)) {
            return [];
        }

        $markdown = file_get_contents($filePath);
        $toc = [];

        // Match all headers (# Header, ## Header, etc.)
        preg_match_all('/^(#{1,6})\s+(.+)$/m', $markdown, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $level = strlen($match[1]);
            $title = trim($match[2]);
            $id = self::slugify($title);

            $toc[] = [
                'level' => $level,
                'title' => $title,
                'id' => $id
            ];
        }

        return $toc;
    }

    /**
     * Extract front matter (if present)
     */
    public static function extractFrontMatter($filePath) {
        if (!file_exists($filePath)) {
            return [];
        }

        $content = file_get_contents($filePath);

        // Check for YAML front matter
        if (preg_match('/^---\s*\n(.*?)\n---\s*\n/s', $content, $matches)) {
            $yaml = $matches[1];
            $frontMatter = [];

            // Simple YAML parser for basic key: value pairs
            preg_match_all('/^(\w+):\s*(.+)$/m', $yaml, $pairs, PREG_SET_ORDER);

            foreach ($pairs as $pair) {
                $key = $pair[1];
                $value = trim($pair[2], '"\'');
                $frontMatter[$key] = $value;
            }

            return $frontMatter;
        }

        return [];
    }

    /**
     * Get markdown content without front matter
     */
    public static function getContentWithoutFrontMatter($filePath) {
        if (!file_exists($filePath)) {
            return '';
        }

        $content = file_get_contents($filePath);

        // Remove YAML front matter if present
        $content = preg_replace('/^---\s*\n.*?\n---\s*\n/s', '', $content);

        return $content;
    }

    /**
     * Create slug from title
     */
    private static function slugify($text) {
        // Handle null or empty input
        if (empty($text) || $text === null) {
            return 'n-a';
        }

        // Replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // Transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // Trim
        $text = trim($text, '-');

        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // Lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * Override code block rendering to add language class
     */
    protected function blockFencedCode($Line) {
        $Block = parent::blockFencedCode($Line);

        if (isset($Block)) {
            $Block['element']['attributes']['class'] = 'language-' . ($Block['language'] ?? 'plaintext');
        }

        return $Block;
    }

    /**
     * Add IDs to headers for anchor links
     */
    protected function blockHeader($Line) {
        $Block = parent::blockHeader($Line);

        if (isset($Block) && isset($Block['element']['text'])) {
            $text = $Block['element']['text'];
            $id = self::slugify($text);
            $Block['element']['attributes']['id'] = $id;
        }

        return $Block;
    }
}
