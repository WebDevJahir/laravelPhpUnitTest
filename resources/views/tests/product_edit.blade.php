<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
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
            width: 100%;
            max-width: 400px;
        }

        h2 {
            color: #333;
            margin-bottom: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            text-align: left;
            color: #555;
            margin-bottom: 0.3rem;
        }

        input,
        textarea {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 0.7rem;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Create Product</h2>
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div>
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" required value="{{ $product->name ?? '' }}">
            </div>
            <div>
                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required
                    value="{{ $product->price ?? '' }}">
            </div>
            <button type="submit">Update Product</button>
        </form>
    </div>
</body>

</html>
