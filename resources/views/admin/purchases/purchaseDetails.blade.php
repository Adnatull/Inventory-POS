@extends('admin.master')

@section('title')
  Purchase Details
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
                                <p class="font-weight-bold mb-1">Invoice #550</p>
                                <p class="text-muted">Due to: 4 Dec, 2019</p>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="row pb-5 p-5">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-4">Supplier Information</p>
                                <p class="mb-1">{{$purchase->Supplier['supplier_name']}}</p>
                                <p>Contact Person: {{$purchase->Supplier['contact_person']}}</p>
                                <p class="mb-1">Phone: {{$purchase->Supplier['phone']}}</p>
                                <p class="mb-1">Address: {{ $purchase->address }}</p>
                            </div>

                            <div class="col-md-6 text-right">
                                <p class="font-weight-bold mb-4">Payment Details</p>
                                <p class="mb-1"><span class="text-muted">VAT: </span> 1425782</p>
                                <p class="mb-1"><span class="text-muted">VAT ID: </span> 10253642</p>
                                <p class="mb-1"><span class="text-muted">Payment Type: </span> Root</p>
                                <p class="mb-1"><span class="text-muted">Name: </span> John Doe</p>
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
                                      @foreach($purchase->Purchase_Details as $product)

                                        <tr>
                                            <td>1</td>
                                            <td>{{$product->Product['name']}}</td>
                                            <td>LTS Versions</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>৳ {{ number_format( $product->purchase_cost, 2) }}</td>
                                            <td>৳ {{ number_format( $product->quantity * $product->purchase_cost, 2) }}</td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex flex-row-reverse bg-dark text-white">
                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Dues</div>
                                <div class="h5 font-weight-light">৳ {{ number_format( $purchase->total_purchases_cost - ($purchase->discount + $purchase->total_paid), 2) }}</div>
                            </div>
                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Paid Amount</div>
                                <div class="h5 font-weight-light">৳ {{ number_format( $purchase->total_paid, 2) }}</div>
                            </div>
                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Grand Total</div>
                                <div class="h5 font-weight-light">৳ {{ number_format( $purchase->total_purchases_cost - $purchase->discount, 2) }}</div>
                            </div>
                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Grand Total</div>
                                <div class="h5 font-weight-light">৳ {{ number_format($purchase->total_purchases_cost - $purchase->discount, 2) }}</div>
                            </div>

                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Discount</div>
                                <div class="h5 font-weight-light">৳{{number_format( $purchase->discount, 2)}}</div>
                            </div>

                            <div class="py-3 px-3 text-right">
                                <div class="mb-2">Sub - Total amount</div>
                                <div class="h5 font-weight-light">৳{{number_format( $purchase->total_purchases_cost, 2)}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection
