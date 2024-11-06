<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSliderController extends Controller
{

    public function index(){
        $sliders = Slider::get();
        return view('admin.slider.index', compact('sliders'));
    }


    public function create(){
       
        return view('admin.slider.create');
    }


    public function store(Request $request){

       
        $request->validate([
            'heading' => 'required',
            'text' => 'required',
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:5120'],
        ]);


        $slider = new Slider();
        $final_name = 'slider_' .time() . '.' .$request->photo->extension();
        $request->photo->move(public_path('uploads'), $final_name);

        $slider->photo = $final_name;
    
        $slider->heading = $request->heading;
        $slider->text = $request->text;
        $slider->button_text = $request->button_text;
        $slider->button_link = $request->button_link;
        $slider->save();

        return redirect()->route('admin_slider_index')->with('success', 'Slider created successfully');
    }
}
