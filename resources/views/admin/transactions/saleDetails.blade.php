@extends('admin.master')

@section('title')
  Sale Details
@endsection

@section('body')
    @if($errors->count()>0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-primary" role="alert">
                {{$message}}
            </div>
        @endforeach
    @endif

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row p-5">
                            <div class="col-md-6">
                                <img src="http://via.placeholder.com/400x90?text=logo">
                            </div>

                            <div class="col-md-6 text-right">
                                <p class="font-weight-bold mb-1">Invoice #{{$sale->id}}</p>
                                <p class="text-muted">Due to: {{Carbon\Carbon::now("Asia/Dhaka")->toDateTimeString()}}</p>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="row pb-5 p-5">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-4">Customer Information</p>
                                @if($sale->customer != null)
                                  <p class="mb-1">{{$sale->Customer['name']}}</p>
                                  <p>Phone: {{$sale->Customer['phone']}}</p>
                                  @if($sale->Customer['email'] != null)
                                    <p class="mb-1">Email: {{$sale->Customer['email']}}</p>
                                  @endif
                                  @if($sale->Customer['address'])
                                    <p class="mb-1">Address: {{ $sale->Customer['address'] }}</p>
                                  @endif

                                @endif

                            </div>

                            <div class="col-md-6 text-right">
                                <p class="font-weight-bold mb-4">Payment Details</p>
                                <p class="mb-1"><span class="text-muted">VAT: </span> None</p>
                                <p class="mb-1"><span class="text-muted">VAT ID: </span>  None</p>
                                <p class="mb-1"><span class="text-muted">Payment Type: </span>  None</p>
                                <p class="mb-1"><span class="text-muted">Name: </span>  None</p>
                            </div>
                        </div>

                        <div class="row p-5">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Item</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Description</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Quantity</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Unit Cost</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($sale->Sale_Details as $product)

                                        <tr>
                                            <td>1</td>
                                            <td>{{$product->Product['name']}}</td>
                                            <td>LTS Versions</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>৳ {{ number_format( $product->sale_cost, 2) }}</td>
                                            <td>৳ {{ number_format( $product->quantity * $product->sale_cost, 2) }}</td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex flex-row-reverse bg-dark text-white">
                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Dues</div>
                                <div class="h5 font-weight-light">৳ {{ number_format( $sale->total_sales_cost - ($sale->discount + $sale->total_paid), 2) }}</div>
                            </div>
                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Paid Amount</div>
                                <div class="h5 font-weight-light">৳ {{ number_format( $sale->total_paid, 2) }}</div>
                            </div>
                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Grand Total</div>
                                <div class="h5 font-weight-light">৳ {{ number_format( $sale->total_sales_cost - $sale->discount, 2) }}</div>
                            </div>


                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Discount</div>
                                <div class="h5 font-weight-light">৳{{number_format( $sale->discount, 2)}}</div>
                            </div>

                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Sub - Total amount</div>
                                <div class="h5 font-weight-light">৳{{number_format( $sale->total_sales_cost, 2)}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection
