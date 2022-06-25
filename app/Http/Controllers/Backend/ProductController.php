<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;


class ProductController extends Controller
{
    public function AddProduct()
    {
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        return view('backend.product.product_add', compact('categories', 'brands'));
    }
    public function StoreProduct(Request $request)
    {
        $path = public_path("upload/products/thumbnail/");
        if (!file_exists($path)) {
            mkdir($path, 0777);
        }
        $image = $request->file('product_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(917, 1000)->save('upload/products/thumbnail/' . $name_gen);
        $save_url = 'upload/products/thumbnail/' . $name_gen;

        $product_id = Product::insertGetId([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,
            'product_name_en' => $request->product_name_en,
            'product_name_cn' => $request->product_name_cn,
            'product_slug_en' =>  strtolower(str_replace(' ', '-', $request->product_name_en)),
            'product_slug_cn' => str_replace(' ', '-', $request->product_name_cn),
            'product_code' => $request->product_code,

            'product_qty' => $request->product_qty,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_cn' => $request->product_tags_cn,
            'product_size_en' => $request->product_size_en,
            'product_size_cn' => $request->product_size_cn,
            'product_color_en' => $request->product_color_en,
            'product_color_cn' => $request->product_color_cn,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp_en' => $request->short_descp_en,
            'short_descp_cn' => $request->short_descp_cn,
            'long_descp_en' => $request->long_descp_en,
            'long_descp_cn' => $request->long_descp_cn,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,

            'product_thumbnail' => $save_url,
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);


        // Multiple Image Upload START

        $direc = public_path("upload/products/multi-image/");

        if (!file_exists($direc)) {
            mkdir($direc, 0777);
        }

        $images = $request->file('multi_img');
        foreach ($images as $img) {
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(917, 1000)->save('upload/products/multi-image/' . $make_name);
            $upload_path = 'upload/products/multi-image/' . $make_name;

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' => $upload_path,
                'created_at' => Carbon::now(),
            ]);
        }
        // Multiple Image Upload END

        $notification = array(
            'message' => 'Product Added Successfully!',
            'alert-type' => 'success'
        );

        return  redirect()->route('manage-product')->with($notification);
    } //Store method END

    public function ManageProduct()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_view', compact('products'));
    }

    public function EditProduct($id)
    {
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $subsubcategories = SubSubCategory::latest()->get();
        // Get specific product data with its id. only 1 product.
        $products = Product::findOrFail($id);
        $multiImages = MultiImg::where('product_id', $id)->get();
        return view('Backend.product.product_edit', compact('brands', 'categories', 'subcategories', 'subsubcategories', 'products', 'multiImages'));
    }

    public function UpdateProduct(Request $request)
    {
        $product_id = $request->id;
        Product::findOrFail($product_id)->update([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,
            'product_name_en' => $request->product_name_en,
            'product_name_cn' => $request->product_name_cn,
            'product_slug_en' =>  strtolower(str_replace(' ', '-', $request->product_name_en)),
            'product_slug_cn' => str_replace(' ', '-', $request->product_name_cn),
            'product_code' => $request->product_code,

            'product_qty' => $request->product_qty,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_cn' => $request->product_tags_cn,
            'product_size_en' => $request->product_size_en,
            'product_size_cn' => $request->product_size_cn,
            'product_color_en' => $request->product_color_en,
            'product_color_cn' => $request->product_color_cn,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp_en' => $request->short_descp_en,
            'short_descp_cn' => $request->short_descp_cn,
            'long_descp_en' => $request->long_descp_en,
            'long_descp_cn' => $request->long_descp_cn,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Product Updated Without Image Successfully!',
            'alert-type' => 'success'
        );

        return  redirect()->route('manage-product')->with($notification);
    }

    public function UpdateProductImage(Request $request)
    {
        $images = $request->multi_img;
        foreach ($images as $id => $image) {
            $imgDel = MultiImg::findOrFail($id);
            unlink($imgDel->photo_name);

            $path = public_path("upload/products/multi-image/");
            if (!file_exists($path)) {
                mkdir($path, 0777);
            }
            $make_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(917, 1000)->save('upload/products/multi-image/' . $make_name);
            $uploadPath = 'upload/products/multi-image/' . $make_name;

            MultiImg::where('id', $id)->update([
                'photo_name' =>  $uploadPath,
                'updated_at' => Carbon::now(),
            ]);
        } //End For each
        $notification = array(
            'message' => 'Product Image Updated Successfully!',
            'alert-type' => 'info'
        );
        return  redirect()->back()->with($notification);
    } //End method

    // Product Thumbnail
    public function UpdateProductThumbnail(Request $request)
    {
        $prod_id = $request->id;
        $existing_img = $request->old_img;

        if (file_exists($existing_img)) {
            unlink($existing_img);
        }
        $path = public_path("upload/products/thumbnail/");
        if (!file_exists($path)) {
            mkdir($path, 0777);
        }
        $image = $request->file('product_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(917, 1000)->save('upload/products/thumbnail/' . $name_gen);
        $save_url = 'upload/products/thumbnail/' . $name_gen;

        Product::findOrFail($prod_id)->update([
            'product_thumbnail' =>  $save_url,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Product Thumbnail Image Updated Successfully!',
            'alert-type' => 'info'
        );
        return  redirect()->back()->with($notification);
    } //End Method

    public function DeleteProductMultiImage($id)
    {
        $old_img = MultiImg::findOrFail($id);
        $existing_img = $old_img->photo_name;
        if (file_exists($existing_img)) {
            unlink($existing_img);
        }
        MultiImg::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product Images Deleted Successfully!',
            'alert-type' => 'success'
        );
        return  redirect()->back()->with($notification);
    } //End Method

    public function InactiveProduct($id)
    {
        Product::findOrFail($id)->update(['status' => 0]);

        $notification = array(
            'message' => 'Product Inactive',
            'alert-type' => 'success'
        );
        return  redirect()->back()->with($notification);
    } //End Method

    public function ActiveProduct($id)
    {
        Product::findOrFail($id)->update(['status' => 1]);

        $notification = array(
            'message' => 'Product Active',
            'alert-type' => 'success'
        );
        return  redirect()->back()->with($notification);
    }

    public function DeleteProduct($id)
    {
        $product =  Product::findOrFail($id);
        $product_image = $product->product_thumbnail;
        if (file_exists($product_image)) {
            unlink($product_image);
        }
        Product::findOrFail($id)->delete();

        $multi_images = MultiImg::where('product_id', $id)->get();
        foreach ($multi_images as $image) {

            if (file_exists($image->photo_name)) {
                unlink($image->photo_name);
            }
            MultiImg::where('product_id', $id)->delete();
        } // End Foreach
        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        );
        return  redirect()->back()->with($notification);
    } //End Method
}