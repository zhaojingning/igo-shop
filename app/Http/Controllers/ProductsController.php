<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;

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
}
