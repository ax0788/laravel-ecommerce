<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ShipDivison;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id)
    {
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        $product = Product::findOrFail($id);
        if ($product->discount_price == null) {
            Cart::add([
                'id' =>  $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->selling_price,
                'weight' => 1,
                'options' => [
                    'image' => $product->product_thumbnail,
                    'color' => $request->color,
                    'size' =>  $request->size,
                ]
            ]);
            return response()->json(['success' => 'Successfully Added to Cart']);
        } else {

            Cart::add([
                'id' =>  $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->discount_price,
                'weight' => 1,
                'options' => [
                    'image' => $product->product_thumbnail,
                    'color' => $request->color,
                    'size' =>  $request->size,
                ]
            ]);
            return response()->json(['success' => 'Successfully Added to Cart']);
        }
    }

    public function AddMiniCart()
    {
        $cartData = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();
        return response()->json(array(
            'cartData' => $cartData,
            'cartQty' => $cartQty,
            'cartTotal' => round($cartTotal),
        ));
    }

    public function RemoveMiniCart($rowId)
    {
        Cart::remove($rowId);
        return response()->json(['success' => 'Product Removed from Cart']);
    }

    public function AddToWishlist(Request $request, $product_id)
    {
        if (Auth::check()) {

            $exists = Wishlist::where('user_id', Auth::id())->where('product_id', $product_id)->first();
            if (!$exists) {
                Wishlist::insert([
                    'user_id' => Auth::id(),
                    'product_id' => $product_id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['success' => 'Product Successfully Added to Wishlist']);
            } else {
                return response()->json(['error' => 'This Product is Already in your Wishlist']);
            }
        } else {
            return response()->json(['error' => 'Please Login to your Account']);
        };
    }

    public function CouponApply(Request $request)
    {
        $coupon = Coupon::where('coupon_name', $request->coupon_name)->where('coupon_validity', '>=', Carbon::now()->format('Y-m-d'))->first();
        if ($coupon) {
            Session::put('coupon', [
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount / 100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount / 100),
            ]);
            return response()->json(array(
                'validity' => true,
                'success' => 'Coupon Applied Sucessfully!'
            ));
        } else {
            return response()->json(['error' => 'Invalid Coupon']);
        }
    }

    public function CouponCal()
    {
        if (Session::has('coupon')) {
            return response()->json([
                'subtotal' => Cart::total(),
                'coupon_name'   => session()->get('coupon')['coupon_name'],
                'coupon_discount' => session()->get('coupon')['coupon_discount'],
                'discount_amount' => session()->get('coupon')['discount_amount'],
                'total_amount' =>  session()->get('coupon')['total_amount'],
            ]);
        } else {
            return response()->json([
                'total' => Cart::total(),
            ]);
        }
    }

    public function CouponRemove()
    {
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon Removed Successfully!']);
    }

    //Checkout
    public function CheckoutCreate()
    {
        if (Auth::check()) {
            if (Cart::total() > 0) {
                $cartData = Cart::content();
                $cartQty = Cart::count();
                $cartTotal = Cart::total();
                $divisions = ShipDivison::orderBy('division_name', 'ASC')->get();
                return view('frontend.checkout.checkout_view', compact('cartData', 'cartQty', 'cartTotal', 'divisions'));
            } else {
                $notification = array(
                    'message' => 'Your Cart Is Empty!',
                    'alert-type' => 'error'
                );
                return  redirect()->to('/')->with($notification);
            }
        } else {
            $notification = array(
                'message' => 'You Need to Login First!',
                'alert-type' => 'error'
            );
            return  redirect()->route('login')->with($notification);
        }
    }
}