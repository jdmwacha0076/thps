<head>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THPS | Fetch data</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

@include('components.nav-bar')

<div class="clearfix">
    <div class="content">
        <div class="animated fadeIn">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-1" style="text-align: center;">Update Fetched Products</h5>
                </div>

                <div class="panel-body" style="padding: 10px;">

                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="text-center mb-3">
                        <a href="{{ route('products.fetch') }}" class="btn btn-success"><i class="fas fa-database"></i> Fetch Products from API</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="api-products">
                            <thead>
                                <tr class="table-info">
                                    <th>&emsp;&emsp;ID:</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Title</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;Price</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Description</th>
                                    <th>&emsp;&emsp;&emsp;Category</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Update</th>
                                    <th>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Delete</th>
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
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#updatePriceModal"
                                            data-id="{{ $product->id }}" data-title="{{ $product->title }}" data-price="{{ $product->price }}">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteProductModal"
                                            data-id="{{ $product->id }}" data-title="{{ $product->title }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
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

<!-- Modal and its script for updating the product price -->
<div class="modal fade" id="updatePriceModal" tabindex="-1" role="dialog" aria-labelledby="updatePriceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('products.updatePrice') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePriceModalLabel">Update Price for <span id="productTitle"></span></h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="productId">
                    <div class="form-group">
                        <label for="newPrice"><strong>New Price (Tsh):</strong></label>
                        <input type="number" class="form-control" id="newPrice" name="price" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-info"><i class="fas fa-check"></i> Update Price</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#updatePriceModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var productId = button.data('id');
        var productTitle = button.data('title');
        var productPrice = button.data('price');

        var modal = $(this);
        modal.find('.modal-title #productTitle').text(productTitle);
        modal.find('.modal-body #productId').val(productId);
        modal.find('.modal-body #newPrice').val(productPrice);
    });
</script>

<!-- Modal and its script for deleting a product -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('products.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Delete Product <span id="productTitleToDelete"></span>?</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="productIdToDelete">
                    <p>Are you sure you want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#deleteProductModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var productId = button.data('id');
        var productTitle = button.data('title');

        var modal = $(this);
        modal.find('.modal-title #productTitleToDelete').text(productTitle);
        modal.find('.modal-body #productIdToDelete').val(productId);
    });
</script>


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