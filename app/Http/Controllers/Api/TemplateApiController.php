<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\JsonResponse;

class TemplateApiController extends Controller
{
    public function byEventType(string $eventType): JsonResponse
    {
        $allowed = ['pernikahan', 'buka_puasa', 'workshop'];

        if (! in_array($eventType, $allowed, true)) {
            return response()->json([]);
        }

        $templates = Template::active()
            ->byEventType($eventType)
            ->orderBy('name')
            ->get(['id', 'name', 'preview_image']);

        return response()->json($templates);
    }
}
