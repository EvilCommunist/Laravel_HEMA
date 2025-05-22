<?php
namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function dashboard(Request $request)
    {
        $selectedCategory = $request->input('category');
        
        $query = Good::with('category', 'characteristics');
        
        if ($selectedCategory) {
            $query->whereHas('category', function($q) use ($selectedCategory) {
                $q->where('name_of_type', $selectedCategory);
            });
        }
        
        $products = $query->get();
        
        $categories = Category::with('products')->get();
        
        if ($selectedCategory) {
            $displayText = strpos($selectedCategory, 'комплекты') !== false ? 
                str_replace('комплекты', '', $selectedCategory) : 
                $selectedCategory;
            $leftText = $displayText;
            $rightText = $displayText;
            $currentSection = $selectedCategory;
            $currentSubSection = 'Каталог > ' . $selectedCategory;
        } else {
            $leftText = 'Каталог';
            $rightText = 'Каталог';
            $currentSection = 'Все товары';
            $currentSubSection = 'Каталог';
        }

        return view('store', [
            'pageTitle' => 'Каталог | Золотой Грифон',
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $selectedCategory,
            'leftText' => $leftText,
            'rightText' => $rightText,
            'currentSection' => $currentSection,
            'currentSubSection' => $currentSubSection,
            'loading' => $products->isEmpty()
        ]);
    }

    public function showProduct($id)
    {
        $product = Good::with('characteristics', 'category')->find($id);
        
        if (!$product) {
            return redirect('/')->with('error', 'Товар не найден');
        }
        
        $displayCategory = str_replace('комплекты', '', $product->category->name_of_type ?? '');
        $displayCategory = trim($displayCategory);
        $breadcrumbs = 'Каталог > ' . ($product->category->name_of_type ?? '') . ' > ' . $product->name_of_prod;
        
        $allImages = $product->images;
        $allImages = array_filter($allImages);
    
        $allImages = array_map(function($image) {
            return asset('storage/' . ltrim($image, '/'));
        }, $allImages);
        
        return view('product', [
            'pageTitle' => $product->name_of_prod . ' | Золотой Грифон',
            'product' => $product,
            'displayCategory' => $displayCategory,
            'breadcrumbs' => $breadcrumbs,
            'allImages' => $allImages,
            'loading' => false
        ]);
    }
    
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        
        // Логика добавления в корзину
        // ...
        
        return response()->json(['success' => true]);
    }
}