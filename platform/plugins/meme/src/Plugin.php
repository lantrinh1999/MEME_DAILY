<?php

namespace Botble\Meme;

use Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('memes');
        // Schema::dropIfExists('meme_tags');
        Schema::dropIfExists('meme_tag');
    }
}
