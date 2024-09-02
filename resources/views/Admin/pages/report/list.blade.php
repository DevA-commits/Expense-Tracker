<!-- Offcanvas Header -->
<div class="offcanvas-header bg-info b-2">
    <!-- <h5 id="offcanvasRightLabel">Expense Info</h5> -->
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>

<!-- Offcanvas Body -->
<div class="offcanvas-body">
    <div class="receipt">
        <div class="receipt-header">
            <h6 class="text-center">Expense Receipt</h6>
        </div>
        <div class="receipt-body">
            <p><strong>Merchant:</strong> {{ $list->merchant_name }}</p>
            <p><strong>Date of Spend:</strong> {{ \Carbon\Carbon::parse($list->date_of_spend)->format('d M Y') }}</p>
            <p><strong>Payment Method:</strong> {{ $list->paymentMethod->title }}</p>
            <p><strong>Currency:</strong> {{ $list->currency->title }}</p>
            <p><strong>Expense Category:</strong> {{ $list->expenseCategory->title }}</p>
            <p><strong>Amount Spent:</strong> {{ $list->amount_spent == floor($list->amount_spent) ? number_format($list->amount_spent, 0) : number_format($list->amount_spent, 2) }}</p>
            <p><strong>Description:</strong> {{ $list->description }}</p>
            <p><strong>Attendees:</strong> {{ $list->attendees }}</p>
        </div>
        <div class="receipt-footer">
            <p class="text-center">Thank you for your business!</p>
        </div>
    </div>
</div>

<!-- Add some custom CSS to style like a receipt -->
<style>
    .receipt {
        font-family: Arial, sans-serif;
    }
    .receipt-header, .receipt-footer {
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
    .receipt-footer {
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }
    .receipt-body p {
        margin: 0;
        padding: 5px 0;
    }
    .receipt-body p strong {
        width: 150px;
        display: inline-block;
    }
</style>
