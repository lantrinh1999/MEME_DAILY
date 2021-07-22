<?php
namespace Botble\Meme\Supports;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;

class Pik
{

    const END_POINT = 'https://2.pik.vn/';

    const PIK = 'https://3.pik.vn/';

    public function upload($imageUrl)
    {
        $base64 = $this->imageToBase64($imageUrl);
        // try {
            $response = Http::post(self::END_POINT,
                [
                    "image" => $base64,
                ]
            );

            $result = $response->json();

        // } catch (\Exception $e) {
        //     \Log::error($e->getMessage());
        //     return null;
        // } catch (GuzzleException $e) {
        //     \Log::error($e->getMessage());
        //     return null;
        // }

    }
    protected function imageToBase64($path)
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
