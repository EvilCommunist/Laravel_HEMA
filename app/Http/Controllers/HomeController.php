<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'pageTitle' => 'Главная | Золотой Грифон',
            'cartItems' => [
                'total' => 0, // Вставить реальные данные
                'price' => 0   // Вставить реальные данные
            ]
        ]);
    }
}