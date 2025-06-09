<!DOCTYPE html>
<html>
<head>
    <title>Library Digital - Borrow History</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2cm; }
        .header { text-align: center; margin-bottom: 20px; }
        .print-date { text-align: right; font-size: 12px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; font-size: 14px; }
        th { background: #f8fafc; }
        .status { padding: 2px 8px; border-radius: 12px; font-size: 12px; }
        .status-borrowed { background: #dcfce7; color: #166534; }
        .status-returned { background: #f3f4f6; color: #1f2937; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
        .status-pending { background: #fef9c3; color: #854d0e; }
        .summary { margin-top: 30px; }
        .summary h3 { color: #1f2937; font-size: 16px; }
        .summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .summary-item { background: #f8fafc; padding: 15px; border-radius: 8px; }
        .footer { margin-top: 30px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Library Digital Borrow History</h1>
    </div>

    <div class="print-date">
        Generated on: {{ now()->format('d M Y H:i:s') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Book Details</th>
                <th>Borrow Period</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrows as $borrow)
            <tr>
                <td>
                    <strong>{{ $borrow->user->name }}</strong><br>
                    <small>{{ $borrow->user->email }}</small>
                </td>
                <td>
                    <strong>{{ $borrow->book->title }}</strong><br>
                    <small>by {{ $borrow->book->author }}<br>ISBN: {{ $borrow->book->isbn }}</small>
                </td>
                <td>
                    Borrowed: {{ $borrow->borrow_date->format('d M Y') }}<br>
                    Due: {{ $borrow->return_date->format('d M Y') }}
                    @if($borrow->actual_return_date)
                        <br>Returned: {{ $borrow->actual_return_date->format('d M Y') }}
                    @endif
                </td>
                <td>
                    <span class="status status-{{ $borrow->status }}">
                        {{ ucfirst($borrow->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Summary</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <strong>Total Borrows</strong><br>
                {{ $borrows->count() }}
            </div>
            <div class="summary-item">
                <strong>Currently Borrowed</strong><br>
                {{ $borrows->where('status', 'borrowed')->count() }}
            </div>
            <div class="summary-item">
                <strong>Overdue</strong><br>
                {{ $borrows->where('status', 'overdue')->count() }}
            </div>
            <div class="summary-item">
                <strong>Returned</strong><br>
                {{ $borrows->where('status', 'returned')->count() }}
            </div>
        </div>
    </div>

    <div class="footer">
        <p>* This is a computer generated document. No signature required.</p>
    </div>
</body>
</html>
