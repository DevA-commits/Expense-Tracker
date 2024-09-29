<!DOCTYPE html>
<html>

<head>
    <title>Expense Report</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: monospace;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Expense Report</h2>
        <p>From: {{ $fromDate->format('d-m-Y') }} To: {{ $toDate->format('d-m-Y') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Merchant Name</th>
                <th>Date Of Spend</th>
                <th>Payment Method</th>
                <th>Currency</th>
                <th>Expense Category</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAmount = 0;
            @endphp
            @foreach($expenses as $expense)
                        <tr>
                            <td>{{ $expense->merchant_name }}</td>
                            <td>{{ $expense->date_of_spend }}</td>
                            <td>{{ $expense->paymentMethod->title }}</td>
                            <td>
                                @if($expense->currency->title === 'Indian Rupee (INR)')
                                    INR
                                @else
                                    {{ $expense->currency->title }}
                                @endif
                            </td>
                            <td>{{ $expense->expenseCategory->title }}</td>
                            <td>{{ $expense->amount_spent }}</td>
                        </tr>
                        @php
                            $totalAmount += $expense->amount_spent;
                        @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="total-label">Total Amount:</td>
                <td>{{ $totalAmount }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>