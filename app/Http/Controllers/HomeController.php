<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $cartController = new CartController();
        $cartSummary = $cartController->getCartSummary();
        return view('home', [
            'pageTitle' => 'Главная | Золотой Грифон',
            'cartItems' => $cartSummary
        ]);
    }
}