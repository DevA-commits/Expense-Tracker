<div class="offcanvas-header bg-danger">
    <h5 id="offcanvasRightLabel" class="text-light">Edit Payment Method</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <form id="update" autocomplete="off">
        @csrf
        @method('PUT')
        <input type="hidden" name="payment_id" id="edit_payment_id" value="{{ encrypt($paymentMethods->id) }}">

        <div class="form-group mb-3">
            <label for="payment_type" class="required">Payment Method Type</label>
            <select name="payment_type" id="payment_type" class="form-control">
                @foreach ($payments as $payment)
                    <option value="{{ $payment->title }}" selected>
                        {{ ucwords(str_replace('_', ' ', $payment->title)) }}
                    </option>
                @endforeach
            </select>
            <span class="invalid-feedback" id="edit_payment_type_error"></span>
        </div>

        <div class="form-group mb-3">
            <label for="payment_name" class="required">User payment_name</label>
            <input type="payment_name" name="payment_name" required maxlength="50" id="edit_payment_name"
                value="{{ $paymentMethods->payment_name }}" class="form-control" placeholder="Enter Payment Name">
            <span class="invalid-feedback" id="edit_payment_name_error"></span>
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
            url: "{{ route('user.payment.update') }}",
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