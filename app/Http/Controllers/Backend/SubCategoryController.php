<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
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


    public function SubCategoryDelete($id)
    {
        SubCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'SubCategory Deleted Successfully!',
            'alert-type' => 'info'
        );

        return  redirect()->back()->with($notification);
    }
    //////////////////////////////SUB SUBCATEGORY////////////////////////

    public function SubSubCategoryView()
    {
        // Pass foriegn Key categories data & subcategories
        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subsubcategory = SubSubCategory::latest()->get();
        return view('Backend.category.sub_subcategory_view', compact('subsubcategory', 'categories'));
    }
    // Route to get SubCategory data and pass it to the option field in sub_subcategory_view page.
    public function GetSubCategory($category_id)
    {
        $subcategoryitem = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name_en', 'ASC')->get();
        return json_encode($subcategoryitem);
    }
    public function SubSubCategoryStore(Request $request)
    {
        $request->validate(
            [
                'category_id' => 'required',
                'subcategory_id' => 'required',
                'subsubcategory_name_en' => 'required',
                'subsubcategory_name_cn' => 'required',
            ],
            [
                'category_id.required' => 'Please Select any Option',
                'subsubcategory_name_en.required' => 'Please Input Sub-SubCategory English Name',
                'subsubcategory_name_cn.required' => 'Please Input Sub-SubCategory Chinese Name',

            ]
        );

        SubSubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name_en' => $request->subsubcategory_name_en,
            'subsubcategory_name_cn' => $request->subsubcategory_name_cn,
            'subsubcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subsubcategory_name_en)),
            'subsubcategory_slug_cn' => str_replace(' ', '-', $request->subsubcategory_name_cn),
        ]);

        $notification = array(
            'message' => 'Sub-SubCategory Added Successfully!',
            'alert-type' => 'success'
        );

        return  redirect()->back()->with($notification);
    }

    public function SubSubCategoryEdit($id)
    {
        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subcategories = SubCategory::orderBy('subcategory_name_en', 'ASC')->get();
        $subsubcategories = SubSubCategory::findOrFail($id);
        return view('Backend.category.sub_subcategory_edit', compact('categories', 'subcategories', 'subsubcategories'));
    }
    public function SubSubCategoryUpdate(Request $request)
    {
        $subsubcategory_id = $request->id;


        SubSubCategory::findOrFail($subsubcategory_id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name_en' => $request->subsubcategory_name_en,
            'subsubcategory_name_cn' => $request->subsubcategory_name_cn,
            'subsubcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subsubcategory_name_en)),
            'subsubcategory_slug_cn' => str_replace(' ', '-', $request->subsubcategory_name_cn),
        ]);

        $notification = array(
            'message' => 'Sub-SubCategory Updated Successfully!',
            'alert-type' => 'success'
        );

        return  redirect()->route('all.subsubcategory')->with($notification);
    }

    public function SubSubCategoryDelete($id)
    {
        SubSubCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Sub-SubCategory Deleted Successfully!',
            'alert-type' => 'info'
        );

        return  redirect()->back()->with($notification);
    }
}