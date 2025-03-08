<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function create()
    {
        return view('admin.auth.login');
    }


    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if($this->checkTooManyLoginAttempts($request)) {
            return back();
        }

        $validator = Validator::make($request->all(),
        [
            'email'      => 'required|string',
            'password'   => 'required|string',
        ],
        [
            'email.required' => 'Email Không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
        ]);

        if ($validator->fails()) {
            notify()->error('Email hoặc mật khẩu không được để trống', 'Lỗi');
            return back();
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            $this->incrementLoginAttempts($request);
            $attempts = $this->getLoginAttempts($request);

            notify()->error('Email hoặc mật khẩu không đúng. Số lần thử: ' . $attempts, 'Lỗi');
            return back();
        }

        $this->clearLoginAttempts($request);
        $request->session()->regenerate();
        notify()->success('Đăng nhập thành công', 'Thông báo');
        return redirect()->route('dashboard');
    }

    public function editProfile() {
        return view('admin.auth.profile');
    }

    // public function updateProfile(User $user, Request $request)
    // {
    //     $validator = Validator::make($request->all(),
    //     [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|regex:/(.+)@(.+)\.(.+)/i|max:255',
    //     ],
    //     [
    //         'email.required' => 'Email không được để trống',
    //         'email.regex' => 'Email không đúng định dạng',
    //         'name.required' => 'Tên tài khoản không được để trống',
    //     ]);

    //     if ($validator->fails()) {
    //         $mess = $validator->errors()->get('*');
    //         if(isset($mess['name'])) {
    //             toastr()->addError($mess['name'][0]);
    //         }

    //         if(isset($mess['email'])) {
    //             toastr()->addError($mess['email'][0]);
    //         }

    //         return back();
    //     } else {

    //         $user->name = $request->name;
    //         if($user->hasRole('admin')) {
    //             $user->email = $request->email;
    //         }
    //         $user->save();

    //         toastr()->addSuccess('Sửa thông tin tài khoản thành công');

    //         return back();
    //     }
    // }

    // public function changePassword(Request $request)
    // {
    //     $validator = Validator::make($request->all(),
    //     [
    //         'old_password'           => 'required',
    //         'password'               => 'required|string|min:8',
    //         'confirm_password'       => 'required|same:password',
    //     ],
    //     [
    //         'password.required'             => 'Mật khẩu mới không được để trống',
    //         'password.min'                  => 'Mật khẩu mới phải trên 8 kí tự',
    //         'old_password.required'         => 'Mật khẩu cũ không được để trống',
    //         'confirm_password.required'     => 'Mật khẩu xác nhận không được để trống',
    //         'confirm_password.same'         => 'Mật khẩu không khớp',
    //     ]);

    //     if ($validator->fails()) {
    //         // toastr()->addError('Mật khẩu không được để trống và phải trên 8 kí tự');
    //         $error = $validator->messages();

    //         if($error->get('password')) {
    //             toastr()->addError($error->first('password'));
    //         }

    //         if($error->get('old_password')) {
    //             toastr()->addError($error->first('old_password'));
    //         }

    //         if($error->get('confirm_password')) {
    //             toastr()->addError($error->first('confirm_password'));
    //         }

    //         return back();
    //     }

    //     $user = $request->user();
    //     if(Hash::check($request->old_password, $user->password)) {
    //         $user->update([
    //             'password' => Hash::make($request->password)
    //         ]);

    //         toastr()->addSuccess('Đổi mật khẩu thành công');

    //         Auth::logoutOtherDevices($request->password);
    //         Auth::guard('web')->logout();
    //         $request->session()->invalidate();
    //         $request->session()->regenerateToken();

    //         return redirect('/');
    //     } else {
    //         toastr()->addError('Mật khẩu hiện tại không đúng');

    //         return back();
    //     }
    // }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        notify()->info('Đăng xuất tài khoản thành công', 'Thông báo');

        return redirect('/');
    }

    public function changePassUser(User $user, Request $request) {
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        notify()->success('Đổi mật khẩu thành viên thành công', 'Thông báo');

        return back();
    }



    ///
    private function checkTooManyLoginAttempts(Request $request)
    {
        $maxAttempts = 5; // Maximum number of attempts
        $lockoutTime = 600; // Lockout time in seconds (e.g., 600 seconds = 10 minutes)

        $key = $this->throttleKey($request);
        $ipKey = 'login_lockout:' . $request->ip();

        if (RateLimiter::tooManyAttempts($ipKey, 1)) {
            $seconds = RateLimiter::availableIn($ipKey);
            notify()->error('Đăng nhập quá nhiều lần. Thử lại sau ' . $seconds . ' giây nữa.', 'Lỗi');
            return true;
        }

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            event(new Lockout($request));

            $seconds = RateLimiter::availableIn($key);
            $seconds = max($seconds, $lockoutTime);

            RateLimiter::clear($key);
            RateLimiter::hit($key, $seconds);
            RateLimiter::hit($ipKey, $seconds);

            notify()->error('Đăng nhập sai quá nhiều lần. Thử lại sau ' . $seconds . ' giây nữa.', 'Lỗi');
            return true;
        }

        return false;
    }

    private function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    private function incrementLoginAttempts(Request $request)
    {
        $key = $this->throttleKey($request);
        RateLimiter::hit($key);
    }

    private function getLoginAttempts(Request $request)
    {
        $key = $this->throttleKey($request);
        return RateLimiter::attempts($key);
    }

    private function clearLoginAttempts(Request $request)
    {
        $key = $this->throttleKey($request);
        RateLimiter::clear($key);
    }
}
