<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function addUnit() {
      return view('admin.products.unit.add-unit');
    }

    public function postUnit(Request $request) {
      $validatedData = Validator::make($request->all(), [
        'name' => 'required|max:191',
      ]);

      if($validatedData->fails()) {
          return Redirect::route('add-unit')->withErrors($validatedData->messages());
      }

      $unit = new Unit();
      $unit->type = $request->name;
      $unit->created_by =  Auth::user()->id;
      $unit->updated_by =  Auth::user()->id;

      try {
        $unit->save();
      }
      catch (\Exception $e) {
        return Redirect::route('manage-units')->withErrors("The unit has been tempered! try again");
      }

      return Redirect::route('manage-units')->withErrors("The unit has been created successfully");
    }

    public function manageUnit() {
      return View('admin.products.unit.manage-unit', [
        'units' => Unit::get()
      ]);
    }
}
