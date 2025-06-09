<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Borrow History</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .header { text-align: center; margin-bottom: 30px; }
        .print-date { text-align: right; margin-bottom: 20px; }
        .status { padding: 3px 8px; border-radius: 12px; font-size: 12px; }
        .status-borrowed { background: #dcfce7; color: #166534; }
        .status-returned { background: #f3f4f6; color: #374151; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Library Digital - Borrow History</h1>
    </div>

    <div class="print-date">
        Printed on: {{ now()->format('d M Y H:i:s') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrows as $borrow)
            <tr>
                <td>{{ $borrow->user->name }}</td>
                <td>{{ $borrow->book->title }}</td>
                <td>{{ $borrow->borrow_date->format('d M Y') }}</td>
                <td>{{ $borrow->return_date->format('d M Y') }}</td>
                <td>
                    <span class="status status-{{ $borrow->status }}">
                        {{ ucfirst($borrow->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
