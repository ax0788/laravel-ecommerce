<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function SubCategoryView()
    {
        // Pass foriegn Key categories data
        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subcategory = SubCategory::latest()->get();
        return view('Backend.category.subcategory_view', compact('subcategory', 'categories'));
    }
    public function SubCategoryStore(Request $request)
    {

        $request->validate(
            [
                'category_id' => 'required',
                'subcategory_name_en' => 'required',
                'subcategory_name_cn' => 'required',
            ],
            [
                'category_id.required' => 'Please Select a Category',
                'subcategory_name_en.required' => 'Please Input Category English Name',
                'subcategory_name_cn.required' => 'Please Input Category Chinese Name',

            ]
        );

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_cn' => $request->subcategory_name_cn,
            'subcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subcategory_name_en)),
            'subcategory_slug_cn' => str_replace(' ', '-', $request->subcategory_name_cn),
        ]);

        $notification = array(
            'message' => 'SubCategory Added Successfully!',
            'alert-type' => 'success'
        );

        return  redirect()->back()->with($notification);
    }

    public function SubCategoryEdit($id)
    {
        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subcategory = SubCategory::findOrFail($id);
        return view('Backend.category.subcategory_edit', compact('subcategory', 'categories'));
    }

    public function SubCategoryUpdate(Request $request)
    {
        $subcat_id = $request->id;
        SubCategory::findOrFail($subcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_cn' => $request->subcategory_name_cn,
            'subcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subcategory_name_en)),
            'subcategory_slug_cn' => str_replace(' ', '-', $request->subcategory_name_cn),
        ]);

        $notification = array(
            'message' => 'SubCategory Updated Successfully!',
            'alert-type' => 'info'
        );

        return  redirect()->route('all.subcategory')->with($notification);
    }


    public function SubCategoryDelete($id) {
        SubCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'SubCategory Deleted Successfully!',
            'alert-type' => 'info'
        );

        return  redirect()->back()->with($notification);
    }
}