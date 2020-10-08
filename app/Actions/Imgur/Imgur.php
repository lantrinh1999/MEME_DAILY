<?php

namespace App\Actions\Imgur;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;

class Imgur
{
    const END_POINT = 'https://api.imgur.com/3/image/';
    const END_POINT_2 = 'https://2.pik.vn/';

    const PIK = 'https://3.pik.vn/';

    public static function uploadImage($imagePath)
    {
        try {
            $client = new GuzzleClient();
            $request = $client->request(
                'POST',
                self::END_POINT,
                [
                    'headers' => [
                        'Authorization' => "Client-ID " . config('imgur.client_id'),
                    ],
                    'form_params' => [
                        'image' => file_get_contents($imagePath)
                    ]
                ]
            );
            $response = (string) $request->getBody();
            $jsonResponse = @json_decode($response);
        } catch (\Exception $e) {
            return NULL;
        }

        return @$jsonResponse->data->link; // return url of image
    }

    public static function uploadImage2($imagePath)
    {
        $base64 = self::imageToBase64($imagePath);
        $client = new GuzzleClient();
        $request = $client->request(
            'POST',
            self::END_POINT_2,
            [
                'form_params' => [
                    'image' => $base64,
                ]
            ]
        );
        $response = (string) $request->getBody();
        $jsonResponse = @json_decode($response);

        if (!empty($jsonResponse->saved)) {
            return self::PIK . $jsonResponse->saved; // return url of image
        }
        return false;
    }


    protected static function imageToBase64($path)
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}