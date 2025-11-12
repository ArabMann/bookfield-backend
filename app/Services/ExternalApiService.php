<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalApiService
{
    public function getApi($categories)
    {
        if(Auth::check()){
            try {
                $response = Http::timeout(5)->get('http://127.0.0.1:8000/api/'.$categories);
    
                if ($response->failed()) {
                    Log::error('API Error: ' . $response->status() . ' - ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('API Down/Error: ' . $e->getMessage());
            }
        }
    }
}
