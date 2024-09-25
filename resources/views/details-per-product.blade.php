<head>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THPS | Product Details</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>

@include('components.nav-bar')

<div class="clearfix">
    <div class="content">
        <div class="animated fadeIn">
            <div class="card mb-4" style="margin-bottom: -30px !important;">
                <div class="card-header">
                    <h5 class="mb-1" style="text-align: center;">Read Product Details</h5>
                </div>

                <div class="panel-body" style="padding: 20px;">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>Product title:</strong> {{ $product['title'] }}</h6>
                            <h6><strong>Price:</strong> ${{ $product['price'] }}</h6>
                            <h6><strong>Description:</strong> {{ $product['description'] }}</h6>
                            <h6><strong>Category:</strong> {{ $product['category'] }}</h6>
                            <h6><strong>Brand:</strong> {{ $product['brand'] ?? 'N/A' }}</h6>
                            <h6><strong>Rating:</strong> {{ $product['rating'] ?? 'N/A' }}</h6>
                            <h6><strong>Stock:</strong> {{ $product['stock'] ?? 'N/A' }}</h6>
                        </div>
                        <div class="col-md-6">
                            @if(isset($product['images']) && count($product['images']) > 0)
                                <img src="{{ $product['images'][0] }}" alt="{{ $product['title'] }}" class="img-fluid" style="max-width: 100%; height: auto;">
                            @else
                                <img src="{{ asset('placeholder.png') }}" alt="No Image Available" class="img-fluid" style="max-width: 100%; height: auto;">
                            @endif
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-info mr-2">Back to Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
