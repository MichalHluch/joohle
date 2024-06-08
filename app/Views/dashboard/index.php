<?php

use CodeIgniter\View\Table;
use IonAuth\Libraries\IonAuth;

echo $this->extend("layout/master");
echo $this->section("content");

$ionAuth = new IonAuth();
?>
    <h1 class="text-center fw-bold">DASHBOARD</h1>

    <div class="dashboard-cards">
        <div class="dashboard-card" onclick="window.location.href='<?=base_url("dashboard/users")?>'">
            <h5 class="card-title mb-0">REGISTERED USERS</h5>
            <h2 class="card-text mb-0"><?=sizeof($ionAuth->users()->result())?></h2>
        </div>

        <div class="dashboard-card" onclick="window.location.href='<?=base_url("dashboard/attempts")?>'">
            <h5 class="card-title mb-0">ATTEMPTS</h5>
            <h2 class="card-text mb-0"><?=$attempts?></h2>
        </div>


        <div class="dashboard-card" onclick="window.location.href='<?=base_url("dashboard/tests")?>'">
            <h5 class="card-title mb-0">TESTS</h5>
            <h2 class="card-text mb-0"><?=$tests?></h2>
        </div>

        <div class="dashboard-card" onclick="window.location.href='<?=base_url("dashboard/categories")?>'">
            <h5 class="card-title mb-0">CATEGORIES</h5>
            <h2 class="card-text mb-0"><?=$categories?></h2>
        </div>
    </div>

<?php
echo $this->endSection();