<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\CartPageController;
use App\Http\Controllers\User\CheckoutController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Routing\RouteGroup;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// HOME PAGE ROUTE

Route::get('/', [IndexController::class, 'index']);


// User Routesphp

// USER DASHBOARD
Route::middleware(['auth:web', 'verified'])->get('/dashboard', function () {
    $id = Auth::user()->id;
    $user = User::find($id);
    return view('dashboard', compact('user'));
})->name('dashboard');


// User PROFILE ROUTES
Route::get('/user/profile', [IndexController::class, 'UserProfile'])->name('user.profile');

Route::post('/user/profile/store', [IndexController::class, 'UserProfileStore'])->name('user.profile.store');

Route::get('/user/change/password', [IndexController::class, 'UserChangePassword'])->name('change.password');

Route::post('/user/password/update', [IndexController::class, 'UserPasswordUpdate'])->name('user.password.update');

Route::get('/user/logout', [IndexController::class, 'UserLogout'])->name('user.logout');



// All Admin Routes

// Admin Login/Logout
Route::group(['prefix' => 'admin', 'middleware' => ['admin:admin']], function () {
    Route::get('/login', [AdminController::class, 'loginForm']);

    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
    Route::get('/logout', [AdminController::class, 'destroy'])->name('admin.logout');
});

//Admin Dashboard
Route::middleware(['auth:sanctum,admin', 'verified'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard')->middleware('auth:admin');
});

Route::middleware(['auth:admin'])->group(function () {


    //ADMIN PROFILE ROUTES
    Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');

    Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');

    Route::post('/admin/profile/store', [AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');

    Route::get('/admin/change/password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');

    Route::post('/update/change/password', [AdminProfileController::class, 'AdminUpdateChangePassword'])->name('update.change.password');
});
// Admin Brand All Routes

Route::prefix('brand')->group(function () {
    Route::get('/view', [BrandController::class, 'BrandView'])->name('all.brand');

    Route::post('/store', [BrandController::class, 'BrandStore'])->name('brand.store');

    Route::get('/edit/{id}', [BrandController::class, 'BrandEdit'])->name('brand.edit');

    Route::post('/update', [BrandController::class, 'BrandUpdate'])->name('brand.update');

    Route::get('/delete/{id}', [BrandController::class, 'BrandDelete'])->name('brand.delete');
});

// Admin Category All Routes
Route::prefix('category')->group(function () {
    Route::get('/view', [CategoryController::class, 'CategoryView'])->name('all.category');

    Route::post('/store', [CategoryController::class, 'CategoryStore'])->name('category.store');

    Route::get('/edit/{id}', [CategoryController::class, 'CategoryEdit'])->name('category.edit');

    Route::post('/update', [CategoryController::class, 'CategoryUpdate'])->name('category.update');

    Route::get('/delete/{id}', [CategoryController::class, 'CategoryDelete'])->name('category.delete');


    //Admin Sub Category All Routes
    Route::get('/sub/view', [SubCategoryController::class, 'SubCategoryView'])->name('all.subcategory');

    Route::post('/sub/store', [SubCategoryController::class, 'SubCategoryStore'])->name('subcategory.store');

    Route::get('/sub/edit/{id}', [SubCategoryController::class, 'SubCategoryEdit'])->name('subcategory.edit');

    Route::post('/sub/update', [SubCategoryController::class, 'SubCategoryUpdate'])->name('subcategory.update');

    Route::get('/sub/delete/{id}', [SubCategoryController::class, 'SubCategoryDelete'])->name('subcategory.delete');


    // Admin Sub-> Sub Category All Routes
    Route::get('/sub/sub/view', [SubCategoryController::class, 'SubSubCategoryView'])->name('all.subsubcategory');

    Route::get('/subcategory/ajax/{category_id}', [SubCategoryController::class, 'GetSubCategory']);

    // Product_add ajax fetch subcategory using subcategory id, then show subsubcategory depending on selected dropdown subcategory
    Route::get('/sub-subcategory/ajax/{subcategory_id}', [SubCategoryController::class, 'GetSubSubCategory']);

    Route::post('sub/sub/store', [SubCategoryController::class, 'SubSubCategoryStore'])->name('subsubcategory.store');

    Route::get('sub/sub/edit/{id}', [SubCategoryController::class, 'SubSubCategoryEdit'])->name('subsubcategory.edit');

    Route::post('sub/sub/update', [SubCategoryController::class, 'SubSubCategoryUpdate'])->name('subsubcategory.update');

    Route::get('sub/sub/delete/{id}', [SubCategoryController::class, 'SubSubCategoryDelete'])->name('subsubcategory.delete');
});

// Admin Products All Routes

Route::prefix('product')->group(function () {
    // Product CRUD
    Route::get('/add', [ProductController::class, 'AddProduct'])->name('add-product');

    Route::post('/store', [ProductController::class, 'StoreProduct'])->name('store-product');

    Route::get('/manage', [ProductController::class, 'ManageProduct'])->name('manage-product');

    Route::get('/edit/{id}', [ProductController::class, 'EditProduct'])->name('product.edit');

    Route::post('/update', [ProductController::class, 'UpdateProduct'])->name('update-product');

    Route::get('/delete/{id}', [ProductController::class, 'DeleteProduct'])->name('delete-product');


    // Product images Routes
    Route::post('/image/update', [ProductController::class, 'UpdateProductImage'])->name('update-product-image');

    Route::post('/thumbnail/update', [ProductController::class, 'UpdateProductThumbnail'])->name('update-product-thumbnail');

    Route::get('/mutliimage/delete/{id}', [ProductController::class, 'DeleteProductMultiImage'])->name('delete-product-multiImage');

    // Product Status
    Route::get('/inactive/{id}', [ProductController::class, 'InactiveProduct'])->name('inactive.product');

    Route::get('/active/{id}', [ProductController::class, 'ActiveProduct'])->name('active.product');
});


//  Slider Routes
Route::prefix('slider')->group(function () {
    Route::get('/view', [SliderController::class, 'SliderView'])->name('manage-slider');

    Route::post('/store', [SliderController::class, 'SliderStore'])->name('slider.store');

    Route::get('/edit/{id}', [SliderController::class, 'SliderEdit'])->name('slider.edit');

    Route::post('/update', [SliderController::class, 'SliderUpdate'])->name('slider.update');

    Route::get('/delete/{id}', [SliderController::class, 'SliderDelete'])->name('slider.delete');

    // Slider Status
    Route::get('/inactive/{id}', [SliderController::class, 'InactiveSlider'])->name('inactive.slider');

    Route::get('/active/{id}', [SliderController::class, 'ActiveSlider'])->name('active.slider');
});

// FRONTEND ALL ROUTES
//MULTI LANGUAGE ALL ROUTES


Route::get('/language/english', [LanguageController::class, 'English'])->name('english.language');
Route::get('/language/chinese', [LanguageController::class, 'Chinese'])->name('chinese.language');

// Product details Page
Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetails']);

// Product Tags
Route::get('/product/tag/{tag}', [IndexController::class, 'ProductTag']);

// Frontend SubCategory wise data
Route::get('/subcategory/{subcat_id}/{slug}', [IndexController::class, 'ProductbySubCat']);

// Frontend Sub SubCategory wise data
Route::get('/subsubcategory/{subsubcat_id}/{slug}', [IndexController::class, 'ProductbySubSubCat']);

// Product View Modal with AJAX
Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']);

// Product Add to Cart Store DATA
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);

// GET data from mini cart
Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);

//Remove Item from mini cart
Route::get('/product/minicart/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);

//Add to WishList
Route::post('/add-to-wishlist/{product_id}', [CartController::class, 'AddToWishlist']);

Route::group(
    [
        'prefix' => 'user', 'middleware' => ['user', 'auth'],
        'namespace' => 'User'
    ],
    function () {
        // Wishlist Page View
        Route::get('/wishlist', [WishlistController::class, 'ViewWishlist'])->name('wishlist');
        // Wishlist Page Load Data AJAX
        Route::get('/get-wishlist-product', [WishlistController::class, 'GetWishlistProduct']);
        // Wishlist Remove Product AJAX
        Route::get('/wishlist-remove/{id}', [WishlistController::class, 'RemoveWishlistProduct']);
    }
);

//   Cart Page
Route::get('/mycart', [CartPageController::class, 'MyCart'])->name('mycart');
//  GET Cart Products
Route::get('/get-cart-product', [CartPageController::class, 'GetCartProduct']);
// Remove  Cart Products
Route::get('/cart-remove/{rowId}', [CartPageController::class, 'RemoveCartProduct']);
// Increment Cart Item
Route::get('/cart-increment/{rowId}', [CartPageController::class, 'CartIncrement']);
// Decrement Cart Item
Route::get('/cart-decrement/{rowId}', [CartPageController::class, 'CartDecrement']);


//  Admin Coupon Routes
Route::prefix('coupon')->group(function () {
    Route::get('/view', [CouponController::class, 'CouponView'])->name('manage-coupon');
    Route::post('/store', [CouponController::class, 'CouponStore'])->name('coupon.store');
    Route::get('/edit/{id}', [CouponController::class, 'CouponEdit'])->name('coupon.edit');
    Route::post('/update/{id}', [CouponController::class, 'CouponUpdate'])->name('coupon.update');
    Route::get('/delete/{id}', [CouponController::class, 'CouponDelete'])->name('coupon.delete');
});

//  Admin Shipping Area Routes
Route::prefix('shipping')->group(function () {
    // Shipping Division
    Route::get('/division/view', [ShippingAreaController::class, 'DivisionView'])->name('manage-division');

    Route::post('/division/store', [ShippingAreaController::class, 'DivisionStore'])->name('division.store');

    Route::get('/division/edit/{id}', [ShippingAreaController::class, 'DivisionEdit'])->name('division.edit');

    Route::post('/division/update/{id}', [ShippingAreaController::class, 'DivisionUpdate'])->name('division.update');

    Route::get('/division/delete/{id}', [ShippingAreaController::class, 'DivisionDelete'])->name('division.delete');

    // Shipping District
    Route::get('/district/view', [ShippingAreaController::class, 'DistrictView'])->name('manage-district');

    Route::post('/district/store', [ShippingAreaController::class, 'DistrictStore'])->name('district.store');

    Route::get('/district/edit/{id}', [ShippingAreaController::class, 'DistrictEdit'])->name('district.edit');

    Route::post('/district/update/{id}', [ShippingAreaController::class, 'DistrictUpdate'])->name('district.update');

    Route::get('/district/delete/{id}', [ShippingAreaController::class, 'DistrictDelete'])->name('district.delete');

    // Shipping State
    Route::get('/state/view', [ShippingAreaController::class, 'StateView'])->name('manage-state');

    Route::post('/state/store', [ShippingAreaController::class, 'StateStore'])->name('state.store');

    Route::get('/state/edit/{id}', [ShippingAreaController::class, 'StateEdit'])->name('state.edit');

    Route::post('/state/update/{id}', [ShippingAreaController::class, 'StateUpdate'])->name('state.update');

    Route::get('/state/delete/{id}', [ShippingAreaController::class, 'StateDelete'])->name('state.delete');
});


/////Frontend Apply & Remove Coupon

Route::post('/coupon-apply', [CartController::class, 'CouponApply']);
Route::get('/coupon-cal', [CartController::class, 'CouponCal']);

Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);

// CheckOut Routes
Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');

// Checkout View Page Responsive form-group Selection w/ AJAX
Route::get('/district-get/ajax/{division_id}', [CheckoutController::class, 'DistrictGetAjax']);

Route::get('/state-get/ajax/{district_id}', [CheckoutController::class, 'StateGetAjax']);

// Checkout Store
Route::post('/checkout/store', [CheckoutController::class, 'CheckoutStore'])->name('checkout.store');