<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        // Kiểm tra ngôn ngữ có hợp lệ không
        if (in_array($lang, ['en', 'vi', 'zh'])) {
            session()->put('locale', $lang);
            app()->setLocale($lang);
        }

        return redirect()->back();
    }
}
