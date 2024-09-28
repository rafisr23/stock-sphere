<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class APIsController extends Controller
{
    public function getAllProvince()
    {
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

    public function getAllCity(Request $request)
    {
        $provinceId = $request->province_id;

        $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/regencies/' . $provinceId . '.json';

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            return response()->json([
                'city' => $data,
            ]);
        } else {
            return response()->json(['error' => 'Failed to fetch data from API'], 500);
        }
    }

    public function getAllDistrict(Request $request)
    {
        $cityId = $request->city_id;

        $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/districts/' . $cityId . '.json';

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            return response()->json([
                'district' => $data,
            ]);
        } else {
            return response()->json(['error' => 'Failed to fetch data from API'], 500);
        }
    }

    public function getAllVillage(Request $request)
    {
        $districtId = $request->district_id;

        $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/villages/' . $districtId . '.json';

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            return response()->json([
                'village' => $data,
            ]);
        } else {
            return response()->json(['error' => 'Failed to fetch data from API'], 500);
        }
    }

    public function getProvince($province_id)
    {
        $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/province/' . $province_id . '.json';

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

    public function getCity($city_id)
    {
        $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/regency/' . $city_id . '.json';

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            return response()->json([
                'city' => $data,
            ]);
        } else {
            return response()->json(['error' => 'Failed to fetch data from API'], 500);
        }
    }

    public function getDistrict($district_id)
    {
        $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/district/' . $district_id . '.json';

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            return response()->json([
                'district' => $data,
            ]);
        } else {
            return response()->json(['error' => 'Failed to fetch data from API'], 500);
        }
    }

    public function getVillage($village_id)
    {
        $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/village/' . $village_id . '.json';

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            return response()->json([
                'village' => $data,
            ]);
        } else {
            return response()->json(['error' => 'Failed to fetch data from API'], 500);
        }
    }
}
