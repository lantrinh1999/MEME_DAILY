<?php

theme_option()
    ->setField([
        'id' => 'copyright',
        'section_id' => 'opt-text-subsection-general',
        'type' => 'text',
        'label' => __('Copyright'),
        'attributes' => [
            'name' => 'copyright',
            'value' => '© 2021 Memedaily. All right reserved.',
            'options' => [
                'class' => 'form-control',
                'placeholder' => __('Change copyright'),
                'data-counter' => 250,
            ],
        ],
        'helper' => __('Copyright on footer of site'),
    ])
    ->setField([
        'id' => 'primary_font',
        'section_id' => 'opt-text-subsection-general',
        'type' => 'googleFonts',
        'label' => __('Primary font'),
        'attributes' => [
            'name' => 'primary_font',
            'value' => 'Roboto',
        ],
    ]);

theme_option()
    ->setField([
        'id' => 'primary_color',
        'section_id' => 'opt-text-subsection-general',
        'type' => 'customColor',
        'label' => __('Primary color'),
        'attributes' => [
            'name' => 'primary_color',
            'value' => '#ff2b4a',
        ],
    ]);

theme_option()
    ->setField([
        'id' => 'sidebar_color',
        'section_id' => 'opt-text-subsection-general',
        'type' => 'customColor',
        'label' => __('Sidebar color'),
        'attributes' => [
            'name' => 'sidebar_color',
            'value' => '#17a2b8',
        ],
    ]);
theme_option()
    ->setField([
        'id' => 'tag_color',
        'section_id' => 'opt-text-subsection-general',
        'type' => 'customColor',
        'label' => __('Tag color'),
        'attributes' => [
            'name' => 'tag_color',
            'value' => '#495057',
        ],
    ]);
