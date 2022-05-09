@extends('backend.layouts.app')

@section('title', __('Quản lý tài khoản'))

@section('content')
    <x-backend.card>
        <x-slot name="body">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Quản lý tài khoản</h2>
                <a href="{{route("admin.user.create")}}" class="btn btn-success btn-sm btn-action my-3 d-flex align-items-center"><i class="c-icon cil-plus"></i>Thêm mới</a>
            </div>
            <table class="table table-responsive-sm table-striped">
                <thead>
                <tr>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Chỉnh sửa</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                            <td class="d-sm-flex">
                                <a href="{{route("admin.user.edit", $user->id)}}" class="btn btn-info btn-sm btn-action mx-1"><i class="fas fa-pencil-alt mr-1"></i>Sửa</a>
                                @if($user->id !== $logged_in_user->id)
                                <form action="{{route("admin.user.delete", $user->id)}}" class="form_delete" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-action btn-delete btn-sm mx-1"><i class="fas fa-trash mr-1"></i>Xóa</button>
                                </form>
                                @endif
                                <a href="{{route("admin.user.change_password", $user->id)}}" class="btn btn-secondary btn-sm btn-action mx-1"><i class="fas fa-pencil-alt mr-1"></i>Thay đổi mật khẩu</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="m-2 py-2 d-flex justify-content-center">
                <div style="overflow-x: auto">
                    {{ $users->links() }}
                </div>
            </div>
        </x-slot>
    </x-backend.card>
@endsection

@push('after-scripts')
    <script>
        $(function () {
            $(".btn-delete").click(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Bạn có muốn tài khoản này không ?',
                    showCancelButton: true,
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy',
                    icon: 'warning'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $(".btn-delete").parent('.form_delete').submit();
                    }
                });
            })
        })
    </script>
@endpush
