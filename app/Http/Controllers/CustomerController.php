<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use mysql_xdevapi\Exception;

use Helper;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::get();
        return view('admin.customers.manage', ['customers'=> $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customers.add');
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
          'name' => 'required|max:191',
          'phone' => 'required|max:15|unique:customers',
          'email' => 'nullable|email:rfc,dns|unique:customers',
          'address' => 'nullable|max:191'
      ]);

      if($validatedData->fails()) {
          return Redirect::route('add-customer')->withErrors($validatedData->messages())->withInput();
      }
      $customer = new Customer();


      $customer->name = $request->name;
      $customer->phone = $request->phone;

      if($request->email) {
          $customer->email = $request->email;
      }

      if($request->address) {
        $customer->address = $request->address;
      }
      $customer->created_by = Auth::user()->id;
      $customer->updated_by = Auth::user()->id;
      $customer->status = '1';
      $customer->total_purchase_worth = 0;
      $customer->total_paid = 0;

      try{
          $customer->save();
      }
      catch(\Exception $e) {
          return Redirect::route('add-customer')->withErrors("The data has been tempered in midway! try again")->withInput();
      }
      return redirect(route('manage-customers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
