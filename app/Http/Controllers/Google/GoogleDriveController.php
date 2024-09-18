<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use Illuminate\Console\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use \Illuminate\Contracts\Foundation\Application as Apple;
use GuzzleHttp\Client;

class GoogleDriveController extends Controller
{

    // Backend Endpoint for Authorization Request
    public function redirectToGoogleDriveAuthorization(): Application|Redirector|RedirectResponse|Apple
    {
        $googleClientID = env('GOOGLE_CLIENT_ID');
        $googleRedirectURI = urlencode(env('GOOGLE_REDIRECT_URI'));
        $scopes = implode(" ", [
            "https://www.googleapis.com/auth/drive",
            "https://www.googleapis.com/auth/drive.file",
            "https://www.googleapis.com/auth/drive.metadata.readonly"
        ]);

        $url = "https://accounts.google.com/o/oauth2/v2/auth?".
            "client_id=". $googleClientID. "&".
            "response_type=code&".
            "scope=". $scopes. "&".
            "redirect_uri=". $googleRedirectURI;

        return redirect($url);
    }

    // Backend Endpoint to Exchange Code for Token
    public function handleGoogleDriveCallback(Request $request)
    {
        $googleClientSecret = env('GOOGLE_CLIENT_SECRET');
        $googleRedirectURI = env('GOOGLE_REDIRECT_URI');
        $authorizationCode = $request->input('code');

        $client = new Client();
        $response = $client->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => $googleClientSecret,
                'code' => $authorizationCode,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $googleRedirectURI,
            ]
        ]);

        $accessToken = json_decode((string)$response->getBody(), true)['access_token'];

        // Store the access token securely for later use
        // Redirect the user to the frontend or perform actions with the token
    }
}
