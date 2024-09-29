<div class="offcanvas-header bg-danger">
    <h5 id="offcanvasRightLabel" class="text-light">Edit Expense</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <form id="update" autocomplete="off">
        @csrf
        @method('PUT')
        <input type="hidden" name="expense_id" id="edit_expense_id" value="{{ encrypt($expense->id) }}">

        <div class="form-group mb-3">
            <label for="merchant_name" class="required">Merchant Name</label>
            <input type="text" name="merchant_name" required maxlength="50" id="edit_title"
                value="{{ $expense->merchant_name }}" class="form-control" placeholder="Enter Merchant Name">
            <span class="invalid-feedback" id="edit_merchant_name_error"></span>
        </div>

        <div class="form-group mb-3">
            <label for="payment_method_id" class="required">Payment Method</label>
            <select name="payment_method_id" id="edit_payment_method_id" class="form-control">
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->id }}" {{ $method->id == $expense->payment_method_id ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $method->title)) }}
                    </option>
                @endforeach
            </select>
            <span class="invalid-feedback" id="edit_payment_method_error"></span>
        </div>

        <div class="form-group mb-3">
            <label for="currency_id" class="required">Currency</label>
            <select name="currency_id" id="edit_currency_id" class="form-control">
                @foreach($currencies as $currency)
                    <option value="{{ $currency->id }}" {{ $currency->id == $expense->currency_id ? 'selected' : '' }}>
                        {{ $currency->code }} - {{ $currency->title }}
                    </option>
                @endforeach
            </select>
            <span class="invalid-feedback" id="edit_currency_error"></span>
        </div>

        <div class="form-group mb-3">
            <label for="expense_category_id" class="required">Expense Category</label>
            <select name="expense_category_id" id="edit_expense_category_id" class="form-control">
                @foreach($expenseCategories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $expense->expense_category_id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
            <span class="invalid-feedback" id="edit_expense_category_error"></span>
        </div>

        <div class="form-group mb-3">
            <label for="date_of_spend" class="required">Date of Spend</label>
            <input type="date" name="date_of_spend" required id="edit_date_of_spend"
                value="{{ $expense->date_of_spend }}" class="form-control">
            <span class="invalid-feedback" id="edit_date_of_spend_error"></span>
        </div>

        <div class="form-group mb-3">
            <label for="amount_spent" class="required">Amount Spent</label>
            <input type="number" name="amount_spent" required step="0.01" id="edit_amount_spent"
                value="{{ $expense->amount_spent }}" class="form-control" placeholder="Enter Amount">
            <span class="invalid-feedback" id="edit_amount_spent_error"></span>
        </div>

        <div class="form-group mb-3">
            <label for="attendees" class="required">Attendees</label>
            <input type="text" name="attendees" maxlength="50" id="edit_attendees" value="{{ $expense->attendees }}"
                class="form-control" placeholder="Enter attendees">
            <span class="invalid-feedback" id="edit_attendees_error"></span>
        </div>

        <div class="form-group mb-3">
            <label for="description" class="required">Description</label>
            <textarea name="description" required id="edit_description" class="form-control"
                placeholder="Enter Description">{{ $expense->description }}</textarea>
            <span class="invalid-feedback" id="edit_description_error"></span>
        </div>

        <center>
            <button type="submit" id="update_btn" class="btn btn-block btn-primary">Update</button>
        </center>
    </form>


</div>
<script>
    $('#update').submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.update') }}",
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function () {
                $('#update_btn').attr('disabled', true);
                $('#update_btn').html(window.spinner);
            },
        }).done((response, statusText, xhr) => {
            $(".error-text").text("");
            $(".form-control").removeClass("is-invalid");
            $('#update_btn').removeAttr('disabled');
            $('#update_btn').html('update');


            if (xhr.status == 200) {

                $("#datatable").DataTable().ajax.reload();

                let myOffCanvas = document.getElementById('offcanvasRight');
                let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                openedCanvas.hide();
                toastr(response.message, "bg-success");
            }

        }).fail((error) => {
            $(".error-text").text("");
            $(".form-control").removeClass("is-invalid");
            $('#update_btn').removeAttr('disabled');
            $('#update_btn').html('update');

            if (error.status == 422) {

                $.each(error.responseJSON, function (key, val) {
                    $("#edit_" + key).addClass("is-invalid");
                    $("#edit_" + key + "_error").text(val[0]);
                });
            } else {
                toastr(error.responseJSON.message, "bg-danger");
            }
        });
    });
</script>