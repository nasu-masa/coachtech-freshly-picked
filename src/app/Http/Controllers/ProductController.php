<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * PG01 商品一覧
     * PG05 検索結果表示
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
            $sortLabel = '高い順に表示';
        } elseif ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
            $sortLabel = '低い順に表示';
        } else {
            $sortLabel = null;
        }

        $products = $query
            ->paginate(6)
            ->appends($request->query());

        return view('product.index', compact('products', 'sortLabel'));
    }


    /**
     * PG05 検索
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::where('name', 'like', "%{$keyword}%")
            ->paginate(6)
            ->appends(['keyword' => $keyword]);

        return view('product.index', compact('products', 'keyword'));
    }


    /**
     * PG02 商品詳細
     */
    public function show($id)
    {
        $product = Product::with('seasons')->findOrFail($id);
        $seasons = Season::all();

        return view('product.show', compact('product', 'seasons'));
    }


    /**
     * PG03 商品更新処理
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        // 画像更新
        $product->name        = $request->name;
        $product->price       = $request->price;
        $product->description = $request->description;

        $product->save();

        $product->seasons()->sync($request->season);

        return redirect()->route('products.index');
    }


    /**
     * PG06 削除
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index');
    }


    /**
     * PG04 商品登録画面
     */
    public function create()
    {
        $seasons = Season::all();

        return view('product.create', compact('seasons'));
    }


    /**
     * PG04 商品登録処理
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product();

        // 画像保存
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->name        = $request->name;
        $product->price       = $request->price;
        $product->description = $request->description;

        $product->save();

        $product->seasons()->attach($request->season);

        return redirect()->route('products.index');
    }
}
