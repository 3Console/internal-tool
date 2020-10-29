<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Translate\V2\TranslateClient;

class TranslatorController extends Controller
{
    public function translate(Request $request) {
        $text = array_get($request, 'text') ?? '';
        $translate = new TranslateClient([
            'key' => env('GOOGLE_TRANSLATE_KEY')
        ]);
        
        // Translate text from english to french.
        $result = $translate->translate($text, [
            'target' => 'vi'
        ]);
        
        echo $result['text'] . "\n";
        
    }
}
