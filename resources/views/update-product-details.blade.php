<head>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THPS | Project Interview</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

@include('components.nav-bar')

<div class="clearfix">
    <div class="content">
        <div class="animated fadeIn">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-1" style="text-align: center;">Fetch Products</h5>
                </div>

                <div class="panel-body" style="padding: 10px;">
                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="text-center mb-3">
                        <!-- Button to Fetch Products from API -->
                        <a href="{{ route('products.fetch') }}" class="btn btn-success">Fetch Products from API</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped" id="api-products">
                            <thead>
                                <tr class="table-info">
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>${{ $product->price }}</td>
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

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#api-products').DataTable({
            "paging": false,
            "searching": true,
        });
    });
</script>
