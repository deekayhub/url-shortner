<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLinks;

class UrlShortnerController extends Controller
{

    protected function validateUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
    public function shorten(Request $request)
    {
        $url = $request->input('url');
        if(!$url || !$this->validateUrl($url)){
            return response()->json([
                'status' => 'error',
                'message' => 'Please enter a valid URL.',
            ], 400);
        }
        $shortCode = substr(md5(uniqid()), 6, 8);
        $shorturl = url('u/' . $shortCode);

        $duplicateUrl = ShortLinks::where('original_url', $url)->where('expires_at', '>', now())->first();
        if($duplicateUrl){
            return response()->json([
                'status' => 'success',
                'short_url' => $duplicateUrl->short_url,
                'message' => 'Short URL already exists!',
            ], 200);
        }

        $storeLink = ShortLinks::create([
            'original_url' => $url,
            'short_code' => $shortCode,
            'short_url' => $shorturl,
            'expires_at' => now()->addMinutes(15),
        ]);
        if($storeLink){
            return response()->json([
                'status' => 'success',
                'short_url' => $shorturl,
                'message' => 'Short URL created successfully!',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create short URL. Please try again.',
            ], 500);
        }
    }

    public function redirect($code){
        if(!$code){
            return redirect()->route('home')->with('error', 'Invalid short URL code.');
        }
        $originalLink = ShortLinks::where('short_code', $code)->first();
        if($originalLink){
            if($originalLink->expires_at && $originalLink->expires_at->isPast()){
                return redirect()->route('home')->with('error', 'This short URL has expired.');
            }
            return redirect()->away($originalLink->original_url);
        } else {
            return redirect()->route('home')->with('error', 'Short URL not found.');
        }
    }
}
