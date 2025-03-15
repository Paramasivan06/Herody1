<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class GameController extends Controller
{
    public function fetchGames()
    {
        $propertyId = '9790'; // Your Property ID
        $lang = 'en'; // Language
        $url = "https://pub.gamezop.com/v3/games?id={$propertyId}&lang={$lang}";

        $client = new Client();

        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            // Return only the "games" array from the API response
            return response()->json($data['games'] ?? [], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch games'], 500);
        }
    }
}
