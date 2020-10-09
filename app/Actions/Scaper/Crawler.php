<?php

namespace App\Actions\Scaper;

use Goutte\Client;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\DomCrawler\Crawler as BaseCrawler;

class Crawler
{

    protected static string $meme_url = 'https://memehay.com/';

    protected array $data = [];

    public function memehay($page)
    {
        $crawler_ = $this->getCrawler(self::$meme_url . $page);
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
                    } catch (\Exception $e) {
                    }
                    return $value;
                }
            );
            return $result ?? false;
        }
    }

    protected function getCrawler($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $client = new Client();
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
