<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function sell() {
      return view('admin.transactions.sell-products');
    }
}
