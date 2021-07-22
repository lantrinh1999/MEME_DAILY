<?php
namespace Botble\Meme\Supports;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;

class Imgur
{
    const END_POINT = 'https://api.imgur.com/3/image/';

    protected $client_id = '95432d5e4065766';

    public function __construct()
    {
        $this->client_id = env('IMGUR_CLIENT_ID', '95432d5e4065766');
    }

    public function upload($imagdUrl)
    {
        try {
            // get image content
            // $response = Http::get($imagdUrl);
            // $imgContent = base64_encode($response->body());
            // dd($imgContent);

            // upload to imgur

            $options = [
                'headers' => [
                    'Authorization' => "Client-ID " . $this->client_id,
                ],
            ];

            $response = Http::retry(5, 1000)->withOptions($options)->post(self::END_POINT,
                [
                    "image" => $imagdUrl,
                ]
            );

            $result = $response->json();

            return $result['data']['link'] ?? null;

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return null;
        } catch (GuzzleException $e) {
            \Log::error($e->getMessage());
            return null;
        }
    }
}
