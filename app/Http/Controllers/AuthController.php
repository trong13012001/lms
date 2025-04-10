<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Validator;

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
        if ($this->checkTooManyLoginAttempts($request)) {
            return back();
        }

        $validator = Validator::make($request->all(),
            [
                'email' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'email.required' => 'Email Không được để trống',
                'password.required' => 'Mật khẩu không được để trống',
            ]);

        if ($validator->fails()) {
            notify()->error('Email hoặc mật khẩu không được để trống', 'Thông báo');
            return back();
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            $this->incrementLoginAttempts($request);
            $attempts = $this->getLoginAttempts($request);

            notify()->error('Email hoặc mật khẩu không đúng. Số lần thử: ' . $attempts, 'Thông báo');
            return back();
        }

        $this->clearLoginAttempts($request);
        $request->session()->regenerate();
        notify()->success('Đăng nhập thành công', 'Thông báo');
        return redirect()->route('dashboard');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/\.[a-z]{2,}$/i', $value)) {
                        $fail('Email phải có tên miền hợp lệ.');
                    }
                },
            ],
            'username' => 'required|string|max:255|unique:users,username',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],
        [
            'name.required' => 'Họ và tên không được để trống',
            'name.max' => 'Họ và tên không được vượt quá 255 kí tự',
            'email.max' => 'Email không được vượt quá 255 kí tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại, vui lòng sử dụng email khác',
            'username.max' => 'Tên tài khoản không được vượt quá 255 kí tự',
            'username.required' => 'Tên tài khoản không được để trống',
            'username.unique' => 'Tên tài khoản đã tồn tại, vui lòng sử dụng tên tài khoản khác',
            'password.required' => 'Mật khẩu không được để trống',
            'password.confirmed' => 'Mật khẩu không khớp',
            'password.min' => 'Mật khẩu phải trên 8 kí tự',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return back()->withErrors($errors)->withInput();
        }

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'position' => $request->position,
            'work_place' => $request->work_place,
        ]);

        notify()->success('Thêm tài khoản thành công', 'Thông báo');

        return to_route('admin.users.index');
    }

    public function editProfile()
    {
        $data = [];

        $user = User::find(Auth::user()->id);

        $data['user'] = $user;
        return view('admin.auth.profile', $data);
    }

    public function updateProfile(User $user, Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255,' . $user->id,
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users,email,' . $user->id,
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/\.[a-z]{2,}$/i', $value)) {
                            $fail('Email phải có tên miền hợp lệ.');
                        }
                    },
                ],
                'position' => 'max:255',
                'work_place' => 'max:255',
            ],
            [
                'name.required' => 'Họ và tên không được để trống',
                'name.max' => 'Họ và tên không được vượt quá 255 kí tự',
                'username.required' => 'Tên tài khoản không được để trống',
                'username.max' => 'Tên tài khoản không được vượt quá 255 kí tự',
                'username.unique' => 'Tên tài khoản đã tồn tại, vui lòng sử dụng tên tài khoản khác',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'email.unique' => 'Email đã tồn tại, vui lòng sử dụng email khác',
                'email.max' => 'Email không được vượt quá 255 kí tự',
                'position.max' => 'Chức vụ không được vượt quá 255 kí tự',
                'work_place.max' => 'Nơi làm việc không được vượt quá 255 kí tự',
            ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            foreach ($errors->all() as $error) {
                notify()->error($error, 'Thông báo');
            }

            return back()->withErrors($errors)->withInput();
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;
        $user->position = $request->position;
        $user->work_place = $request->work_place;
        if (auth()->user()->hasRole('admin')) {
            $user->email = $request->email;
        }

        $user->save();

        notify()->success('Sửa thông tin tài khoản thành công', 'Thông báo');

        return to_route('admin.users.index');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'old_password' => 'required',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|same:password',
            ],
            [
                'password.required' => 'Mật khẩu mới không được để trống',
                'password.min' => 'Mật khẩu mới phải trên 8 kí tự',
                'old_password.required' => 'Mật khẩu cũ không được để trống',
                'confirm_password.required' => 'Mật khẩu xác nhận không được để trống',
                'confirm_password.same' => 'Mật khẩu không khớp',
            ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            foreach ($errors->all() as $error) {
                notify()->error($error, 'Thông báo');
            }

            return back()->withErrors($errors)->withInput();
        }

        $user = $request->user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            notify()->success('Đổi mật khẩu thành công', 'Thông báo');

            Auth::logoutOtherDevices($request->password);
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        } else {
            notify()->error('Mật khẩu hiện tại không đúng', 'Thông báo');

            return back();
        }
    }

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

    public function changePassUser(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
        ], [
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành viên thành công'
        ]);
    }

    // /
    private function checkTooManyLoginAttempts(Request $request)
    {
        $maxAttempts = 5;  // Maximum number of attempts
        $lockoutTime = 600;  // Lockout time in seconds (e.g., 600 seconds = 10 minutes)

        $key = $this->throttleKey($request);
        $ipKey = 'login_lockout:' . $request->ip();

        if (RateLimiter::tooManyAttempts($ipKey, 1)) {
            $seconds = RateLimiter::availableIn($ipKey);
            notify()->error('Đăng nhập quá nhiều lần. Thử lại sau ' . $seconds . ' giây nữa.', 'Thông báo');
            return true;
        }

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            event(new Lockout($request));

            $seconds = RateLimiter::availableIn($key);
            $seconds = max($seconds, $lockoutTime);

            RateLimiter::clear($key);
            RateLimiter::hit($key, $seconds);
            RateLimiter::hit($ipKey, $seconds);

            notify()->error('Đăng nhập sai quá nhiều lần. Thử lại sau ' . $seconds . ' giây nữa.', 'Thông báo');
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
