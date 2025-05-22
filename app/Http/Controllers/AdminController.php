<?php
namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
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
        
        return view('admin', [
            'pageTitle' => 'Админпанель | Золотой Грифон',
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $selectedCategory,
            'user' => auth()->user()
        ]);
    }

    public function create()
    {
        return view('create', [
            'pageTitle' => 'Добавить товар | Золотой Грифон',
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cathegory' => 'required|exists:cathegory,name_of_type',
            'price' => 'required|numeric|min:0',
            'remain' => 'required|integer|min:0',
            'description' => 'required|string',
            'main_pic' => 'nullable|image|max:2048',
            'alt_pics.*' => 'nullable|image|max:2048',
            'characteristics.*' => 'nullable|string|max:255'
        ]);

        $categoryId = Category::where('name_of_type', $request->cathegory)->first()->id;

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $mainImagePath = $this->storeImage($request->file('main_pic'));
            $altImagesPaths = $this->storeImages($request->file('alt_pics'));

            $imagesArray = array_filter([$mainImagePath, ...$altImagesPaths]);
            $imagesForDb = '{'.implode(',', $imagesArray).'}';

            $product = Good::create([
                'name_of_prod' => $request->name,
                'cathegory' => $categoryId, 
                'remain' => $request->remain,
                'price' => $request->price,
                'description' => $request->description,
                'img_link' => $imagesForDb, 
            ]);

            $this->storeCharacteristics($product, $request->characteristics);

            return redirect()->route('admin')->with('success', 'Товар успешно добавлен');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при сохранении товара: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Good $product)
    {
        return view('edit', [
            'pageTitle' => 'Редактирование товара | Золотой Грифон',
            'product' => $product,
            'displayCategory' => str_replace('комплекты', '', $product->category->name_of_type ?? ''),
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Good $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cathegory' => 'required|exists:cathegory,name_of_type',
            'price' => 'required|numeric|min:0',
            'remain' => 'required|integer|min:0',
            'description' => 'required|string',
            'new_images.*' => 'nullable|image|max:2048',
            'characteristics.*' => 'nullable|string|max:255',
            'existing_main_pic' => 'nullable|string',
            'existing_alt_pics' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $existingImages = array_filter(array_merge(
                [$request->existing_main_pic],
                $request->existing_alt_pics ?? []
            ));

            $newImages = $this->storeImages($request->file('new_images'));
            $allImages = array_merge($existingImages, $newImages);

            $mainImage = $request->existing_main_pic;
            if (empty($mainImage) && count($allImages) > 0) {
                $mainImage = array_shift($allImages);
            }

            $product->update([
                'name_of_prod' => $request->name,
                'cathegory' => $request->cathegory,
                'price' => $request->price,
                'remain' => $request->remain,
                'description' => $request->description,
                'img_link' => $this->formatImagesForDb($mainImage, $allImages),
            ]);

            $product->characteristics()->delete();
            $this->storeCharacteristics($product, $request->characteristics);

            return redirect()->route('admin')->with('success', 'Товар успешно обновлён');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при обновлении товара: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function storeImage($file)
    {
        if (!$file) return null;
        return $file->store('public/imagesOfGoods');
    }

    private function storeImages($files)
    {
        if (!$files) return [];
        
        $paths = [];
        foreach ($files as $file) {
            if ($file->isValid()) {
                $paths[] = $this->storeImage($file);
            }
        }
        return $paths;
    }

    private function formatImagesForDb($mainImage, $altImages)
    {
        $images = array_filter(array_merge([$mainImage], $altImages));
        return '{' . implode(',', $images) . '}';
    }

    private function storeCharacteristics($product, $characteristics)
    {
        if (empty($characteristics)) return;
        
        foreach ($characteristics as $char) {
            $char = trim($char);
            if (!empty($char)) {
                $product->characteristics()->create(['characteristic' => $char]);
            }
        }
    }
}
    /*
    public function updateQuantity(Request $request, $id)
    {
        $product = Good::findOrFail($id);
        $action = $request->input('action');
        
        if ($action === 'increase') {
            $product->remain += 1;
        } elseif ($action === 'decrease' && $product->remain > 0) {
            $product->remain -= 1;
        }
        
        $product->save();
        
        return response()->json(['remain' => $product->remain]);
    }
}*/