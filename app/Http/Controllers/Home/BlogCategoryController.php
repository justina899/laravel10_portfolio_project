<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function AllBlogCategory(){
        $blogcategory = BlogCategory::latest()->get();
        return view('admin.blog_category.blog_category_all', compact('blogcategory'));
    } //End method

    public function AddBlogCategory(){
        return view('admin.blog_category.blog_category_add');
    } //End method

    public function StoreBlogCategory(Request $request){
        $request->validate([
            'blog_category' => 'required',
        ], [
            //validation error messages
            'blog_category.required' => 'Blog category name is required',
        ]);

        BlogCategory::insert([
            'blog_category' => $request->blog_category,
        ]);

        $notification = array(
            'message' => 'Blog category inserted successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.blog.category')->with($notification);
    } //End method

    public function EditBlogCategory($id){
        $blogcategory = BlogCategory::findOrFail($id);
        return view('admin.blog_category.blog_category_edit', compact('blogcategory'));
    } //End method

    public function UpdateBlogCategory(Request $request, $id){
        BlogCategory::findOrFail($id)->update([
            'blog_category' => $request->blog_category,
        ]);

        $notification = array(
            'message' => 'Blog category updated successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.blog.category')->with($notification);
    } //End method

    public function DeleteBlogCategory($id){
        BlogCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog category deleted successfully',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);
    } //End method

}
