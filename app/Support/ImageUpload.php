<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Central place for writing and deleting uploaded images.
 *
 * Every controller that accepts image uploads goes through here so the
 * filesystem target is decided in one spot (config/media.php) rather than
 * hard-coded to public_path() — which breaks on hosts where the web
 * document root is a separate directory from the Laravel checkout.
 */
class ImageUpload
{
    /** Absolute base directory uploads are written to. */
    public static function basePath(): string
    {
        return rtrim(config('media.upload_path'), '/\\');
    }

    /** Public-relative prefix stored on the model and resolved by asset(). */
    public static function urlPrefix(): string
    {
        return trim(config('media.url_prefix'), '/');
    }

    /**
     * Move an uploaded file into the media directory (optionally a subfolder
     * such as "products" or "vendors") and return the public-relative path
     * to persist on the model, e.g. "assets/img/1788_0_photo.jpg".
     */
    public static function store(UploadedFile $file, string $subdir = '', int $index = 0): string
    {
        $subdir = trim($subdir, '/\\');
        $dir    = self::basePath() . ($subdir !== '' ? DIRECTORY_SEPARATOR . $subdir : '');

        if (! is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $filename = time() . '_' . $index . '_' . self::safeName($file);
        $file->move($dir, $filename);

        return self::urlPrefix() . '/' . ($subdir !== '' ? $subdir . '/' : '') . $filename;
    }

    /**
     * Delete a file previously stored via store(), given the public-relative
     * path held on the model. No-op if the path is empty or outside the
     * configured media directory.
     */
    public static function delete(?string $imagePath): void
    {
        if (! $imagePath) {
            return;
        }

        $prefix = self::urlPrefix() . '/';

        if (! str_starts_with($imagePath, $prefix)) {
            return;
        }

        $relative = str_replace(['..', '\\'], ['', '/'], substr($imagePath, strlen($prefix)));
        $full     = self::basePath() . DIRECTORY_SEPARATOR . ltrim($relative, '/');

        if (is_file($full)) {
            @unlink($full);
        }
    }

    private static function safeName(UploadedFile $file): string
    {
        $original  = basename($file->getClientOriginalName());
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'bin');
        $stem      = pathinfo($original, PATHINFO_FILENAME);
        $stem      = preg_replace('/[^A-Za-z0-9._-]+/', '_', $stem);
        $stem      = trim($stem, '._-') ?: Str::random(8);

        return Str::limit($stem, 60, '') . '.' . $extension;
    }
}
