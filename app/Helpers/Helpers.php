<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

if (! function_exists('getAllProvince')) {
    function getAllProvince()
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
}

if (! function_exists('getAllCity')) {
    function getAllCity($provinceId)
    {
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
}

if (! function_exists('getAllDistrict')) {
    function getAllDistrict($cityId)
    {
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
}

if (! function_exists('getAllVillage')) {
    function getAllVillage($districtId)
    {
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
}

// if (! function_exists('getAllCity2')) {
//     function getAllCity2($provinceId)
//     {
//         $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/regencies/' . $provinceId . '.json';

//         $response = Http::get($apiUrl);

//         if ($response->successful()) {
//             $data = $response->json();

//             return response()->json([
//                 'city' => $data,
//             ]);
//         } else {
//             return response()->json(['error' => 'Failed to fetch data from API'], 500);
//         }
//     }
// }

// if (! function_exists('getAllDistrict2')) {
//     function getAllDistrict2($cityId)
//     {
//         $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/districts/' . $cityId . '.json';

//         $response = Http::get($apiUrl);

//         if ($response->successful()) {
//             $data = $response->json();

//             return response()->json([
//                 'district' => $data,
//             ]);
//         } else {
//             return response()->json(['error' => 'Failed to fetch data from API'], 500);
//         }
//     }
// }

// if (! function_exists('getAllVillage2')) {
//     function getAllVillage2($districtId)
//     {

//         $apiUrl = 'https://dzaki-abd.github.io/api-wilayah-indonesia/api/villages/' . $districtId . '.json';

//         $response = Http::get($apiUrl);

//         if ($response->successful()) {
//             $data = $response->json();

//             return response()->json([
//                 'village' => $data,
//             ]);
//         } else {
//             return response()->json(['error' => 'Failed to fetch data from API'], 500);
//         }
//     }
// }

if (! function_exists('getProvince')) {
    function getProvince($province_id)
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
}

if (! function_exists('getCity')) {
    function getCity($city_id)
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
}

if (! function_exists('getDistrict')) {
    function getDistrict($district_id)
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
}

if (! function_exists('getVillage')) {
    function getVillage($village_id)
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

if (! function_exists('deleteUploadedFileImage')) {
    function deleteUploadedFileImage($fileName, $path)
    {
        $filePath = public_path($path . '/' . $fileName);

        if (File::exists($filePath)) {
            File::delete($filePath);
            return response()->json(['success' => 'File removed successfully.']);
        }

        return response()->json(['error' => 'File not found.'], 404);
    }
}
