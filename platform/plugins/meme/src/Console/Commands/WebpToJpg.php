<?php

namespace Botble\Meme\Console\Commands;

use Illuminate\Console\Command;
use Botble\Media\Models\MediaFile;
use Botble\Meme\Models\Meme;

class WebpToJpg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:webptojpg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        MediaFile::where('url', 'LIKE', '%.webp%')
        ->chunkById(100, function($images) {
            foreach($images as $key => $image) {
                try {
                    $old_url = $image->url;
                    $img = imagecreatefromwebp(\Storage::path($image->url));
                    $img = \Image::configure(array('driver' => 'gd'))->make($img)->encode('jpg',80);

                    $image->mime_type = 'image/jpeg';
                    $image->url = \Str::replaceLast('.webp', '.jpg', $image->url);

                    $check = \Storage::put($image->url, $img);
                    if($check) {
                        $this->info($image->name);
                        $image->size = \Storage::size($image->url);
                        $image->save();
                        $meme = Meme::where('memes.image', '=', $old_url)->first();
                        if($meme) {
                            $meme->image = $image->url;
                            $meme->save();
                            \Storage::delete([$old_url]);
                        }

                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            sleep(1);
        });

        Meme::where('memes.image', 'LIKE', '%.webp%')
        ->chunkById(100, function($memes) {
            foreach($memes as $key => $meme) {
                try {
                    $old_image = $meme->image;
                    $new_image = \Str::replaceLast('.webp', '.jpg', $meme->image);
                    if(\Storage::exists($new_image)) {
                        $this->info($meme->name);
                        $meme->image = $new_image;
                        $meme->save();
                        \Storage::delete([$old_image]);
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }

            \Cache::flush();
        });
    }
}
