<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Carbon;


class PortfolioController extends Controller
{
    public function AllPortfolio(){
        $portfolio = Portfolio::latest()->get();
        return view('admin.portfolio.portfolio_all', compact('portfolio'));
    } //End method

    public function AddPortfolio(){
        return view('admin.portfolio.portfolio_add');
    } //End method

    public function StorePortfolio(Request $request){
        $request->validate([
            'portfolio_name' => 'required',
            'portfolio_title' => 'required',
            'portfolio_image' => 'required',
        ], [
            //validation error messages
            'portfolio_name.required' => 'Portfolio name is required',
            'portfolio_title.required' => 'Portfolio title is required',
        ]);

        $image = $request->file('portfolio_image');
        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img = $manager->read($image);
        $img = $img->resize(1020, 519);
        $img->toJpeg(80)->save('upload/portfolio/'.$name_gen);
        $save_url = 'upload/portfolio/'.$name_gen;

        Portfolio::insert([
            'portfolio_name' => $request->portfolio_name,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description,
            'portfolio_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Portfolio inserted successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.portfolio')->with($notification);
    } //End method

    public function EditPortfolio($id){
        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolio.portfolio_edit', compact('portfolio'));
    } //End method

    public function UpdatePortfolio(Request $request){
        $portfolio_id = $request->id;

        if ($request->file('portfolio_image')){
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('portfolio_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('portfolio_image'));
            $img = $img->resize(1020, 519);
            $img->toJpeg(80)->save('upload/portfolio/'.$name_gen);
            $save_url = 'upload/portfolio/'.$name_gen;

            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Portfolio updated with image successfully',
                'alert-type' => 'info'
            );

            return redirect()->route('all.portfolio')->with($notification);
        } else{
            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
            ]);

            $notification = array(
                'message' => 'Portfolio updated without image successfully',
                'alert-type' => 'info'
            );

            return redirect()->route('all.portfolio')->with($notification);
        } //End else
    } //End method

    public function DeletePortfolio($id){
        $portfolio = Portfolio::findOrFail($id);
        $img = $portfolio->portfolio_image;
        unlink($img); //delete image from file

        Portfolio::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Portfolio image deleted successfully',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);
    } //End method

    public function PortfolioDetails($id){
        $portfolio = Portfolio::findOrFail($id);
        return view('frontend.portfolio_details', compact('portfolio'));
    } //End method
}
