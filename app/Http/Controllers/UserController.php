<?php

namespace App\Http\Controllers;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Http\Requests\ChangePasswordUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * DeletedUserController constructor.
     *
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * List Users
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        $users = User::where("type", User::TYPE_ADMIN)->paginate(20);
        return view('backend.user.index', compact('users'));
    }

    /**
     * Create New User
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {
        return view('backend.user.create');
    }

    /**
     * Store New Recruitment
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request) {

        User::create([
            'type' => User::TYPE_ADMIN,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'email_verified_at' => now(),
            'active' => true,
        ]);

        return redirect()->route('admin.user.index')->withFlashSuccess(__('Thêm tài khoản thành công'));
    }

    /**
     * Edit User
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id) {
        $user = User::find($id);

        if(!$user) {
            return redirect()->back()->withErrors(["error" => "Tài khoản không tồn tại!"]);
        } else if($user->type != User::TYPE_ADMIN) {
            return redirect()->back()->withErrors(["error" => "Tài khoản không phải là tài khoản admin"]);
        }

        return view('backend.user.edit', compact('user'));
    }

    /**
     * Update User
     *
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id) {
        $user = User::find($id);

        if(!$user) {
            return redirect()->back()->withErrors(["error" => "Tin tuyển dung không tồn tại!"]);
        } else if($user->type != User::TYPE_ADMIN) {
            return redirect()->back()->withErrors(["error" => "Tài khoản không phải là tài khoản admin"]);
        }

        $user->fill($request->all());
        $user->save();

        return redirect()->route('admin.user.index')->withFlashSuccess(__('Chỉnh sửa tài khoản thành công'));
    }

    /**
     * Remove User
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {
        $user = User::find($id);

        if(!$user) {
            return redirect()->back()->withErrors(["error" => "Tin tuyển dung không tồn tại!"]);
        } else if($user->type != User::TYPE_ADMIN) {
            return redirect()->back()->withErrors(["error" => "Tài khoản không phải là tài khoản admin"]);
        }

        $this->userService->destroy($user);

        return redirect()->route('admin.user.index')->withFlashSuccess(__('Xóa tài khoản thành công'));
    }


    /**
     * Change Password User
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function change_password($id) {
        $user = User::find($id);

        if(!$user) {
            return redirect()->back()->withErrors(["error" => "Tài khoản không tồn tại!"]);
        } else if($user->type != User::TYPE_ADMIN) {
            return redirect()->back()->withErrors(["error" => "Tài khoản không phải là tài khoản admin"]);
        }

        return view('backend.user.change_password', compact('user'));
    }

    /**
     * @param  ChangePasswordUserRequest  $request
     * @param  $id
     * @return mixed
     *
     * @throws \Throwable
     */
    public function update_password(ChangePasswordUserRequest $request, $id)
    {
        $user = User::find($id);

        if(!$user) {
            return redirect()->back()->withErrors(["error" => "Tin tuyển dung không tồn tại!"]);
        } else if(Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(["error" => "Mật khẩu mới không được giống mật khẩu cũ"]);
        }else if($user->type != User::TYPE_ADMIN) {
            return redirect()->back()->withErrors(["error" => "Tài khoản không phải là tài khoản admin"]);
        }
        $user->password = $request->password;
        $user->save();

        return redirect()->route('admin.user.index')->withFlashSuccess(__('Thay đổi mật khẩu thành công!'));
    }
}
