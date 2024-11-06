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
}
