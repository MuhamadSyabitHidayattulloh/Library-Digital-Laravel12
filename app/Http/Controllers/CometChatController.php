<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CometChatController extends Controller
{
    private $appId = "276779a773176e9b";
    private $apiKey = "f27128a72c963e6278a0fc1abb848000ba93704a";
    private $region = "US";

    public function getAuthToken()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Create CometChat user if not exists
        $response = Http::withHeaders([
            'apiKey' => $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post("https://{$this->region}.api-us.cometchat.io/v3/users", [
            'uid' => (string) $user->id,
            'name' => $user->name,
            'role' => $user->role
        ]);

        // Generate auth token
        $tokenResponse = Http::withHeaders([
            'apiKey' => $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post("https://{$this->region}.api-us.cometchat.io/v3/users/{$user->id}/auth_tokens", []);

        if ($tokenResponse->successful()) {
            return response()->json([
                'token' => $tokenResponse->json()['data']['authToken']
            ]);
        }

        return response()->json(['error' => 'Failed to generate token'], 500);
    }
}
