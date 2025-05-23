<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $cartController = new CartController();
        $cartSummary = $cartController->getCartSummary();
        return view('faq', [
            'pageTitle' => 'FAQ | Золотой Грифон',
            'cartItems' => $cartSummary
        ]);
    }
}
