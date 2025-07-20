<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Simple Index Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            padding: 2rem 3rem;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 1rem;
        }

        p {
            color: #666;
        }

        table {
            width: 100%;
            margin-top: 1.5rem;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            color: #555;
        }

        td[colspan="2"] {
            text-align: center;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to the Index Page</h1>
        <p>This is a simple home page for your Laravel application.</p>
        <hr />
        @if (auth()->user()->is_admin)
            <a href="{{ route('products.create') }}">Add New Product</a>
        @endif
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Price Euro</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>€{{ $product->price_eur }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No Data Found.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        {{ $products->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
