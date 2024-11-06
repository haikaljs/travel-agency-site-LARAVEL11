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


    public function edit($id){
        $slider = Slider::where('id', $id)->first();
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id){
        
        $slider = Slider::where('id', $id)->first();


        $request->validate([
            'heading' => 'required',
            'text' => 'required',
        ]);

        if($request->photo){

            $request->validate([
                'photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
            ]);

            if ($slider->photo != '') {
                $photoPath = public_path('uploads/' . $slider->photo);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            $final_name = 'slider_' .time() . '.' .$request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);

            $slider->photo = $final_name;
        }


        $slider->heading = $request->heading;
        $slider->text = $request->text;
        $slider->button_text = $request->button_text;
        $slider->button_link = $request->button_link;
       
        
        $slider->save();


        return redirect()->route('admin_slider_index')->with('success', 'Slider updated successfull');


        }


       public function delete($id){

        $slider = Slider::where('id', $id)->first();
        $photoPath = public_path('uploads/' . $slider->photo);
        unlink($photoPath);

        $slider->delete();

        return redirect()->route('admin_slider_index')->with('success', 'Slider updated successfull');


       }
    
}
