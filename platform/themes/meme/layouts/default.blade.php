{!! Theme::partial('header') !!}
<div class="container mt-3">
    <div class="row">
        <div class="col-lg-9">
            {!! Theme::content() !!}
        </div>
        <div class="col-lg-3">
            {!! Theme::partial('sidebar') !!}
        </div>
    </div>
</div>
{!! Theme::partial('footer') !!}
