<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Slider;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $sliders = Slider::where('status', 1)->orderBy('id', 'DESC')->limit(3)->get();
        $products = Product::where('status', 1)->orderBy('id', 'DESC')->get();
        $featured = Product::where('featured', 1)->limit(6)->orderBy('id', 'DESC')->get();

        $hot_deals = Product::where('hot_deals', 1)->where('discount_price', '!=', Null)->limit(3)->orderBy('id', 'DESC')->get();

        $special_offer = Product::where('special_offer', 1)->limit(3)->orderBy('id', 'DESC')->get();
        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Product::where('status', 1)->where('category_id', $skip_category_0->id)->orderBy('id', 'DESC')->get();

        $skip_category_1 = Category::skip(1)->first();
        $skip_product_1 = Product::where('status', 1)->where('category_id', $skip_category_1->id)->orderBy('id', 'DESC')->get();

        $skip_brand_0 = Brand::skip(0)->first();
        $skip_brand_product_0 = Product::where('status', 1)->where('brand_id', $skip_brand_0->id)->orderBy('id', 'DESC')->get();


        return view('frontend.index', compact('categories', 'sliders', 'products', 'featured', 'hot_deals', 'special_offer', 'skip_category_0', 'skip_product_0', 'skip_category_1', 'skip_product_1', 'skip_brand_0', 'skip_brand_product_0'));
    }
    public function UserLogout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
    public function UserProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('frontend.profile.user_profile', compact('user'));
    }

    public function UserProfileStore(Request $request)
    {
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        if ($file = $request->file('profile_photo_path')) {
            unlink('upload/user_images/' . $data->profile_photo_path);
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['profile_photo_path'] = $filename;
        };

        $notification = array(
            'message' => 'User Profile Updated Successfully!',
            'alert-type' => 'success'
        );

        $data->save();
        return  redirect()->route('user.profile')->with($notification);
    }

    public function UserChangePassword()
    {
        // QUERY Builder Style: $user= DB::table('users')->where('id', Auth::user()->id)->first()
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.change_password', compact('user'));
    }
    public function UserPasswordUpdate(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        $userPassword = Auth::user()->password;


        if (Hash::check($request->current_password, $userPassword)) {
            $user = User::find(Auth::id());
            // pass entered password by user, and make it a hash password
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route(('user.logout'));
        } else {
            return redirect()->back();
        }
    }

    public function ProductDetails($id, $slug)
    {
        $product = Product::findOrFail($id);
        $multiImage = MultiImg::where('product_id', $id)->get();
        return view('frontend.product.product_details', compact('product', 'multiImage'));
    }

    public function ProductTag($tag)
    {
        $products = Product::where('status', 1)->where('product_tags_en', $tag)->orWhere('product_tags_cn', $tag)->orderBy('id', 'DESC')->paginate(3);
        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        return view('frontend.tags.tags_view', compact('products', 'categories'));
    }
}