<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ==========================================
    // DASHBOARD ADMIN
    // ==========================================
    public function dashboard()
    {
        // ==========================================
        // THỐNG KÊ CHUNG
        // ==========================================
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();

        $totalCustomers = User::where(
            'role',
            'customer'
        )->count();

        // Chỉ tính doanh thu đơn giao thành công
        $totalRevenue = Order::where(
            'status',
            'delivered'
        )->sum('total_price');

        // Doanh thu hôm nay
        $todayRevenue = Order::where(
            'status',
            'delivered'
        )
        ->whereDate(
            'created_at',
            Carbon::today()
        )
        ->sum('total_price');

        // Doanh thu tháng hiện tại
        $monthRevenue = Order::where(
            'status',
            'delivered'
        )
        ->whereYear(
            'created_at',
            Carbon::now()->year
        )
        ->whereMonth(
            'created_at',
            Carbon::now()->month
        )
        ->sum('total_price');

        // Tổng đơn tạo hôm nay
        $todayOrders = Order::whereDate(
            'created_at',
            Carbon::today()
        )->count();

        // Giá trị trung bình của các đơn đã giao
        $averageOrderValue = $deliveredOrderCountForAverage =
            Order::where('status', 'delivered')->count();

        $averageOrderValue = $deliveredOrderCountForAverage > 0
            ? $totalRevenue / $deliveredOrderCountForAverage
            : 0;

        // Tỷ lệ hủy trên tổng số đơn
        $cancelRate = $totalOrders > 0
            ? round(
                (
                    Order::where('status', 'cancelled')->count()
                    / $totalOrders
                ) * 100,
                1
            )
            : 0;

        // ==========================================
        // TRẠNG THÁI ĐƠN
        // ==========================================
        $pendingOrders = Order::where(
            'status',
            'pending'
        )->count();

        $confirmedOrders = Order::where(
            'status',
            'confirmed'
        )->count();

        $shippingOrders = Order::where(
            'status',
            'shipped'
        )->count();

        $deliveredOrders = Order::where(
            'status',
            'delivered'
        )->count();

        $cancelledOrders = Order::where(
            'status',
            'cancelled'
        )->count();

        // ==========================================
        // BIỂU ĐỒ DOANH THU 7 NGÀY
        // ==========================================
        $startDate = Carbon::today()->subDays(6);

        $revenueRows = Order::query()
            ->selectRaw(
                'DATE(created_at) as order_date, SUM(total_price) as revenue'
            )
            ->where('status', 'delivered')
            ->whereDate('created_at', '>=', $startDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('order_date');

        $revenueLabels = [];
        $revenueData = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $key = $date->format('Y-m-d');

            $revenueLabels[] = $date->format('d/m');
            $revenueData[] = isset($revenueRows[$key])
                ? (float) $revenueRows[$key]->revenue
                : 0;
        }

        // ==========================================
        // BIỂU ĐỒ DOANH THU 30 NGÀY
        // ==========================================
        $start30 = Carbon::today()->subDays(29);

        $revenue30Rows = Order::query()
            ->selectRaw(
                'DATE(created_at) as order_date, SUM(total_price) as revenue'
            )
            ->where('status', 'delivered')
            ->whereDate('created_at', '>=', $start30)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('order_date');

        $revenue30Labels = [];
        $revenue30Data = [];

        for ($i = 0; $i < 30; $i++) {
            $date = $start30->copy()->addDays($i);
            $key = $date->format('Y-m-d');

            $revenue30Labels[] = $date->format('d/m');
            $revenue30Data[] = isset($revenue30Rows[$key])
                ? (float) $revenue30Rows[$key]->revenue
                : 0;
        }

        // ==========================================
        // BIỂU ĐỒ DOANH THU 12 THÁNG
        // ==========================================
        $startMonth = Carbon::now()
            ->startOfMonth()
            ->subMonths(11);

        $revenue12Rows = Order::query()
            ->selectRaw(
                'YEAR(created_at) as y, MONTH(created_at) as m, SUM(total_price) as revenue'
            )
            ->where('status', 'delivered')
            ->whereDate('created_at', '>=', $startMonth)
            ->groupBy(
                DB::raw('YEAR(created_at)'),
                DB::raw('MONTH(created_at)')
            )
            ->orderBy(DB::raw('YEAR(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->keyBy(function ($row) {
                return $row->y . '-' . str_pad(
                    $row->m,
                    2,
                    '0',
                    STR_PAD_LEFT
                );
            });

        $revenue12Labels = [];
        $revenue12Data = [];

        for ($i = 0; $i < 12; $i++) {
            $date = $startMonth->copy()->addMonths($i);
            $key = $date->format('Y-m');

            $revenue12Labels[] = $date->format('m/Y');
            $revenue12Data[] = isset($revenue12Rows[$key])
                ? (float) $revenue12Rows[$key]->revenue
                : 0;
        }

        // ==========================================
        // TOP 5 SẢN PHẨM BÁN CHẠY
        // ==========================================
        $topProducts = OrderItem::query()
            ->select(
                'product_id',
                DB::raw(
                    'SUM(order_items.quantity) as total_sold'
                ),
                DB::raw(
                    'SUM(order_items.quantity * order_items.price) as total_sales'
                )
            )
            ->whereHas(
                'order',
                function ($query) {
                    $query->where(
                        'status',
                        'delivered'
                    );
                }
            )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // ==========================================
        // SẢN PHẨM SẮP HẾT
        // ==========================================
        $lowStockProducts = Product::query()
            ->where('quantity', '>', 0)
            ->whereRaw(
                'quantity <= (min_quantity * 5)'
            )
            ->orderByRaw(
                'quantity / NULLIF(min_quantity, 0) ASC'
            )
            ->take(6)
            ->get();

        // Sản phẩm hết hàng
        $outOfStockProducts = Product::where(
            'quantity',
            '<=',
            0
        )->count();

        // ==========================================
        // ĐƠN HÀNG MỚI
        // ==========================================
        $recentOrders = Order::with('user')
            ->latest()
            ->take(6)
            ->get();

        return view(
            'admin.dashboard',
            compact(
                'totalProducts',
                'totalCategories',
                'totalOrders',
                'totalCustomers',
                'totalRevenue',
                'todayRevenue',
                'monthRevenue',
                'todayOrders',
                'averageOrderValue',
                'cancelRate',
                'pendingOrders',
                'confirmedOrders',
                'shippingOrders',
                'deliveredOrders',
                'cancelledOrders',
                'revenueLabels',
                'revenueData',
                'revenue30Labels',
                'revenue30Data',
                'revenue12Labels',
                'revenue12Data',
                'topProducts',
                'lowStockProducts',
                'outOfStockProducts',
                'recentOrders'
            )
        );
    }

    // ==========================================
    // 🔔 ĐỌC MỘT THÔNG BÁO
    // ==========================================
    public function readNotification(string $notification)
    {
        $admin = Auth::user();

        $notificationItem = $admin
            ->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        if (is_null($notificationItem->read_at)) {
            $notificationItem->markAsRead();
        }

        $data = $notificationItem->data ?? [];

        if (!empty($data['order_id'])) {
            $order = Order::find($data['order_id']);

            if ($order) {
                return redirect()->route(
                    'admin.orders.show',
                    $order->id
                );
            }
        }

        if (!empty($data['url'])) {
            return redirect()->to($data['url']);
        }

        return redirect()
            ->route('admin.orders.index');
    }

    // ==========================================
    // 🔔 ĐÁNH DẤU TẤT CẢ THÔNG BÁO ĐÃ ĐỌC
    // ==========================================
    public function readAllNotifications(Request $request)
    {
        $admin = Auth::user();

        $admin
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        return back()->with(
            'success',
            'Đã đánh dấu tất cả thông báo là đã đọc.'
        );
    }

    // ==========================================
    // HỒ SƠ ADMIN
    // ==========================================
    public function profile()
    {
        $admin = Auth::user();

        return view(
            'admin.profile',
            compact('admin')
        );
    }
}
