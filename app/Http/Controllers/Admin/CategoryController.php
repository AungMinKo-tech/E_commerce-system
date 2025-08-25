<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    //redirect category page
    public function listCategory(){
        $categories = Category::withCount('products')->paginate(5);
        // $products = Product::get();
        // dd($categories);
        return view('admin.category.list', compact('categories'));
    }

    public function categoryCreate(Request $request){
        $this->checkValidate($request);

        Category::create([
            'name'=> $request->name,
        ]);

        Alert::success('Success', 'အမျိုးအစားအမည်ကို အောင်မြင်စွာ ထည့်သွင်းပြီးပါပြီ။');

        return back();
    }

    //edit category page
    public function editCategory($id){
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    //update category
    public function updateCategory(Request $request, $id){
        $request->id = $id;
        $this->checkValidate($request);

        Category::where('id', $id)->update([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'အမျိုးအစားအမည်ကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');

        return redirect()->route('admin#category');
    }

    //delete category
    public function deleteCategory($id){
        Category::where('id', $id)->delete();

        return back();
    }

    //check validate
    private function checkValidate($request){
        $request->validate([
            'name' => 'required|min:3|max:30|unique:categories,name,'.$request->id
        ],[
            'name.required'=> 'ကျေးဇူးပြု၍ အမျိုးအစားအမည်ကို ထည့်သွင်းပါ။',
            'name.min' => 'အမျိုးအစားအမည်သည် အနည်းဆုံး စာလုံး 3 လုံးရှိရမည်။',
            'name.max'=> 'အမျိုးအစားအမည်သည် စာလုံး 20 ထက်မပိုရပါ။'
        ]);
    }
}
