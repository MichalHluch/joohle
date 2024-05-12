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
                echo '
                    <div class="collapse navbar-collapse" id="dropdown">
                      <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dashboard
                          </a>
                          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdown">
                            <li><a class="dropdown-item" href="'.base_url("dashboard/").'">Overview</a></li>
                            <li><a class="dropdown-item" href="'.base_url("dashboard/tests").'">Tests</a></li>
                            <li><a class="dropdown-item" href="'.base_url("dashboard/users").'">Users</a></li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                ';
            }
            echo '<a class="nav-link" href="'.base_url("/").'">Tests</a>';
            echo '<a class="nav-link" href="'.base_url("logout").'">Logout</a>';
        } else {
            echo '<a class="nav-link" href="'.base_url("register").'">Information</a>';
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