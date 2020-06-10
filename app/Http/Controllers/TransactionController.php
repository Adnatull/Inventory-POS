<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionController extends Controller
{
    public function sell() {
      $customers = Customer::where('status', true)->get();
      return view('admin.transactions.sell-products', [
        'customers' => $customers
      ]);
    }
}
