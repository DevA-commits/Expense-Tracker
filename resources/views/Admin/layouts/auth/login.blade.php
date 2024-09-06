<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/crm.jpg" />

    <!-- Toaster -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            /* Choose a suitable font family */
            background-image: url("https://i.etsystatic.com/48147245/r/il/f613ba/5853670522/il_794xN.5853670522_1agf.jpg");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            /* Add a light background color for overall layout */
        }

        .cover {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .border {
            padding: 20px;
            border-radius: unset;
            background-color: coral;
            box-shadow: 10px 10px;
        }

        .title {
            color: rgb(0, 0, 0);
            /* Adjust text color for visibility against background */
            font-size: 2rem;
            /* Adjust font size for heading */
            margin-bottom: 1rem;
            text-align: center;
            /* Add some spacing below the title */
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            /* Add a slight drop shadow for better contrast */
        }

        .form-control {
            width: 350px;
            padding: 10px;
            border-radius: unset;
            margin-bottom: 10px;
            background-color: #ffffff;
        }

        .email_flex {
            display: flex;
            gap: .7rem;
            flex-direction: column;
        }

        .pass_flex {
            display: flex;
            margin-top: 1rem;
            gap: .7rem;
            flex-direction: column;
        }

        .sign {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            padding: 10px 40px;
            background-color: #000000;
            /* Adjust button color */
            color: white;
            border: none;
            border-radius: unset;
            cursor: pointer;
            background-color: #000000;
            font-weight: 700;
            letter-spacing: 2px;
            margin-top: 1rem;
            /* A vibrant orange color for the button */
            transition: background-color 0.2s ease-in-out;
            /* Add a smooth hover effect */
        }

        .btn-primary:hover {
            background-color: #55c0dd;
        }

        .text-danger {
            color: red;
            /* Adjust error message color */
            font-size: 0.8rem;
            /* Adjust font size for error messages */
        }

        input {
            font-family: monospace;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .email,
        .pass {
            font-weight: bold;
        }

        #preloaders {
            position: fixed;
            inset: 0;
            z-index: 999999;
            overflow: hidden;
            background: #ffffff;
            transition: all 0.6s ease-out;
        }

        #preloaders:before {
            content: "";
            position: fixed;
            top: calc(40% - 30px);
            left: calc(50% - 30px);
            border: 6px solid #ffffff;
            /* border-color: #e84545 transparent #e84545 transparent; */
            background-image: url('assets/images/download.gif');
            background-repeat: no-repeat;
            width: 100px;
            height: 200px;
        }

        @keyframes animate-preloaders {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body>

    <section>
        <div class="cover">
            <div class="border">
                {{-- <img src="{{ url('assets/images/logo - tradres.jpg') }}" alt="" width="350"> --}}

                <h1 class="title">Welcome Back</h1>
                <h4 style="text-align: center;">Sign in to continue to Dashboards.</h4>
                <form id="login">
                    @csrf

                    <div class="email">
                        <div class="email_flex">
                            <label for="email" class="form-label email">Email address *</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter email" autocomplete="off">
                        </div>
                        <span id="email_error" class="text-danger"></span>
                    </div>
                    <div class="pass">
                        <div class="pass_flex">
                            <label for="password" class="form-label pass">Password *</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Password" autocomplete="off">
                        </div>
                        <span id="email_error" class="text-danger"></span>
                    </div>

                    <div class="sign">
                        <button class="btn btn-primary" type="submit">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div id="preloaders"></div>


    <script>
        const preloaders = document.querySelector('#preloaders');
        if (preloaders) {
            window.addEventListener('load', () => {
                preloaders.remove();
            });
        }
    </script>


    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <script>
        window.addEventListener('load', function() {
            var emailField = document.getElementById('email');
            var passwordField = document.getElementById('password');

            emailField.setAttribute('id', 'email');
            emailField.setAttribute('name', 'email');
            emailField.setAttribute('type', 'email');

            passwordField.setAttribute('id', 'password');
            passwordField.setAttribute('name', 'password');
        });
    </script>

    <!-- Ajax Setup -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#login').on('submit', function(event) {
                event.preventDefault();

                var formData = $(this).serialize();
                $('span.text-danger').html('');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.authenticate') }}",
                    data: formData,
                    beforeSend: function() {
                        $('.loader').show();
                        $('#submit_spinner').hide();
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        window.location.href = "{{ route('admin.dashboard') }}";
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0], 'Either Email/Password Incorrect', {
                                "timeOut": 5000,
                                "extendedTImeout": 2000,
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                "closeButton": false,
                                "progressBar": false,
                                "positionClass": "toast-top-center",
                                "background": "#FF5733"
                            });
                        });
                    },
                    complete: function() {
                        $('.loader').hide();
                        $('#submit_spinner').show();
                    }
                });
            });
        });
    </script>
    <!-- color-customizer END -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Appear JavaScript -->
    <script src="js/jquery.appear.js"></script>
    <!-- Countdown JavaScript -->
    <script src="js/countdown.min.js"></script>
    <!-- Counterup JavaScript -->
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <!-- Wow JavaScript -->
    <script src="js/wow.min.js"></script>
    <!-- Apexcharts JavaScript -->
    <script src="js/apexcharts.js"></script>
    <!-- lottie JavaScript -->
    <script src="js/lottie.js"></script>
    <!-- Slick JavaScript -->
    <script src="js/slick.min.js"></script>
    <!-- Select2 JavaScript -->
    <script src="js/select2.min.js"></script>
    <!-- Owl Carousel JavaScript -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- Magnific Popup JavaScript -->
    <script src="js/jquery.magnific-popup.min.js"></script>
    <!-- Smooth Scrollbar JavaScript -->
    <script src="js/smooth-scrollbar.js"></script>
    <!-- Style Customizer -->
    <script src="js/style-customizer.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="js/chart-custom.js"></script>
    <!-- Custom JavaScript -->
    <script src="js/custom.js"></script>

    <!-- Toaster -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

</html>
