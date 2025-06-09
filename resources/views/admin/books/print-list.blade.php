<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Library Digital - Books List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2cm; }
        .header { text-align: center; margin-bottom: 20px; }
        .print-date { text-align: right; font-size: 12px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; font-size: 14px; }
        th { background: #f8fafc; }
        .book-meta { color: #666; font-size: 12px; }
        .category { background: #f0f9ff; padding: 2px 8px; border-radius: 12px; font-size: 12px; }
        .status { padding: 2px 8px; border-radius: 12px; font-size: 12px; }
        .status-available { background: #dcfce7; color: #166534; }
        .status-out { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 30px; font-size: 12px; color: #666; }
        @media print {
            @page { margin: 2cm; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Library Digital Books Inventory</h1>
        <p>Total Books: {{ $books->count() }}</p>
    </div>

    <div class="print-date">
        Generated on: {{ now()->format('d M Y H:i:s') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Book Information</th>
                <th>Publisher Details</th>
                <th>Category</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>
                    <strong>{{ $book->title }}</strong><br>
                    <span class="book-meta">by {{ $book->author }}<br>ISBN: {{ $book->isbn }}</span>
                </td>
                <td>
                    {{ $book->publisher }}<br>
                    <span class="book-meta">Published: {{ $book->publication_year }}</span>
                </td>
                <td>
                    <span class="category">{{ $book->category->name }}</span>
                </td>
                <td>
                    <span class="status {{ $book->stock > 0 ? 'status-available' : 'status-out' }}">
                        {{ $book->stock }} copies available
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>* This is a computer generated document. No signature required.</p>
    </div>
</body>
</html>
