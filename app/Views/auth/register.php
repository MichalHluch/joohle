<?php

echo $this->extend('layout/master');

echo $this->section('content');

$attributes = array('novalidate' => 'novalidate', 'id' => 'register');

echo form_open('register-complete', $attributes);

?>
    <h1 class="text-center pb-5"><?=$title?></h1>

    <div class="col-lg-6 col-md-8 col-10 offset-lg-3 offset-md-2 offset-1">
        <div class="mb-3">
            <div class="input-group">
                <div class="form-floating">
                    <input type="text" class="form-control" placeholder="" name="username" id="username" autocomplete="on">
                    <label for="username">Username</label>
                </div>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="input-group">
                <div class="form-floating">
                    <input type="text" class="form-control" placeholder="" name="name" id="name"
                           autocomplete="on">
                    <label for="name">Name</label>

                </div>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="input-group">
                <div class="form-floating">
                    <input type="text" class="form-control" placeholder="" name="surname" id="surname"
                           autocomplete="on">
                    <label for="surname">Surname</label>

                </div>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="input-group">
                <div class="form-floating">
                    <input type="email" class="form-control" placeholder="" name="email" id="email"
                           autocomplete="on">
                    <label for="email">Email</label>
                </div>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="input-group">
                <div class="form-floating">
                    <input type="password" class="form-control" placeholder="" name="password" id="password">
                    <label for="password">Password</label>
                </div>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="input-group">
                <div class="form-floating">
                    <input type="password" class="form-control" placeholder="" name="confirm" id="confirm">
                    <label for="confirm">Password Again</label>
                </div>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row col-lg-4 col-md-8 col-10 offset-lg-4 offset-md-2 offset-1 pt-5">
            <button type="submit" class="btn btn-primary btn-block">Registrovat</button>
            <?php
            echo anchor('login', 'Already have an account?', ['class' => 'text-center pt-3']);
            ?>

        </div>

    </div>
<?php
echo form_close();

?>

    <style>
        .error {
            padding: 0 10px;
        }

        .login-card-body {
            margin: 10px 0;
            padding: 0;
        }

        .card-body {
            margin: 10px 0;
        }

        img.profile {
            max-height: 40px;

        }

        span.badge, .btn {
            margin-right: 5px;
        }

        div.input {
            border: black 1px solid;
        }

        div.input-group.is-valid {
            border-color: green;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        div.input-group.is-invalid {
            border-color: red;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>

    <script>
        $(document).ready(function () {
            $.validator.setDefaults({
                highlight: function (element) {
                    $(element).parent().parent().addClass("is-invalid").removeClass("is-valid");
                    $(".error").addClass("text-danger d-block");
                },

                unhighlight: function (element) {
                    $(element).parent().parent().addClass("is-valid").removeClass("is-invalid");
                    $(".error").addClass("text-success d-block");
                }
            });

            $("#register").validate({
                rules: {
                    username: {
                        required: true,
                        remote: {
                            url: "register-username",
                            method: "post"
                        }

                    },
                    name: "required",
                    surname: "required",

                    password: {
                        required: true,
                        minlength: <?= $minPasswordLength; ?>
                    },
                    confirm: {
                        required: true,
                        minlength: <?= $minPasswordLength; ?>,
                        equalTo: "#password"
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "register-email",
                            method: "post"
                        }
                    }

                },
                errorPlacement: function (error, element) {
                    error.appendTo(element.parent().parent().parent());
                },
                errorElement: "div",
            })
        });
    </script>

<?php
echo $this->endSection();