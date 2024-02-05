<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function satriaLogin($username, $password)
    {

        $postdata = array(
            'email' => $username,
            'password' => $password,
        );
        $response = Http::withHeaders(['Authorization' => env('ENV_TOKEN'),])->post(env('ENV_SATRIA_URL') . 'sf-login', $postdata);
        $data = json_decode($response, true);
        // dd($data);
        return $data;
    }

    public static function menulistSatria($access_token)
    {
        $response = Http::withHeaders([
            'x-api-key' => '34879|fZ489OPW8lxkLF7JKO7439EeEESOa9IvgQ3GyTeb',
            'Authorization' => 'Bearer ' .$access_token
        ])->get(env('ENV_SATRIA_URL') .'satria-permission-menu-list');
        $data = json_decode($response, true);
        return $data['data'];
    }
}
