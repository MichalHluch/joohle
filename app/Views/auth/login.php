<?php

echo $this->extend("layout/master");
echo $this->section("content");

echo form_open("login-complete");

$username = ['id' => 'username', 'name' => 'username', 'type' => 'text', 'class' => 'form-control'];


$password = ['id' => 'password', 'name' => 'password', 'type' => 'password', 'class' => 'form-control'];

?>

    <div class="col-lg-4 col-md-8 col-10 offset-lg-4 offset-md-2 offset-1 pt-5">

        <?php
        if(session("errorMessage") != null) echo "<div class=\"bg-danger\">" . session("errorMessage") . "</div>";
        ?>

        <h1 class="text-center pb-5">Login</h1>

        <div class="form-floating mb-3 mt-3">
            <?=form_input($username);?>
            <label for="username">Username</label>
        </div>

        <div class="form-floating mt-3">
            <?=form_input($password);?>
            <label for="password">Password</label>
        </div>


        <div class="row col-lg-6 col-md-8 col-10 offset-lg-3 offset-md-2 offset-1 pt-5">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <?php
            echo anchor('register', "Don't have an account?", ['class' => 'text-center pt-3']);
            ?>

        </div>
    </div>

<?php
echo form_close();
echo $this->endSection();