<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return view('faq', [
            'pageTitle' => 'FAQ | Золотой Грифон',
            'cartItems' => [
                'total' => 0, // Замените на реальные данные
                'price' => 0   // Замените на реальные данные
            ]
        ]);
    }
}
