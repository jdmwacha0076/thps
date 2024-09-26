# Assistant Systems Administrator Role Evaluation - PHP API Project

## Project Description

This project is a PHP-based API that integrates with an external dataset from [DummyJSON](https://dummyjson.com/products). The API is designed to perform various operations on the retrieved data, such as data retrieval, searching, filtering, sorting, and updating products. It also implements advanced features like caching, rate limiting, error handling, and security.

### Key Features

1. **Data Retrieval and Caching**:
   - Fetches data from the provided external dataset.
   - Implements a caching mechanism to store retrieved data locally for 10 minutes to reduce external API calls.
   - Cache invalidation ensures the cache is refreshed after the defined period to provide up-to-date data.

2. **API Endpoints**:
   - **List all products**: Retrieves the full list of products.
   - **Search products by name**: Enables case-insensitive and partial match search functionality.
   - **Filter products**: Allows filtering of products by category and price range.
   - **Sort products**: Supports sorting of products by fields such as price and title.
   - **Get product details by ID**: Returns detailed product information for a valid product ID.
   - **Update product price**: Allows updating the price of a specific product locally.
   - **Complex query**: Facilitates combined search, filter, and sort operations within a single request.

3. **Rate Limiting**:
   - Limits each user (based on IP address) to 50 API requests per hour to prevent abuse.

4. **Error Handling**:
   - Provides robust error handling for invalid IDs, categories, request parameters, and returns appropriate HTTP status codes.

5. **Bonus Features** (Optional):
   - Bulk operations for batch updating product prices or categories.
   - Pagination for efficient handling of large datasets.
   - Integration with MySQL for data storage.
   - User authentication for securing API access.
   - API key/token-based authentication for advanced security.

## Steps to Clone and Run the Project

1. **Clone the repository**:
    ```bash
    git clone https://github.com/your-username/assistant-api-project.git
    cd assistant-api-project
    ```

2. **Install dependencies**:
    Run the following command to install required PHP dependencies.
    ```bash
    composer install
    ```

3. **Environment setup**:
    Copy the `.env.example` file to create your own `.env` file.
    ```bash
    cp .env.example .env
    ```

4. **Generate application key**:
    ```bash
    php artisan key:generate
    ```

5. **Run the application**:
    Start the Laravel development server using:
    ```bash
    php artisan serve
    ```

    The application will be accessible at `http://localhost:8000`.

