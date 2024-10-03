<?php 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

if (! function_exists('getAllProvince')) {
    function getAllProvince() {
        $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/provinces.json';

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            return response()->json([
                'province' => $data,
            ]);
        } else {
            return response()->json(['error' => 'Failed to fetch data from API'], 500);
        }
    }
}

?>