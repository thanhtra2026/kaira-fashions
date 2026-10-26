<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // GET /dang-nhap
    public function showLogin()
    {
        return view('auth.login');
    }

    // POST /dang-nhap
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập quản trị thành công.');
            }

            return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công.');
        }

        return back()
            ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])
            ->onlyInput('email');
    }

    // GET /dang-ky
    public function showRegister()
    {
        return view('auth.register');
    }

    // POST /dang-ky
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'      => 'Vui lòng nhập họ tên.',
            'name.max'           => 'Họ tên tối đa 255 ký tự.',
            'email.required'     => 'Vui lòng nhập email.',
            'email.email'        => 'Email không đúng định dạng.',
            'email.unique'       => 'Email này đã được đăng ký.',
            'password.required'  => 'Vui lòng nhập mật khẩu.',
            'password.min'       => 'Mật khẩu tối thiểu 6 ký tự.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ]);

        // Chỉ lấy đúng 3 trường; is_admin luôn là false (mặc định) -> khách tự đăng ký là Customer
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Đăng ký tài khoản thành công.');
    }

    // POST /dang-xuat
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Bạn đã đăng xuất.');
    }
}
