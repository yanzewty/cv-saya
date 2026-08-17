<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class LoginController extends Controller
{
    // ==========================================
    // BAGIAN 1: LOGIN & LOGOUT (Bawaan)
    // ==========================================
    public function showLoginForm()
    {
       return view('portfolio.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('portofolio.index');
        }

        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ==========================================
    // BAGIAN 2: REGISTRASI INVITE-ONLY (OTP)
    // ==========================================
    public function showRegister()
    {
        return view('portfolio.registrasi'); 
    }

    public function requestRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ], [
            'email.unique' => 'Email ini sudah terdaftar!',
            'password.min' => 'Password minimal 6 karakter!'
        ]);

        $otp = rand(100000, 999999);

        session([
            'reg_data' => $request->only('name', 'email', 'password'),
            'reg_otp' => $otp,
            'reg_otp_time' => time() 
        ]);

        try {
            Mail::raw("Halo Admin!\n\nAda yang mencoba mendaftar sebagai Admin di Portofolio.\n\nNama: {$request->name}\nEmail: {$request->email}\n\nJika kamu setuju mengizinkan dia masuk, berikan kode rahasia ini kepadanya:\n\nKODE REGISTRASI: {$otp}", function ($message) {
                $message->to('hisy037@gmail.com')->subject('Permintaan Akses Registrasi Portofolio');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email ke admin. Cek koneksi internet/SMTP!']);
        }

        return redirect()->route('register.verify')->with('success_msg', 'Data diterima! Silakan minta kode pendaftaran ke email admin (hisy037@gmail.com).');
    }

    public function showVerify()
    {
        if (!session()->has('reg_otp')) {
            return redirect()->route('register');
        }
        return view('portfolio.verify'); 
    }

    public function processVerify(Request $request)
    {
        $request->validate(['otp' => 'required']);

        if ($request->otp == session('reg_otp')) {
            $data = session('reg_data');

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);

            session()->forget(['reg_data', 'reg_otp', 'reg_otp_time']);
            return redirect()->route('login')->with('success_msg', 'Kode Benar! Akun berhasil dibuat. Silakan login.');
        }

        return back()->with('error_msg', 'Kode salah atau tidak valid! Anda penyusup?');
    }

    // ==========================================
    // BAGIAN 3: MINTA KODE ULANG (RESEND OTP)
    // ==========================================
    public function resendOtp()
    {
        if (!session()->has('reg_data')) {
            return redirect()->route('register')->withErrors(['email' => 'Sesi habis, silakan isi ulang form.']);
        }

        $data = session('reg_data');
        $newOtp = rand(100000, 999999);

        session(['reg_otp' => $newOtp, 'reg_otp_time' => time()]);

        try {
            Mail::raw("Halo Admin!\n\nUser meminta KODE BARU untuk mendaftar sebagai Admin di Portofolio.\n\nNama: {$data['name']}\nEmail: {$data['email']}\n\nKODE REGISTRASI BARU: {$newOtp}", function ($message) {
                $message->to('hisy037@gmail.com')->subject('Permintaan ULANG Akses Registrasi Portofolio');
            });
        } catch (\Exception $e) {
            return back()->with('error_msg', 'Gagal mengirim email ulang. Cek koneksi internet/SMTP!');
        }

        return redirect()->route('register.verify')->with('success_msg', 'Kode baru berhasil dikirim ulang ke admin!');
    }

    // ==========================================
    // BAGIAN 4: LUPA PASSWORD (FORGET)
    // ==========================================
    public function showForget()
    {
        return view('portfolio.forget'); 
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email'], [
            'email.exists' => 'Email ini tidak terdaftar sebagai Admin!'
        ]);

        $otp = rand(100000, 999999);

        session(['reset_email' => $request->email, 'reset_otp' => $otp, 'reset_otp_time' => time()]);

        try {
            Mail::raw("Halo Admin!\n\nSeseorang meminta untuk mereset password akun Portofoliomu.\n\nKODE RESET PASSWORD: {$otp}\n\nJika ini bukan kamu, abaikan saja email ini ya.", function ($message) use ($request) {
                $message->to($request->email)->subject('Kode Reset Password Portofolio');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email OTP. Cek koneksi/SMTP!']);
        }

        return redirect()->route('password.reset')->with('success_msg', 'Kode OTP telah dikirim ke email kamu!');
    }

    public function showReset()
    {
        if (!session()->has('reset_otp')) {
            return redirect()->route('password.forget');
        }
        return view('portfolio.reset');
    }

    public function processReset(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'password' => 'required|min:6'
        ], [
            'password.min' => 'Password minimal 6 karakter!'
        ]);

        if ($request->otp == session('reset_otp')) {
            $user = User::where('email', session('reset_email'))->first();
            $user->update(['password' => Hash::make($request->password)]);

            session()->forget(['reset_email', 'reset_otp', 'reset_otp_time']);
            return redirect()->route('login')->with('success_msg', 'Password berhasil direset! Silakan login.');
        }

        return back()->with('error_msg', 'Kode OTP salah atau kadaluarsa!');
    }
}