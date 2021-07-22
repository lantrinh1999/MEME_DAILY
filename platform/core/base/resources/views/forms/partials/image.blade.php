<div class="image-box">
    <style>
        .preview-image-wrapper.preview-image-wrapper-not-allow-thumb img {
            width: 100% !important;
            max-width: 100% !important;
            max-height: auto !important;
        }

        .preview-image-wrapper.preview-image-wrapper-not-allow-thumb {
            width: 100% !important;
            height: auto !important;
            max-width: 100% !important;
            max-height: auto !important;
        }
        .btn-.btn_gallery {
            font-weight: 500;
            color: rgb(114, 114, 114);
        }
        .btn_remove_image {
            font-size: 20px;
            border-radius: 0 !important;
        }

    </style>
    <input type="hidden" name="{{ $name }}" value="{{ $value }}" class="image-data">
    <div class="preview-image-wrapper @if (!Arr::get($attributes, 'allow_thumb' , true)) preview-image-wrapper-not-allow-thumb @endif">
        <img src="{{ RvMedia::getImageUrl($value, Arr::get($attributes, 'allow_thumb', true) ? 'thumb' : null, false, RvMedia::getDefaultImage()) }}"
            alt="{{ trans('core/base::base.preview_image') }}" class="preview_image" @if (Arr::get($attributes, 'allow_thumb', true)) width="150" @endif>
        <a class="btn_remove_image" title="{{ trans('core/base::forms.remove_image') }}">
            <i class="fa fa-times"></i>
        </a>
    </div>
    <div class="image-box-actions">
        <a href="#" class="btn- btn_gallery" data-result="{{ $name }}"
            data-thumb="{{ Arr::get($attributes, 'allow_thumb', true) ? 1 : 0 }}"
            data-action="{{ $attributes['action'] ?? 'select-image' }}">
            {{ trans('core/base::forms.choose_image') }}
        </a>
    </div>
</div>
