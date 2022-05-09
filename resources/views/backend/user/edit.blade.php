@extends('backend.layouts.app')

@section('title', __('Chỉnh sửa'))

@section('breadcrumb-links')
    @include('backend.includes.partials.breadcrumbs')
@endsection

@section('content')
    <x-forms.post :action="route('admin.user.update', $user)">
        <x-backend.card>
            <x-slot name="header">
                Chỉnh sửa
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.user.index')" :text="__('Hủy')" />
            </x-slot>

            <x-slot name="body">
                <div>

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                        <div class="col-md-10">
                            <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name', $user->name) }}" maxlength="100" />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label">@lang('E-mail Address')</label>

                        <div class="col-md-10">
                            <input type="email" name="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email', $user->email) }}" maxlength="255" />
                        </div>
                    </div><!--form-group-->
                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary" type="submit">@lang('Update User')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection

