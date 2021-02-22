<?php

namespace App\Actions\Scaper;

use Goutte\Client;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\DomCrawler\Crawler as BaseCrawler;
use Symfony\Component\HttpClient\HttpClient;
class Crawler
{

    protected $meme_url;

    protected array $data = [];

    public function __construct()
    {
        // dd(env('SITE_CRAWLER', 'https://memehay.com/'));
        $this->meme_url = env('SITE_CRAWLER', 'https://memehay.com/');
    }

    public function memehay($page)
    {
        $crawler_ = $this->getCrawler(trim($this->meme_url, '/') . '/' . $page);

        if ($crawler_) {
            $result = $crawler_->filter('div#home div.card')->each(
                function (BaseCrawler $node) {
                    $value = [];
                    try {
                        $value['image'] = $node->filter('img')->attr('src');
                        $value['slug'] = $this->get_slug_meme($node->filter('.image a')->attr('href'));
                        $value['title'] = $node->filter('.postTitle a')->text();
                        $tag_ = $node->filter('.card-text a');
                        if (!empty($tag_)) {
                            $tags = $tag_->each(
                                function (BaseCrawler $node) {
                                    $tag = [];
                                    $tag['slug'] = $this->get_slug_meme($node->attr('href'));
                                    $tag['name'] = $node->text();
                                    return $tag;
                                }
                            );
                            if ($tags) {
                                $value['tags'] = $tags;
                            }
                        }
                    } catch (\Throwable $e) {
                        \Log::error($e->getMessage());
                    }
                    return $value;
                }
            );
//            dd($result);
            return $result;
        }
        return ;
    }

    protected function getCrawler($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $t = HttpClient::create(array(
                'headers' => array(
                    'user-agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0', // will be forced using 'Symfony BrowserKit' in executing
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.5',
                    'Referer' => 'http://yourtarget.url/',
                    'Upgrade-Insecure-Requests' => '1',
                    'Save-Data' => 'on',
                    'Pragma' => 'no-cache',
                    'Cache-Control' => 'no-cache',
                ),
            ));
            $client = new Client($t);
            $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0');

            return $client->request('GET', $url);
        }
        return false;
    }


    protected function get_slug_meme($str = '')
    {

        $arr =  @explode('/', $str);
        return @end($arr);
    }
}
