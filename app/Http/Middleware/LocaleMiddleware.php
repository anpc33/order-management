<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Đặt ngôn ngữ mặc định là tiếng Anh
        $locale = session('locale', 'en');

        // Kiểm tra ngôn ngữ có hợp lệ không
        if (!in_array($locale, ['en', 'vi', 'zh'])) {
            $locale = 'en';
        }

        app()->setLocale($locale);
        return $next($request);
    }
}
