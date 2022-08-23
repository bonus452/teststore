<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Shop\PropertyName;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function getPropertyPopup(){
        $properties = PropertyName::all();
        return view('popups.property_popup', compact('properties'));
    }

    public function setProperty(Request $request){

        $property_name_text =  $request->input('property_name');
        $property_name = PropertyName::where('name', $property_name_text)->first();
        if (is_null($property_name)){
            $property_name = PropertyName::create(['name' => $property_name_text]);
        }

        return view('include.form_blocks.property_line', compact('property_name'));
    }
}
