<?php

namespace App\Http\Controllers\Admin;

use App\Models\WelcomeItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminWelcomeItemController extends Controller
{
    
    public function index(){
        $welcome_item = WelcomeItem::where('id', 1)->first();
        return view('admin.welcome.index', compact('welcome_item'));
    }

    public function update(Request $request, $id){
        $welcome_item = WelcomeItem::where('id', $id)->first();


        $request->validate([
            'heading' => 'required',
            'description' => 'required',
            'video' => 'required'
        ]);

        if($request->photo){

            $request->validate([
                'photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
            ]);

            if ($welcome_item->photo != '') {
                $photoPath = public_path('uploads/' . $welcome_item->photo);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            $final_name = 'welcomeItem_' .time() . '.' .$request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);

            $welcome_item->photo = $final_name;
        }


       $welcome_item->heading = $request->heading;
       $welcome_item->description = $request->description;
       $welcome_item->button_text = $request->button_text;
       $welcome_item->button_link = $request->button_link;
       $welcome_item->status = $request->status;
       
        
        $welcome_item->save();


        return redirect()->route('admin_welcome_item_index')->with('success', 'Welcome item updated successfull');

    }
}
