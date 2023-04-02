<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\UserAddress;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;

use App\Exceptions\InvalidRequestException;

class OrdersController extends Controller
{
    // 利用 Laravel 的自动解析功能注入 CartService 类
    public function store(OrderRequest $request, OrderService $orderService)
    {
        $user  = $request->user();
       
        $address = UserAddress::find($request->input('address_id'));
            
        return $orderService->store($user, $address, $request->input('remark'), $request->input('items'));
    }

    public function index(Request $request)
    {
        $orders = Order::query()
        // 使用with 方法预加载，避免 N+1问题
        ->with(['items.product', 'items.productSku'])
        ->where('user_id', $request->user()->id)
        ->orderBy('created_at', 'desc')
        ->paginate();

        return view('orders.index', ['orders' => $orders]);
    }

    public function show(Order $order, Request $request)
    {
        $this->authorize('own', $order);
        return view('orders.show', ['order' => $order->load(['items.productSku', 'items.product'])]);
    }

    public function received(Order $order, Request $request)
    {
        // 校验权限
        $this->authorize('own', $order);
        // 判断订单的发货状态是否已经发货
        if($order->ship_status !== Order::SHIP_STATUS_DELIVERED) {
            throw new InvalidRequestException('发货状态不正确');
        }
        // 更新发货状态
        $order->update(['ship_status' => Order::SHIP_STATUS_RECEIVED]);
        return $order;
        // 因为前端确认收货的操作从表单提交改成了 AJAX 请求，因此控制器中的返回值需修改成上面 // 返回原页面
        // return redirect()->back();
    }
}