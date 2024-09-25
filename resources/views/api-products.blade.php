<head>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THPS | View API Products</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

@include('components.nav-bar')

<div class="clearfix">
    <div class="content">
        <div class="animated fadeIn">
            <div class="card mb-4" style="margin-bottom: -30px !important;">

                <div class="card-header">
                    <h5 class="mb-1" style="text-align: center;"> All Products from the API</h5>
                </div>

                <div class="panel-body" style="padding: 10px;">
                    <form action="{{ route('api.products.search') }}" method="GET" class="mb-4">
                        <label for="search" class="font-weight-bold">Search by Name:</label>
                        <input type="text" name="query" class="form-control" placeholder="Search by product name" required>
                        <button type="submit" class="btn btn-info mt-2"><i class="fas fa-search"></i> Search by product name</button>
                    </form>

                    <form action="{{ route('api.products.filter') }}" method="GET" class="mb-4">
                        <div class="form-group">
                            <label for="sort" class="font-weight-bold">Sort by Price:</label>
                            <select name="sort" class="form-control">
                                <option value="">Choose sort order</option>
                                <option value="asc">Price: Low to High</option>
                                <option value="desc">Price: High to Low</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="search" class="font-weight-bold">Minimum price:</label>
                            <input type="number" name="min_price" class="form-control" placeholder="Enter minimum Price" min="0">
                        </div>
                        <div class="form-group">
                            <label for="search" class="font-weight-bold">Maximum price:</label>
                            <input type="number" name="max_price" class="form-control" placeholder="Enter maximum Price" min="0">
                        </div>
                        <button type="submit" class="btn btn-info mt-2"><i class="fas fa-filter"></i> Filter API Products</button>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped" id="api-products">
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
                                    <td>{{ $product['id'] }}</td>
                                    <td>{{ $product['title'] }}</td>
                                    <td>Tsh {{ $product['price'] }}</td>
                                    <td>{{ $product['description'] }}</td>
                                    <td>{{ $product['category'] }}</td>
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

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#api-products').DataTable({
            "paging": false,
            "searching": false,
        });
    });
</script>

@include('components.footer')