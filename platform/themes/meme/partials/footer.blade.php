<!-- The content of your page would go here. -->
<footer class="footer-distributed">
    <div class="container">
        <div class="footer-left">
            <h3><a class="text-light" href="/">{{ theme_option('site_title_footer', 'MEMEDAILY') }}</a></h3>

            {!! Menu::renderMenuLocation('menu-footer', [
    'options' => ['class' => 'footer-links'],
    'view' => 'menu-footer',
]) !!}
            <p class="footer-company-name">{{ theme_option('copyright', '© 2021 Memedaily. All right reserved.') }}
            </p>
        </div>
        {{-- <div class="footer-center text-left">
            <div class="text-left">
                <i class="fa fa-map-marker"></i>
                <p><span>21 Revolution Street</span> Paris, France</p>
            </div>
            <div class="text-left">
                <i class="fa fa-phone"></i>
                <p>+1 555 123456</p>
            </div>
            <div class="text-left">
                <i class="fa fa-envelope"></i>
                <p><a href="/cdn-cgi/l/email-protection#4f3c3a3f3f203d3b0f2c20223f2e2136612c2022"><span
                            class="__cf_email__"
                            data-cfemail="1b686e6b6b74696f5b7874766b7a756235787476">[email&#160;protected]</span></a>
                </p>
            </div>
        </div> --}}
        {{-- <div class="footer-right">
            <p class="footer-company-about">
                <span>About the company</span>
                Lorem ipsum dolor sit amet, consectateur adispicing elit. Fusce euismod convallis velit, eu auctor lacus
                vehicula sit amet.
            </p>
            <div class="footer-icons">
                <a href="#"><i class="fas far fa-facebook"></i></a>
                <a href="#"><i class="fas far fa-twitter"></i></a>
                <a href="#"><i class="fas far fa-linkedin"></i></a>
                <a href="#"><i class="fas far fa-github"></i></a>
            </div>
        </div> --}}
    </div>
</footer>
{{-- <menu-mobile></menu-mobile> --}}
<div id="bs-canvas-right" class="bs-canvas bs-canvas-right position-fixed bg-light h-100 navbar-light">
    <header id="menu-mobile" class="bs-canvas-header menu-mobile bg-primary navbar bg-info overflow-auto s-c-c">
        <button type="button" class="bs-canvas-close float-left close" aria-label="Close"><span aria-hidden="true"
                class="text-light">&times;</span></button>
        <h4 class="d-inline-block text-light mb-0 float-right"><a class="text-white" href="/">MEMEDAILY</a></h4>
    </header>
    <div class="bs-canvas-content px-3 py-3">
        <div class="pt-3">
            <form action="/" class="form-inline my-2 my-lg-0">
                <input value="{{ strip_tags(request('s', null)) }}" class="form-control bg-dark text-white" name="s"
                    type="search" placeholder="Tìm kiếm" aria-label="Tìm kiếm">
                {{-- <button class="btn btn-light" type="submit">Tìm kiếm</button> --}}
            </form>
        </div>
        @if (true)
            {!! Menu::renderMenuLocation('menu-main', [
    'options' => ['class' => 'navbar-nav mr-auto'],
    'view' => 'menu-main',
]) !!}
            {!! Menu::renderMenuLocation('menu-mobile', [
    'options' => ['class' => 'navbar-nav mr-auto'],
    'view' => 'menu-main',
]) !!}
        @endif


        {{-- <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item</th>
                    <th scope="col">Qty.</th>
                    <th scope="col">Remove</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Quilt</td>
                    <td>2</td>
                    <td class="text-center"><a href="" class="text-decoration-none text-muted">&times;</a></td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Shawl</td>
                    <td>1</td>
                    <td class="text-center"><a href="" class="text-decoration-none text-muted">&times;</a></td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Pillow</td>
                    <td>5</td>
                    <td class="text-center"><a href="" class="text-decoration-none text-muted">&times;</a></td>
                </tr>
            </tbody>
        </table>
        <p class="text-center"><button type="button" class="btn btn-primary">Checkout</button></p>
        <div class="list-group my-5">
            <a href="#" class="list-group-item list-group-item-action">Cras justo odio</a>
            <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
            <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
            <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
            <a href="#" class="list-group-item list-group-item-action">Vestibulum at eros</a>
        </div>
        <p class="text-muted small">Subscribe to our newsletter:</p>
        <div class="input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">@</span>
            </div>
            <input type="text" class="form-control" placeholder="Email" aria-label="Username"
                aria-describedby="addon-wrapping">
        </div>
        <p class="text-right mt-3 mb-0">
            <button type="button" class="btn btn-outline-dark">Subscribe</button>
        </p> --}}
    </div>
</div>

{{-- <menu-mobile></menu-mobile> --}}
{!! Theme::footer() !!}
<script type="text/javascript">
    navbar_height = document.querySelector('.navbar').offsetHeight;
    document.getElementById('navbar_top').classList.add('fixed-top');
    document.body.style.paddingTop = navbar_height + 'px';
    document.getElementById('menu-mobile').style.height = navbar_height + 'px';
    $(document).on('click', '.bs-canvas-overlay, .bs-canvas-close', function() {
        document.getElementById('navbar_top').classList.add('fixed-top');
        document.body.style.paddingTop = navbar_height + 'px';
        document.body.style.overflow = 'auto';
    });
    $(document).on('click', '.pull-bs-canvas-right', function() {
        document.getElementById('navbar_top').classList.remove('fixed-top');
        document.body.style.paddingTop = '0' + 'px';
        document.body.style.overflow = 'hidden';
    });

</script>
@if (Agent::isDesktop())
    <script>
        var isMobile = navigator.userAgent.match(/Android|webOS|iPhone|iPod|Blackberry/i);

        if (isMobile) {
            console.log('isMobile');
        } else {
            console.log('isDesktop');
        }

        if (!isMobile) {
            $(function() {
                // Initate masonry grid
                var $grid = $('.gallery-wrapper').masonry({
                    temSelector: '.grid-item',
                    columnWidth: '.grid-sizer',
                    percentPosition: true,
                });

                // Initate imagesLoaded
                $grid.imagesLoaded().progress(function() {
                    $grid.masonry('layout');
                });
            });
        }

    </script>
@endif
</body>

</html>
