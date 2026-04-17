<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Template::where('is_active', true)->orderBy('sort_order');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        return response()->json(['data' => $query->get()]);
    }

    public function show(Template $template): JsonResponse
    {
        return response()->json(['data' => $template]);
    }

    public function apply(Request $request, Store $store, Template $template): JsonResponse
    {
        $store->update([
            'store_config' => $template->store_config,
            'theme_code'   => $template->slug,
        ]);

        return response()->json([
            'message' => 'تم تطبيق القالب بنجاح',
            'data'    => $store,
        ]);
    }
}
