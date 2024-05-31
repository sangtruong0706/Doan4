<?php

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\client\AuthController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\ShopController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DiscountCouponController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\TempImageController;
use App\Http\Controllers\client\LocationController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\client\LoginGoogleController;
use App\Http\Controllers\client\VnPayController;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/test', function () {
//     OrderEmail(36);
// });
//Client Route
Route::get('/', [ClientController::class, 'index'])->name('client.home');
Route::get('/shop/{categorySlug?}/{brand?}', [ShopController::class, 'index'])->name('client.shop');
Route::get('/product/{id}', [ShopController::class, 'product'])->name('client.product');
Route::get('/cart', [CartController::class, 'cart'])->name('client.cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('client.addToCart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('client.updateCart');
Route::post('/delete-cart', [CartController::class, 'deleteItem'])->name('client.deleteItem');
Route::get('/checkout', [CartController::class, 'checkout'])->name('client.checkout');
Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('client.processCheckout');
Route::get('/thank-you/{orderId?}', [CartController::class, 'thankYouOrder'])->name('client.thankYouOrder');
Route::get('/payment-failed', [CartController::class, 'paymentFailed'])->name('client.paymentFailed');
Route::get('/return/vnpay', [VnPayController::class, 'handleVNPayReturn'])->name('vnpay.return');
Route::get('/autocomplete-search', [ClientController::class, 'autocompleteSearch'])->name('client.autocompleteSearch');
// Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('client.applyDiscount');
Route::get('/apply-discount/{province_id}/{code}', [CartController::class, 'applyDiscount'])->name('client.applyDiscount');
Route::get('/remove-discount/{province_id}', [CartController::class, 'removeDiscount'])->name('client.removeDiscount');
// Route::post('/get-order-summary', [CartController::class, 'getOrderSummary'])->name('client.getOrderSummary');
Route::post('/add-to-wishlist', [ClientController::class, 'addToWishList'])->name('client.addToWishList');

// Location
Route::get('/districts/{province_id}', [LocationController::class, 'getDistricts'])->name('client.getDistricts');
Route::get('/wards/{district_id}', [LocationController::class, 'getWards'])->name('client.getWards');

// Shipping Charge
Route::get('/get-shipping-charge/{province_id}', [CartController::class, 'getShippingCharge'])->name("client.getShippingCharge");

// Login Google
Route::get('auth/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('client.redirectToGoogle');
Route::get('auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback'])->name('client.handleGoogleCallback');


Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('account.authenticate');
        Route::get('/register', [AuthController::class, 'register'])->name('account.register');
        Route::post('/process-register', [AuthController::class, 'processRegister'])->name('account.processRegister');


    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::get('/address', [AuthController::class, 'address'])->name('account.address');
        Route::post('/update-address', [AuthController::class, 'updateAddress'])->name('account.updateAddress');
        Route::get('/my-order', [AuthController::class, 'orders'])->name('account.orders');
        Route::get('/order-detail/{orderId}', [AuthController::class, 'orderDetails'])->name('account.orderDetails');
        Route::get('/wishlist', [AuthController::class, 'wishlist'])->name('account.wishlist');
        Route::post('/remove-product-from-wishlist', [AuthController::class, 'removeProductFromWishlist'])->name('account.removeProductFromWishlist');
        Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');
    });
});


Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        //Category Route
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');

        //Brands Route
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.delete');

        //Products Route
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.delete');

        // Shipping Route
        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::post('/shipping/create', [ShippingController::class, 'store'])->name('shipping.store');
        Route::get('/shipping/{shipping}/edit', [ShippingController::class, 'edit'])->name('shipping.edit');
        Route::put('/shipping/{shipping}', [ShippingController::class, 'update'])->name('shipping.update');
        Route::delete('/shipping/{shipping}', [ShippingController::class, 'destroy'])->name('shipping.delete');

        // Coupons Route
        Route::get('/coupons', [DiscountCouponController::class, 'index'])->name('coupons.index');
        Route::get('/coupons/create', [DiscountCouponController::class, 'create'])->name('coupons.create');
        Route::post('/coupons', [DiscountCouponController::class, 'store'])->name('coupons.store');
        Route::get('/coupons/{coupon}/edit', [DiscountCouponController::class, 'edit'])->name('coupons.edit');
        Route::put('/coupons/{coupon}', [DiscountCouponController::class, 'update'])->name('coupons.update');
        Route::delete('/coupons/{coupon}', [DiscountCouponController::class, 'destroy'])->name('coupons.delete');

        // Order Route
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/detail/{id}', [OrderController::class, 'detail'])->name('orders.detail');
        Route::post('/orders/change-order-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('orders.changeOrderStatus');

        //product update image
        Route::post('/product-images/update', [ProductImageController::class, 'update'])->name('product-images.update');
        Route::delete('/product-images', [ProductImageController::class, 'destroy'])->name('product-images.delete');
        //temp-images.create
        Route::post('/upload-temp-image', [TempImageController::class, 'create'])->name('temp-images.create');
        // Get slug
        Route::get('/getSlug', function(Request $request){
            $slug = "";
            if (!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');
    });
});
