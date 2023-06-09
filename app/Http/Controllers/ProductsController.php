<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Exceptions\InvalidRequestException;
use App\Models\OrderItem;

class ProductsController extends Controller
{
    public function index(Request $request, Product $product)
    {
        // 创建一个查询构造器
        $builder = Product::query()->where('on_sale', true);
        // 判断是否有提交 search参数，如果有就赋值给$search 变量
        // search 参数用来模糊搜索商品
        if($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            // 模糊搜索商品、商品详情、SKU标题、SKU描述
            $builder->where(function($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function($query) use($like) {
                        $query->where('title', 'like', $like)
                            ->orWhere('description', 'like', $like);
                    });
            });
        }
        // 是否有提交order参数, 如果有就赋值给$order 变量
        // order 参数用来控制商品的排列规则
        if($order = $request->input('order', '')) {
            // 是否以_asc 或者_desc结尾
            if(preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                // 如果字符串的开头是这3个字符串之一，说明是一个合法的排序
                if(in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    // 根据传人的排序值来构造排序参数
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }
        $products = $builder->paginate(16);

        return view('products.index', [
            'products'  => $products,
            'filters'   => [
                'search'    => $search,
                'order'     => $order
            ]

        ]);
    }

    public function show(Product $product, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常
        if(!$product->on_sale) {
            throw new InvalidRequestException('商品未上架');
        }
        $favored = false;
        // 用户为登录时返回的事null,已登录时返回的事对应的用户对象
        if($user = $request->user()) {
            $favored = boolval($user->favoriteProducts()->find($product->id));
        }
        $reviews = OrderItem::query()
        ->with(['order.user', 'productSku']) // 预先加载关联关系
        ->where('product_id', $product->id)
        ->whereNotNull('reviewed_at') // 筛选出已经评价的
        ->orderBy('reviewed_at', 'desc') // 按评价时间倒序
        ->limit(10) // 取出10条
        ->get();
        return view('products.show', [
            'product' => $product,
            'favored' => $favored,
            'reviews' => $reviews
        ]);
    }

    /**
     * 新增收藏
     * **/
    public function favor(Product $product, Request $request)
    {
        $user = $request->user();
        if($user->favoriteProducts()->find($product->id)) {
            return [];
        }
        $user->favoriteProducts()->attach($product);
        return [];
    }

    public function disfavor(Product $product, Request $request)
    {
        $user = $request->user();
        $user->favoriteProducts()->detach($product);

        return [];
    }

    public function favorites(Request $request)
    {
        $products = $request->user()->favoriteProducts()->paginate(16);
        return view('products.favorites', ['products' => $products]);
    }
}
