<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\MultiImage;
use Illuminate\Support\Carbon;

class AboutController extends Controller
{
    public function AboutPage(){
        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all', compact('aboutpage'));
    } //End method

    public function UpdateAbout(Request $request){
        $about_id = $request->id;

        if ($request->file('about_image')){
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('about_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('about_image'));
            $img = $img->resize(523, 605);
            $img->toJpeg(80)->save('upload/home_about/'.$name_gen);
            $save_url = 'upload/home_about/'.$name_gen;

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'About page updated with image successfully',
                'alert-type' => 'info'
            );

            return redirect()->back()->with($notification);
        } else{
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
            ]);

            $notification = array(
                'message' => 'About page updated without image successfully',
                'alert-type' => 'info'
            );

            return redirect()->back()->with($notification);
        } //End else
    } //End method

    public function HomeAbout(){
        $aboutpage = About::find(1);
        return view('frontend.about_page', compact('aboutpage'));
    } //End method

    public function AboutMultiImage(){
        return view('admin.about_page.multimage');
    } //End method

    public function StoreMultiImage(Request $request){
        $image = $request->file('multi_image');

        foreach($image as $multi_image){
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$multi_image->getClientOriginalExtension();
            $img = $manager->read($multi_image);
            $img = $img->resize(220, 220);
            $img->toJpeg(80)->save('upload/multi/'.$name_gen);
            $save_url = 'upload/multi/'.$name_gen;

            MultiImage::insert([
                'multi_image' => $save_url,
                'created_at' => Carbon::now()
            ]);
        }//End of the foreach

        $notification = array(
            'message' => 'Multi image inserted successfully',
            'alert-type' => 'info'
        );
        return redirect()->route('all.multi.image')->with($notification);
    } //End method

    public function AllMultiImage(){
        $allMultiImage = MultiImage::all();
        return view('admin.about_page.all_multiimage', compact('allMultiImage'));
    } //End method

    public function EditMultiImage($id){
        $multiImage = MultiImage::findOrFail($id);
        return view('admin.about_page.edit_multi_image', compact('multiImage'));
    } //End method

    public function UpdateMultiImage(Request $request){
        $multi_image_id = $request->id;

        if ($request->file('multi_image')){
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('multi_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('multi_image'));
            $img = $img->resize(220, 220);
            $img->toJpeg(80)->save('upload/multi/'.$name_gen);
            $save_url = 'upload/multi/'.$name_gen;

            MultiImage::findOrFail($multi_image_id)->update([
                'multi_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Multi image updated successfully',
                'alert-type' => 'info'
            );

            return redirect()->route('all.multi.image')->with($notification);
        }
    } //End method

    public function DeleteMultiImage($id){
        $multi = MultiImage::findOrFail($id);
        $img = $multi->multi_image;
        unlink($img);
        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Multi image deleted successfully',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);
    } //End method
}
