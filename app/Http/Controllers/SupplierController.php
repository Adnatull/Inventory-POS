<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Helper;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::get();
        return view('admin.suppliers.manage',[
          'suppliers' => $suppliers
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $code = Helper::generateUniqueCode(6,"Supplier", "supplier_code");
        return view("admin.suppliers.add", [
          'code' => $code
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = Validator::make($request->all(), [
          'supplier_code' => 'required|max:6|min:6|unique:suppliers',
          'supplier_name' => 'required|max:191',
           'contact_person' => 'required',
           'phone' => 'required|unique:suppliers',
      ]);

      if($validatedData->fails()) {
          return Redirect::route('add-supplier')->withErrors($validatedData->messages());
      }
      $supplier = new Supplier();

      $supplier->supplier_code = $request->supplier_code;
      $supplier->supplier_name = $request->supplier_name;
      $supplier->contact_person = $request->contact_person;
      $supplier->phone = $request->phone;

      if($request->email) {
        $findUniqueness = Supplier::where('email', $request->email)->count();
        if($findUniqueness>0) {
          return Redirect::route('add-supplier')->withErrors("email already exists for another supplier!");
        }
        else {
          $supplier->email = $request->email;
        }
      }

      if($request->address) {
        $supplier->address = $request->address;
      }
      $supplier->created_by = Auth::user()->id;
      $supplier->updated_by = Auth::user()->id;
      $supplier->status = '1';
      $supplier->dues = 0;
      $supplier->advance = 0;

      try{
          $supplier->save();
      }
      catch(\Exception $e) {
          return Redirect::route('add-supplier')->withErrors("The data has been tempered in midway! try again");
      }
      return redirect(route('manage-suppliers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier-id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('admin.suppliers.edit', ['supplier'=> $supplier]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $validatedData = Validator::make($request->all(), [
          'id' => 'required',
          'supplier_name' => 'required|max:191',
          'contact_person' => 'required',
          'phone' => 'required',
          'status' => 'required'
      ]);

      if($validatedData->fails()) {
          return Redirect::route('manage-suppliers')->withErrors($validatedData->messages());
      }
      $supplier = Supplier::find($request->id);

      if($supplier == null) {
        return Redirect::route('manage-suppliers')->withErrors("Something went wrong! Try Again!");
      }

      if($supplier->phone != $request->phone) {
        $findUniqueness = Supplier::where('phone', $request->phone)->count();
        if($findUniqueness>0) {
          return Redirect::route('manage-suppliers')->withErrors("Phone already exists for another supplier!");
        }
        else {
          $supplier->phone = $request->phone;
        }
      }

      $supplier->supplier_name = $request->supplier_name;
      $supplier->contact_person = $request->contact_person;


      if($request->email) {
        if($supplier->email != $request->email) {
          $findUniqueness = Supplier::where('email', $request->email)->count();
          if($findUniqueness>0) {
            return Redirect::route('manage-suppliers')->withErrors("email already exists for another supplier!");
          }
          else {
            $supplier->email = $request->email;
          }
        }

      }

      if($request->address) {
        $supplier->address = $request->address;
      }
      $supplier->updated_by = Auth::user()->id;
      $supplier->status = $request->status;


      try{
          $supplier->save();
      }
      catch(\Exception $e) {
          return Redirect::route('manage-suppliers')->withErrors("The data has been tempered in midway! try again");
      }
      return redirect(route('manage-suppliers'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
