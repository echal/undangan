<?php

namespace App\Services;

use App\Models\Announcement;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Typography\FontFactory;

class OpenGraphImageService
{
    private ImageManager $manager;
    private string $fontPath;
    private string $outputDir;

    public function __construct()
    {
        $this->manager   = new ImageManager(new Driver());
        $this->fontPath  = public_path('fonts/Inter-Bold.ttf');
        $this->outputDir = storage_path('app/public/og');
    }

    public function generate(Announcement $announcement): string
    {
        if (! is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0755, true);
        }

        $design   = $announcement->design_settings ?? [];
        $category = $announcement->theme?->category ?? 'maintenance';

        // Background color per category
        $bgHex = $design['background_color']
            ?? ($category === 'event' ? '#111827' : '#0f172a');

        // Primary / accent color
        $primaryHex = $design['primary_color']
            ?? ($category === 'event' ? '#d97706' : '#3b82f6');

        // Text color
        $textHex = $design['text_color'] ?? '#f8fafc';

        // Severity
        $severityColor = match ($announcement->severity) {
            'critical' => '#ef4444',
            'warning'  => '#f59e0b',
            default    => $primaryHex,
        };
        $severityLabel = match ($announcement->severity) {
            'critical' => '● GANGGUAN KRITIS',
            'warning'  => '● GANGGUAN SEBAGIAN',
            default    => '● PEMBERITAHUAN',
        };

        // Heading
        $heading = $design['heading'] ?? $announcement->title;

        // Create canvas via native GD (Intervention v3 canvas approach)
        $img = $this->manager->create(1200, 630);

        // --- Background ---
        $img->fill($this->hexToRgb($bgHex));

        // --- Decorative ellipse top-right ---
        $img->drawEllipse(1100, 100, function ($draw) use ($primaryHex) {
            $draw->size(520, 320);
            $draw->background($this->hexToRgba($primaryHex, 0.07));
        });

        // --- Accent bar bottom 4px ---
        $img->drawRectangle(0, 626, function ($draw) use ($primaryHex) {
            $draw->size(1200, 4);
            $draw->background($primaryHex);
        });

        // --- UNDIGI label top-left ---
        $img->text('UNDIGI', 60, 62, function (FontFactory $font) {
            $font->filename($this->fontPath);
            $font->size(14);
            $font->color($this->hexToRgba('#94a3b8', 0.6));
            $font->align('left');
            $font->valign('top');
        });

        // --- Severity label ---
        $img->text($severityLabel, 60, 200, function (FontFactory $font) use ($severityColor) {
            $font->filename($this->fontPath);
            $font->size(18);
            $font->color($severityColor);
            $font->align('left');
            $font->valign('top');
        });

        // --- Heading (max 2 lines, 44 chars/baris) ---
        $lines = $this->wrapText($heading, 44);
        $y = 260;
        foreach (array_slice($lines, 0, 2) as $line) {
            $img->text($line, 60, $y, function (FontFactory $font) use ($textHex) {
                $font->filename($this->fontPath);
                $font->size(52);
                $font->color($textHex);
                $font->align('left');
                $font->valign('top');
            });
            $y += 68;
        }

        // --- Date ---
        $dateStr = $announcement->starts_at
            ? $announcement->starts_at->isoFormat('D MMMM YYYY')
            : now()->isoFormat('D MMMM YYYY');

        $img->text($dateStr, 60, $y + 20, function (FontFactory $font) use ($textHex) {
            $font->filename($this->fontPath);
            $font->size(20);
            $font->color($this->hexToRgba($textHex, 0.45));
            $font->align('left');
            $font->valign('top');
        });

        // --- APP_URL bottom-right ---
        $appUrl = rtrim(str_replace('https://', '', str_replace('http://', '', config('app.url'))), '/');
        $img->text($appUrl, 1140, 590, function (FontFactory $font) use ($textHex) {
            $font->filename($this->fontPath);
            $font->size(14);
            $font->color($this->hexToRgba($textHex, 0.30));
            $font->align('right');
            $font->valign('bottom');
        });

        // --- Save ---
        $filename = $announcement->slug . '.jpg';
        $img->toJpeg(90)->save($this->outputDir . '/' . $filename);

        return 'storage/og/' . $filename;
    }

    private function wrapText(string $text, int $maxChars): array
    {
        $words  = explode(' ', $text);
        $lines  = [];
        $current = '';

        foreach ($words as $word) {
            $test = $current === '' ? $word : $current . ' ' . $word;
            if (mb_strlen($test) <= $maxChars) {
                $current = $test;
            } else {
                if ($current !== '') {
                    $lines[] = $current;
                }
                $current = $word;
            }
        }

        if ($current !== '') {
            $lines[] = $current;
        }

        return $lines;
    }

    /** Convert hex color to [r, g, b] string for Intervention fill */
    private function hexToRgb(string $hex): string
    {
        $hex = ltrim($hex, '#');
        $r   = hexdec(substr($hex, 0, 2));
        $g   = hexdec(substr($hex, 2, 2));
        $b   = hexdec(substr($hex, 4, 2));

        return "rgb($r, $g, $b)";
    }

    /** Convert hex + alpha (0.0–1.0) to rgba string */
    private function hexToRgba(string $hex, float $alpha = 1.0): string
    {
        $hex = ltrim($hex, '#');
        $r   = hexdec(substr($hex, 0, 2));
        $g   = hexdec(substr($hex, 2, 2));
        $b   = hexdec(substr($hex, 4, 2));

        return "rgba($r, $g, $b, $alpha)";
    }
}
