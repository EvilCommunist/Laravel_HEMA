<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Good;

class CartController extends Controller
{
    public function index()
    {
        $cartController = new CartController();
        $cartSummary = $cartController->getCartSummary();
        return view('cart', [
            'pageTitle' => 'Корзина | Золотой Грифон',
            'cartItems' => $cartSummary
        ]);
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Good::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Товар не найден']);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name_of_prod,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->main_image ? asset('storage/' . ltrim($product->main_image, '/')) : asset('images/placeholder.jpg')
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart' => $this->getCartSummary()
        ]);
    }

    public function updateCart(Request $request)
    {
        $productId = $request->input('product_id');
        $action = $request->input('action');

        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json(['success' => false, 'message' => 'Товар не найден в корзине']);
        }

        switch ($action) {
            case 'increase':
                $cart[$productId]['quantity']++;
                break;
            case 'decrease':
                if ($cart[$productId]['quantity'] > 1) {
                    $cart[$productId]['quantity']--;
                } else {
                    unset($cart[$productId]);
                }
                break;
            case 'remove':
                unset($cart[$productId]);
                break;
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart' => $this->getCartSummary()
        ]);
    }

    public function clearCart()
    {
        session()->forget('cart');
        return response()->json(['success' => true]);
    }

    public function getCartSummary()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $price = 0;

        foreach ($cart as $item) {
            $total += $item['quantity'];
            $price += $item['price'] * $item['quantity'];
        }

        return [
            'items' => array_values($cart),
            'total' => $total,
            'price' => $price
        ];
    }

    public function processOrder(Request $request)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'paymentMethod' => 'required|in:cash,card,bankTransfer'
        ]);

        $cart = $this->getCartSummary();

        if (empty($cart['items'])) {
            return response()->json(['success' => false, 'message' => 'Корзина пуста']);
        }

        // Placeholder func. Will be changed with DB order procession

        session()->forget('cart');

        return response()->json([
            'success' => true,
            'orderId' => uniqid(),
            'message' => 'Заказ успешно оформлен'
        ]);
    }
}