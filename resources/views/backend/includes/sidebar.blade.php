<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <a href="{{route('admin.dashboard')}}" class="d-flex align-items-center logo">
{{--            <img src="{{asset('assets/images/logo-park-outline_brain.png')}}" alt="Logo" class="c-sidebar-brand-full" width="110" >--}}
{{--            <div class="text text-light">--}}
{{--                IQ 150--}}
{{--            </div>--}}
        </a>
    </div><!--c-sidebar-brand-->

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-title">@lang('System')</li>
        <li class="c-sidebar-nav-dropdown">
            <x-utils.link
                    :href="route('admin.user.index')"
                    icon="c-sidebar-nav-icon cil-user"
                    class="c-sidebar-nav-link"
                    :text="__('Quản lý tài khoản')"
                    :active="activeClass(Route::is('admin.user.*'), 'c-active')" />
        </li>
    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div><!--sidebar-->
