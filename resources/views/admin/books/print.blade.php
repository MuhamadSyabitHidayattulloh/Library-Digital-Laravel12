<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Books List</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .header { text-align: center; margin-bottom: 30px; }
        .print-date { text-align: right; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Library Digital - Books List</h1>
    </div>

    <div class="print-date">
        Printed on: {{ now()->format('d M Y H:i:s') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->category->name }}</td>
                <td>{{ $book->stock }}</td>
                <td>{{ $book->stock > 0 ? 'Available' : 'Out of Stock' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
