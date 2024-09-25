<head>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THPS | Complex Query</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

@include('components.nav-bar')

<div class="clearfix">
    <div class="content">
        <div class="animated fadeIn">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-1" style="text-align: center;">Perform Complex Querying</h5>
                </div>

                <div class="panel-body" style="padding: 10px;">

                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="form-group">
                            <label for="search" class="font-weight-bold">Search by Name:</label>
                            <input type="text" name="search" class="form-control" placeholder="Enter product name">
                        </div>
                        <div class="form-group">
                            <label for="category" class="font-weight-bold">Select Product Category:</label>
                            <select name="category" class="form-control">
                                <option value="">Select product category</option>
                                <option value="furniture">Furniture</option>
                                <option value="groceries">Groceries</option>
                                <option value="fragrances">Fragrances</option>
                                <option value="beauty">Beauty</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sort" class="font-weight-bold">Sort by Price:</label>
                            <select name="sort" class="form-control">
                                <option value="">Choose sort order</option>
                                <option value="asc">Price: Low to High</option>
                                <option value="desc">Price: High to Low</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> Search</button>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="table-info">
                                <th>&emsp;&emsp;ID:</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Title</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;Price</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description</th>
                                    <th>&emsp;&emsp;&emsp;Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>Tsh {{ $product->price }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->category }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.footer')