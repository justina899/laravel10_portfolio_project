<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Carbon;

class BlogController extends Controller
{
    public function AllBlog(){
        $blogs = Blog::latest()->get();
        return view('admin.blogs.blogs_all', compact('blogs'));
    } //End method

    public function AddBlog(){
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('admin.blogs.blogs_add', compact('categories'));
    } //End method

    public function StoreBlog(Request $request){

        $image = $request->file('blog_image');
        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img = $manager->read($image);
        $img = $img->resize(430, 327);
        $img->toJpeg(80)->save('upload/blog/'.$name_gen);
        $save_url = 'upload/blog/'.$name_gen;

        Blog::insert([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_description' => $request->blog_description,
            'blog_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Blog inserted successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.blog')->with($notification);
    } //End method

    public function EditBlog($id){
        $blogs = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('admin.blogs.blogs_edit', compact('blogs', 'categories'));
    } //End method

    public function UpdateBlog(Request $request){
        $blog_id = $request->id;

        if ($request->file('blog_image')){
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('blog_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('blog_image'));
            $img = $img->resize(430, 327);
            $img->toJpeg(80)->save('upload/blog/'.$name_gen);
            $save_url = 'upload/blog/'.$name_gen;

            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Blog updated with image successfully',
                'alert-type' => 'info'
            );

            return redirect()->route('all.blog')->with($notification);
        } else{
            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
            ]);

            $notification = array(
                'message' => 'Blog updated without image successfully',
                'alert-type' => 'info'
            );

            return redirect()->route('all.blog')->with($notification);
        } //End else
    } //End method

    public function DeleteBlog($id){
        $blogs = Blog::findOrFail($id);
        $img = $blogs->blog_image;
        unlink($img); //delete image from file

        Blog::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog image deleted successfully',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);
    } //End method

    public function BlogDetails($id){
        $allblogs = Blog::latest()->limit(5)->get();
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $blogs = Blog::findOrFail($id);
        return view('frontend.blog_details', compact('blogs', 'allblogs', 'categories'));
    } //End method

    public function CategoryBlog($id){
        $blogpost = Blog::where('blog_category_id', $id)->orderBy('id', 'DESC')->get();
        $allblogs = Blog::latest()->limit(5)->get();
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $categoryname = BlogCategory::findOrFail($id);
        return view('frontend.cat_blog_details', compact('blogpost', 'allblogs', 'categories', 'categoryname'));
    } //End method

    public function HomeBlog(){
        $allblogs = Blog::latest()->paginate(3);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('frontend.blog', compact('allblogs', 'categories'));
    } //End method

}
