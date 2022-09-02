<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Shop\PropertyName;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function getPropertyPopup()
    {
        $properties = PropertyName::all();
        return view('popups.property_popup', compact('properties'));
    }

    public function setProperty(Request $request)
    {
        $property_name =  $request->input('property_name');
        $property = PropertyName::where('name', $property_name)
            ->firstOrCreate(['name' => $property_name]);

        return view('include.form_blocks.property_line', compact('property'));
    }
}
