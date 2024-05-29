<?php

use IonAuth\Libraries\IonAuth;

$ionAuth = new IonAuth();
?>


<nav class="navbar navbar-expand navbar-light bg-light fixed-top">
  <div class="container-fluid">
      <?php echo '<a class="navbar-brand mx-auto fw-bold" href="'.base_url("/").'">JOOHLE</a>'; ?>
    <div class="navbar-nav mx-auto">

      <?php
        if($ionAuth->loggedIn()) {
            if($ionAuth->isAdmin()) {
                echo '<a class="nav-link" href="'.base_url("dashboard/").'">Dashboard</a>';
            }
            echo '<a class="nav-link" href="'.base_url("/").'">Tests</a>';
            echo '<a class="nav-link" href="'.base_url("logout").'">Logout</a>';
        } else {
            echo '<a class="nav-link" href="'.base_url("/").'">Login</a>';
            echo '<a class="nav-link" href="'.base_url("register").'">Register</a>';
        }

        ?>
      <!-- Add more links as needed -->
    </div>
  </div>
</nav>

<div class="pt-5"></div>
<div class="pt-5"></div>