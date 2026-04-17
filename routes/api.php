<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DiscountCodeController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\ProductTagController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\Api\ShipmentController;
use App\Http\Controllers\Api\ShippingZoneController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\TemplateController;
use Illuminate\Support\Facades\Route;

// ==============================
// Public Auth Routes
// ==============================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// ==============================
// Protected Routes
// ==============================
Route::middleware('auth:api')->group(function () {

    // Auth
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Templates (public list, auth for apply)
    Route::get('/templates', [TemplateController::class, 'index']);
    Route::get('/templates/{template}', [TemplateController::class, 'show']);

    // Stores
    Route::post('/auth/stores', [StoreController::class, 'store']);
    Route::get('/stores', [StoreController::class, 'index']);
    Route::get('/stores/{store:slug}', [StoreController::class, 'show']);

    // ==============================
    // Store-scoped Resources
    // ==============================
    Route::prefix('/stores/{store}')->group(function () {

        // Templates — apply to store
        Route::post('/apply-template/{template}', [TemplateController::class, 'apply']);

        // Categories
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::get('/categories/{category}', [CategoryController::class, 'show']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        // Products
        Route::get('/products', [ProductController::class, 'index']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::get('/products/{product}', [ProductController::class, 'show']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        // Product Variants
        Route::get('/products/{product}/variants', [ProductVariantController::class, 'index']);
        Route::post('/products/{product}/variants', [ProductVariantController::class, 'store']);
        Route::put('/products/{product}/variants/{variant}', [ProductVariantController::class, 'update']);
        Route::delete('/products/{product}/variants/{variant}', [ProductVariantController::class, 'destroy']);

        // Product Images
        Route::get('/products/{product}/images', [ProductImageController::class, 'index']);
        Route::post('/products/{product}/images', [ProductImageController::class, 'store']);
        Route::delete('/products/{product}/images/{image}', [ProductImageController::class, 'destroy']);

        // Product Tags
        Route::get('/tags', [ProductTagController::class, 'index']);
        Route::post('/tags', [ProductTagController::class, 'store']);
        Route::put('/tags/{tag}', [ProductTagController::class, 'update']);
        Route::delete('/tags/{tag}', [ProductTagController::class, 'destroy']);

        // Customers
        Route::get('/customers', [CustomerController::class, 'index']);
        Route::post('/customers', [CustomerController::class, 'store']);
        Route::get('/customers/{customer}', [CustomerController::class, 'show']);
        Route::put('/customers/{customer}', [CustomerController::class, 'update']);
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);

        // Customer Addresses
        Route::get('/customers/{customer}/addresses', [AddressController::class, 'index']);
        Route::post('/customers/{customer}/addresses', [AddressController::class, 'store']);
        Route::put('/customers/{customer}/addresses/{address}', [AddressController::class, 'update']);
        Route::delete('/customers/{customer}/addresses/{address}', [AddressController::class, 'destroy']);

        // Orders
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);
        Route::delete('/orders/{order}', [OrderController::class, 'destroy']);

        // Shipping Zones
        Route::get('/shipping-zones', [ShippingZoneController::class, 'index']);
        Route::post('/shipping-zones', [ShippingZoneController::class, 'store']);
        Route::put('/shipping-zones/{zone}', [ShippingZoneController::class, 'update']);
        Route::delete('/shipping-zones/{zone}', [ShippingZoneController::class, 'destroy']);

        // Shipments
        Route::get('/shipments', [ShipmentController::class, 'index']);
        Route::get('/shipments/{shipment}', [ShipmentController::class, 'show']);
        Route::patch('/shipments/{shipment}/status', [ShipmentController::class, 'updateStatus']);
        Route::patch('/shipments/{shipment}/assign', [ShipmentController::class, 'assignDriver']);

        // Drivers
        Route::get('/drivers', [DriverController::class, 'index']);
        Route::post('/drivers', [DriverController::class, 'store']);
        Route::get('/drivers/{driver}', [DriverController::class, 'show']);
        Route::put('/drivers/{driver}', [DriverController::class, 'update']);
        Route::delete('/drivers/{driver}', [DriverController::class, 'destroy']);

        // Discount Codes
        Route::get('/discount-codes', [DiscountCodeController::class, 'index']);
        Route::post('/discount-codes', [DiscountCodeController::class, 'store']);
        Route::put('/discount-codes/{discount}', [DiscountCodeController::class, 'update']);
        Route::delete('/discount-codes/{discount}', [DiscountCodeController::class, 'destroy']);
    });
});
