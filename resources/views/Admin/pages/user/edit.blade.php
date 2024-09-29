<div class="offcanvas-header bg-danger">
    <h5 id="offcanvasRightLabel" class="text-light">Edit User</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <form id="update" autocomplete="off">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" id="edit_user_id" value="{{ encrypt($user->id) }}">

        <div class="form-group mb-3">
            <label for="name" class="required">User Name</label>
            <input type="text" name="name" required maxlength="50" id="edit_title"
                value="{{ $user->name }}" class="form-control" placeholder="Enter Name">
            <span class="invalid-feedback" id="edit_name_error"></span>
        </div>
        
        <div class="form-group mb-3">
            <label for="email" class="required">User email</label>
            <input type="email" name="email" required maxlength="50" id="edit_email"
                value="{{ $user->email }}" class="form-control" placeholder="Enter Email">
            <span class="invalid-feedback" id="edit_email_error"></span>
        </div>

        <!-- <div class="form-group mb-3">
            <label for="password" class="required">User Password</label>
            <input type="password" role="password" required id="edit_password"
                value="{{ $user->password }}" class="form-control" placeholder="Enter Password">
            <span class="invalid-feedback" id="edit_password_error"></span>
        </div> -->

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
            url: "{{ route('index.update') }}",
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