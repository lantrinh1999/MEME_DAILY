<?php
use Botble\View\Events\ViewCountProcessed;

if(!function_exists('handleViewCount')) {
    function handleViewCount($model) {
        ViewCountProcessed::dispatch($model);
    }
}
