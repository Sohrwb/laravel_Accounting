<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    //-----------------------------------------[  نمایش فرم ثبت‌ نام  ]-----------------------------------------------
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    //-----------------------------------------[  پردازش ثبت‌ نام  ]-----------------------------------------------

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'ثبت‌نام با موفقیت انجام شد. لطفاً وارد شوید.');
    }

    //-----------------------------------------[  نمایش فرم ورود  ]-----------------------------------------------

    public function showLoginForm()
    {
        return view('auth.login');
    }

    //-----------------------------------------[  نمایش فرم خانه  ]-----------------------------------------------

    public function home()
    {
        if (auth::user()) {

            $user = Auth::user();

            if ($user->loans->first()) {
                $loan = $user->loans->first();
                $payments = $loan->loanPayments()
                    ->whereMonth('payment_date', Carbon::now()->month)
                    ->whereYear('payment_date', Carbon::now()->year)
                    ->get();
                return view('home', compact('payments', 'user'));
            }
        }
        return view('home');
    }

    //-----------------------------------------[   پردازش ورود  ]-----------------------------------------------

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|string|email|exists:users',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'خوش آمدید!');
        }

        return back()->withErrors([
            'email' => 'اطلاعات ورود نادرست است.',
        ])->onlyInput('email');
    }

    //-----------------------------------------[  خروج از حساب  ]-----------------------------------------------

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'با موفقیت خارج شدید.');
    }

    //-----------------------------------------[  نمایش فرم فراموشی رمز عبور  ]-----------------------------------------------

    public function forget()
    {
        return view('auth.forget');
    }

    //-----------------------------------------[   دریافت ایمیل ورودی و ارسال ایمیل فراموشی  ]-----------------------------------------------

    public function forgetpost(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);

        $email =  DB::table('password_reset_tokens')->where('email', $request->email)->first();


        if ($email) {
            return redirect()->back()->with('error', 'email alredy send');
        }

        $token = str()->random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.forgetPassword', ['token' => $token], function ($massage) use ($request) {
            $massage->to($request->email);
            $massage->subject('reset passsword');
        });
        return redirect()->back()->with('success', 'email was send');
    }

    //-----------------------------------------[  نمایش فرم تغییر پسورد  ]-----------------------------------------------

    public function resetPassword($token)
    {

        return view('auth.reset', compact('token'));
    }

    //-----------------------------------------[  تغییر رمز ورود  ]-----------------------------------------------

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:5'
        ]);

        $updadepassword = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (!$updadepassword) {
            return redirect()->back()->with('error', 'invalid data');
        }

        User::where('email', $updadepassword->email)->update([
            'password' => Hash::make($request->password)
        ]);
        $updadepassword = DB::table('password_reset_tokens')->where('token', $request->token)->delete();
        return redirect()->route('home');
    }
}
