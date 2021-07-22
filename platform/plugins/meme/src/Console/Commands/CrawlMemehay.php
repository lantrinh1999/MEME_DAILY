<?php

namespace Botble\Meme\Console\Commands;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Media\Repositories\Interfaces\MediaFolderInterface;
use Botble\Meme\Repositories\Interfaces\MemeInterface;
use Botble\Meme\Services\StoreMemeTagService;
use Botble\Meme\Supports\Imgur;
use Botble\Meme\Supports\Pik;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler as BaseCrawler;
use Symfony\Component\HttpClient\HttpClient;

class CrawlMemehay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:memehay {--url=} {--page=} {--proxy=} {--sleep=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command crawl meme';

    protected $imgur;
    protected $pik;

    protected $meme_url;

    protected $memeTagService;

    protected $request;

    protected $memeRepository;
    protected $folderRepository;

    protected $data = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Imgur $imgur, Pik $pik, StoreMemeTagService $memeTagService, MemeInterface $memeRepository, Request $request, MediaFolderInterface $folderRepository)
    {
        parent::__construct();

        $this->imgur = $imgur;
        $this->pik = $pik;
        $this->meme_url = env('SITE_CRAWLER', 'https://memehay.com/');
        $this->memeTagService = $memeTagService;
        $this->memeRepository = $memeRepository;
        $this->request = $request;
        $this->folderRepository = $folderRepository;

    }

    protected function getMemeFolder()
    {
        $name = 'meme';
        $model = app(MediaFolderInterface::class)->getModel();
        $folder = $model->where('slug', $name)->first();
        if (empty($folder)) {
            $parentId = 0;
            $folder = $model;
            $folder->user_id = 0;
            $folder->name = $this->folderRepository->createName($name, $parentId);
            $folder->slug = $this->folderRepository->createSlug($name, $parentId);
            $folder->parent_id = $parentId;
            $folder = $this->folderRepository->createOrUpdate($folder);
        }

        return $folder;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $folder = $this->getMemeFolder();

        for ($i = (int) ($this->option('page') ?? 200); $i > 0; $i--) {
            $this->info("- Page: $i");
            $data = $this->memehay($i);
            if (!empty($data) && count($data) > 0) {
                sleep(rand(1, 2));
                foreach ($data as $meme) {
                    if (!empty($meme['image']) && !empty($meme['name']) && !empty($meme['slug'])) {

                        if (!empty($this->memeRepository->getModel()->where('meme_slug', $meme['slug'])->first())) {
                            continue;
                        }

                        $request = $this->request;

                        $meme_meta = [];
                        $meme_meta['origin_image'] = $meme['image'];
                        $meme_meta['origin_slug'] = $meme['slug'];
                        $meme_meta['origin_tag'] = $meme['slug'];
                        $meme['meme_slug'] = $meme['slug'];
                        $meme['description'] = $meme['name'];
                        $media = \RvMedia::uploadFromUrl($meme['image'], $folder->id);

                        $meme['image'] = $media['data']->url ?? null;

                        $meme['tag'] = null;
                        if (!empty($meme['tags']) && count($meme['tags']) > 0) {
                            $tag = collect($meme['tags'])->pluck('name')->all();
                            $meme['tag'] = $tag;
                            $meme_meta['origin_tag'] = $meme['tags'];
                        }

                        $meme['meme_meta'] = json_encode($meme_meta);

                        $request->merge($meme);

                        $meme = $this->memeRepository->getModel()->firstOrCreate(
                            ['meme_slug' => $meme['meme_slug']],
                            $meme
                        );

                        event(new CreatedContentEvent(MEME_MODULE_SCREEN_NAME, $request, $meme));

                        $memeTagService = $this->memeTagService;
                        $memeTagService->execute($request, $meme);

                        sleep(0.1);

                        $this->info(' + DONE: ' . $meme['name']);
                    }
                    $meme = null;
                }

                try {
                    \Artisan::call('cms:webptojpg');
                } catch (\Throwable $th) {
                    //throw $th;
                }

                \Cache::flush();
            }
        }



    }

    public function memehay($page)
    {
        $crawler_ = $this->getCrawler(trim($this->meme_url, '/') . '/' . $page);


        if ($crawler_) {

            $result = $crawler_->filter('#home .card')->each(
                function (BaseCrawler $node) {

                    $value = [];
                    $tags = null;
                    try {
                        $value['image'] = $node->filter('img')->attr('src');
                        $value['slug'] = $this->get_slug_meme($node->filter('.image a')->attr('href'));
                        $value['name'] = $node->filter('.postTitle a')->text();
                        $tag_ = $node->filter('.card-text a.tag');
                        $tags = null;
                        if (!empty($tag_->count())) {
                            $tags = $tag_->each(
                                function (BaseCrawler $node) {
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
            if (!empty($result) && count($result) > 0) {
                return collect($result)->reverse()->all();
            }
            return null;
        }
        return null;
    }

    protected function getCrawler($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $options = [
                'headers' => [
                    'user-agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0', // will be forced using 'Symfony BrowserKit' in executing
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    // 'Accept-Language' => 'en-US,en;q=0.5',
                    // 'Referer' => 'http://yourtarget.url/',
                    'Upgrade-Insecure-Requests' => '1',
                    'Save-Data' => 'on',
                    'Pragma' => 'no-cache',
                    'Cache-Control' => 'no-cache',
                ],
            ];
            if (!empty($this->option('proxy'))) {
                $options['proxy'] = $this->option('proxy');
            }
            $t = HttpClient::create($options);
            $client = new Client($t);
            $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0');

            return $client->request('GET', $url);
        }
        return false;
    }

    protected function get_slug_meme(string $str = '')
    {

        $arr = explode('/', $str ?? '');
        return end($arr);
    }
}
