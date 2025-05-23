<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function admin()
        {
            $isAdmin = Admin::where('usr_id', Auth::id())->exists();
    
            if ($isAdmin) {
                return view('admin', ["user" => Auth::user()]);
            }
            
            return redirect('/login')->withErrors([
                'access' => 'Доступ запрещен: требуется права администратора'
            ]);
        }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "login" => "required",
            "passwd_hash" => "required"
        ]);
        
        $user = User::where('login', $credentials['login'])->first();
        
        if (!$user || !Hash::check($credentials['passwd_hash'], $user->passwd_hash)) {
            return redirect('/login')->withErrors([
                'login' => 'Неверные учетные данные'
            ]);
        }
        
        Auth::login($user);

        if (Admin::where('usr_id', $user->id)->exists()) {
            return redirect()->route('admin');
        }

        return redirect('/');
    }
        
    public function login_view()
        {
            $cartController = new CartController();
            $cartSummary = $cartController->getCartSummary();
            return view('login', [
                'pageTitle' => 'Вход | Золотой Грифон',
                'cartItems' => $cartSummary
            ]);
        }


    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fio' => 'required|string|max:40',
            'login' => 'required|string|unique:users',
            'tele_number' => 'required|string|unique:users',
            'passwd_hash' => 'required|string|min:5',
        ], [
            'required' => 'Поле :attribute обязательно.',
            'tele_number.unique' => 'Такой телефон уже существует.',
            'login.unique' => 'Такой логин уже существует.',
        ])->validate();

        User::create([
            "fio" => $request->fio,
            "login" => $request->login,
            "tele_number" => $request->tele_number,
            "passwd_hash" => Hash::make($request->passwd_hash), 
        ]);
        
        return redirect('/login');
    }

    public function registration_view()
        {
            $cartController = new CartController();
            $cartSummary = $cartController->getCartSummary();
            return view('registration', [
                'pageTitle' => 'Регистрация | Золотой Грифон',
                'cartItems' => $cartSummary
            ]);
        }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
}