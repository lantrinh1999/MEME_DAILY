<?php

register_page_template([
    'default' => 'Default',
]);

register_sidebar([
    'id'          => 'right_sidebar',
    'name'        => 'Right sidebar',
    'description' => 'This is a sample sidebar for meme theme',
]);

RvMedia::setUploadPathAndURLToPublic();
\Menu::addMenuLocation('menu-main', 'Menu Main');
\Menu::addMenuLocation('menu-mobile', 'Menu Mobile');
\Menu::addMenuLocation('menu-footer', 'Menu Footer');

Menu::removeMenuLocation('header-menu');
Menu::removeMenuLocation('main-menu');
Menu::removeMenuLocation('footer-menu');
