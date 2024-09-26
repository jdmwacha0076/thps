<head>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THPS | User Manual</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

@include('components.nav-bar')

<div class="clearfix">
    <div class="content">
        <div class="animated fadeIn">
            <div class="card mb-4" style="margin-bottom: -30px !important;">
                <div class="card-header">
                    <h5 class="mb-1" style="text-align: center;">User Manual</h5>
                </div>

                <div class="panel-body" style="padding: 10px;">
                    <div class="card manual-section">
                        <div class="card-header">
                            <a href="{{ url('/register') }}" class="btn btn-info text-white">
                                Register Page
                            </a>
                        </div>
                        <div class="card-body">
                            <p>This page allows users to create an account to access the system. Users must provide a unique email address, a username, and a password (minimum 8 characters). For security reasons, passwords are stored in an encrypted format.</p>
                        </div>
                    </div>

                    <div class="card manual-section">
                        <div class="card-header">
                            <a href="{{ url('/login') }}" class="btn btn-info text-white">
                                Login Page
                            </a>
                        </div>
                        <div class="card-body">
                            <p>Users with existing accounts can log in by entering their email and password used during registration. The user will be logged out automatically after 10 seconds of inactivity.</p>
                        </div>
                    </div>

                    <div class="card manual-section">
                        <div class="card-header">
                            <a href="{{ url('/dashboard') }}" class="btn btn-info text-white">
                                Dashboard
                            </a>
                        </div>
                        <div class="card-body">
                            <p>After completing the registration or login process, the user is redirected to the dashboard, which serves as the main landing page of the system.</p>
                        </div>
                    </div>

                    <div class="card manual-section">
                        <div class="card-header">
                            <a href="{{ url('/api/products') }}" class="btn btn-info text-white">
                                View JSON
                            </a>
                        </div>
                        <div class="card-body">
                            <p>This tab allows users to view raw API data in JSON format when in local environment. After viewing the data, users can return to the main system by using the browser's back button.</p>
                        </div>
                    </div>

                    <div class="card manual-section">
                        <div class="card-header">
                            <a href="{{ url('/api-products') }}" class="btn btn-info text-white">
                                API View
                            </a>
                        </div>
                        <div class="card-body">
                            <p>The API view displays data in a tabular format. It includes functionality to search for products by keyword in the product name, with case-insensitive, partial matches supported. Users can also filter by category and sort by price.</p>
                        </div>
                    </div>

                    <div class="card manual-section">
                        <div class="card-header">
                            <a href="{{ url('/view/api/products') }}" class="btn btn-info text-white">
                                Product Details
                            </a>
                        </div>
                        <div class="card-body">
                            <p>Users can view detailed product information, including images. To enable this feature, start by viewing the data using the "View JSON" tab, then navigate to the product details page to click the view button for specific product details.</p>
                        </div>
                    </div>

                    <div class="card manual-section">
                        <div class="card-header">
                            <a href="{{ url('/update-product-details') }}" class="btn btn-info text-white">
                                Fetch/Update
                            </a>
                        </div>
                        <div class="card-body">
                            <p>This tab allows users to fetch data from the API and store it in the local database. Duplicate entries are prevented, and users can update product prices or delete products locally without affecting the API data. Deleted products can be fetched again from the API.</p>
                        </div>
                    </div>

                    <div class="card manual-section">
                        <div class="card-header">
                            <a href="{{ url('/complex-querying') }}" class="btn btn-info text-white">
                                Complex Query
                            </a>
                        </div>
                        <div class="card-body">
                            <p>This tab enables users to perform complex queries, such as searching by name, filtering by category, and sorting by price for all products stored locally in the MYSQL database, all within a single request.</p>
                        </div>
                    </div>

                    <div class="card manual-section">
                        <div class="card-header">
                            <a href="#" class="btn btn-info text-white">
                                Username
                            </a>
                        </div>
                        <div class="card-body">
                            <p>This tab displays the username of the currently logged-in user and provides an option to log out of the system.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@include('components.footer')