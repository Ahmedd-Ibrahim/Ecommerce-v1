@include('front.incloud.header')
@include('front.incloud.header-welcome')
{{-- @include('front.incloud.header-v1') --}}
@include('front.incloud.nav')

<div id="content" class="site-content" tabindex="-1">
    <div class="container">
        @yield('content')
    </div>
</div>

@include('front.incloud.footer')
