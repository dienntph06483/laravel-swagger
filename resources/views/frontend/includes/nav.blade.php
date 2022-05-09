<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="c-header-brand d-flex align-items-center" href="{{route('admin.dashboard')}}">
{{--            <div class="image image-logo">--}}
{{--                <img src="{{asset('assets/images/logo-park-outline_brain.png')}}" alt="Logo" class="w-100" width="118">--}}
{{--            </div>--}}
{{--            <div class="text text-light">--}}
{{--                IQ 150--}}
{{--            </div>--}}
        </a>
    </div><!--container-->
</nav>

@if (config('boilerplate.frontend_breadcrumbs'))
    @include('frontend.includes.partials.breadcrumbs')
@endif
