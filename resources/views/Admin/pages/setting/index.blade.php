@extends('Admin.layouts.main')
@section('title', 'EXPENSE | SETTING')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg profile-setting-img">
                <img src="assets/images/profile-bg.jpg" class="profile-wid-img" alt="">
                <div class="overlay-content">
                    <div class="text-end p-3">
                        <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                            <input id="profile-foreground-img-file-input" type="file"
                                class="profile-foreground-img-file-input">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="save">
            <div class="row">
                <div class="col-xxl-3">
                    <div class="card mt-n5">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                    <img id="profileImage" src=""
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image material-shadow"
                                        alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                        <input id="profile-img-file-input" name="profile-img-file-input" type="file"
                                            class="profile-img-file-input">
                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                            <span
                                                class="avatar-title rounded-circle bg-light text-body material-shadow">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <h5 class="fs-16 mb-1"></h5>
                                <p class="text-muted mb-0"></p>
                            </div>
                        </div>
                    </div>
                    <!--end card-->


                </div>
                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                        <i class="fas fa-home"></i> Personal Details
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" name="first_name" class="form-control"
                                                    id="first_name" placeholder="Enter your firstname"
                                                    value="{{ isset($profile->first_name) ? $profile->first_name : '' }}">
                                                <span class="invalid-feedback" id="first_name_error"></span>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" name="last_name" class="form-control" id="last_name"
                                                    placeholder="Enter your lastname"
                                                    value="{{ isset($profile->last_name) ? $profile->last_name : '' }}">
                                                <span class="invalid-feedback" id="last_name_error"></span>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phone_number" class="form-label">Phone Number</label>
                                                <input type="text" maxlength="10" name="phone_number"
                                                    class="form-control" id="phone_number"
                                                    placeholder="Enter your phone number"
                                                    value="{{ isset($profile->phone_number) ? $profile->phone_number : '' }}"
                                                    onkeypress="return isNumber(event)">
                                                <span class="invalid-feedback" id="phone_number_error"></span>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" name="email" class="form-control" id="email"
                                                    placeholder="Enter your email"
                                                    value="{{ isset($profile->email) ? $profile->email : '' }}">
                                                <span class="invalid-feedback" id="email_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="designation" class="form-label">Designation</label>
                                                <input type="text" name="designation" class="form-control"
                                                    id="designation" placeholder="Designation"
                                                    value="{{ isset($profile->designation) ? $profile->designation : '' }}">
                                                <span class="invalid-feedback" id="designation_error"></span>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="website" class="form-label">Website</label>
                                                <input type="text" name="website" class="form-control" id="website"
                                                    placeholder="www.example.com"
                                                    value="{{ isset($profile->website) ? $profile->website : '' }}">
                                                <span class="invalid-feedback" id="website_error"></span>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" name="city" class="form-control" id="city"
                                                    placeholder="City"
                                                    value="{{ isset($profile->city) ? $profile->city : '' }}">
                                                <span class="invalid-feedback" id="city_error"></span>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="country" class="form-label">Country</label>
                                                <input type="text" name="country" class="form-control" id="country"
                                                    placeholder="Country"
                                                    value="{{ isset($profile->country) ? $profile->country : '' }}">
                                                <span class="invalid-feedback" id="country_error"></span>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="zip" class="form-label">Zip Code</label>
                                                <input type="text" name="zip" class="form-control" maxlength="6"
                                                    id="zip" placeholder="Enter zipcode"
                                                    value="{{ isset($profile->zip) ? $profile->zip : '' }}">
                                                <span class="invalid-feedback" id="zip_error"></span>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3 pb-2">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" name="description" id="description"
                                                    placeholder="Enter your description"
                                                    rows="3">{{ isset($profile->description) ? $profile->description : '' }}</textarea>
                                                <span class="invalid-feedback" id="description_error"></span>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button id="save_btn" class="btn btn-success"
                                                    type="submit">Update</button>

                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
        </form>
        <!--end row-->

    </div>
    <!-- container-fluid -->
</div>
@endsection

@section('modal')
@include('Admin._includes.offcanvas.right')
@include('Admin._includes.modals.delete_modal')
@endsection

@push('scripts')
    <script src="{{ url('assets/js/main/canvas.js') }}"></script>
    <script src="{{ url('assets/js/main/delete.js') }}"></script>

    <script>
        document.getElementById('profile-img-file-input').addEventListener('change', function (event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profileImage').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
@endpush