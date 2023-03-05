<div>
    <style>
         nav svg{
            height: 20px;
        }
        nav .hidden{
            display: block;
        }
    </style>

    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow">Home</a>
                    
                    <span></span> All Products
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-heder">
                                <div class="row">
                                    <div class="col-md-6">
                                        All Priducts
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{route('admin.products.add')}}" class="btn btn-success float-end">Add New Product</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @if(Session::has('message'))
                                    <div class="btn btn-success" role="alert">
                                        {{Session::get('message')}}
                                    </div>
                                @endif

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Stock</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i= ($products->currentPage()-1)*$products->perPage();
                                        @endphp
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{++$i}}</td>
                                                <td>
                                                    <img src="{{asset('assets/imgs/products')}}/{{$product->image}}" alt="{{$product->neme}}" width="60" />
                                                </td>
                                                <td>{{$product->name}}</td>
                                                <td>{{$product->stock_status}}</td>
                                                <td>{{$product->regular_price}}</td>
                                                <td>{{$product->category->name}}</td>
                                                <td>{{$product->created_at}}</td>
                                                <td>
                                                    <a href="{{route('admin.products.edit',['product_id'=>$product->id])}}" class="text-info">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$products->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>