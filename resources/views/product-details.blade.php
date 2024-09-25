<head>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THPS | View Products</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

@include('components.nav-bar')

<div class="clearfix">
    <div class="content">
        <div class="animated fadeIn">
            <div class="card mb-4" style="margin-bottom: -30px !important;">
                <div class="card-header">
                    <h5 class="mb-1" style="text-align: center;">View Product Details</h5>
                </div>

                <div class="panel-body" style="padding: 10px;">
                    <div class="table-responsive">
                        <table class="table table-striped" id="api-products">
                            <thead>
                                <tr class="table-info">
                                    <th>&emsp;&emsp;ID:</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Title</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;Price</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description</th>
                                    <th>&emsp;&emsp;&emsp;Category</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;View</th>
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
                                    <td>
                                        <a href="{{ route('products.show', $product['id']) }}" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
                                    </td>
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
            "searching": true,
        });
    });
</script>

@include('components.footer')