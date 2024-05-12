<?php

echo $this->extend("layout/master");
echo $this->section("content");
?>

    <div class="col-lg-4 col-md-8 col-10 offset-lg-4 offset-md-2 offset-1 pt-5">
        <h1 class="text-center fw-bold">DASHBOARD</h1>


        <p>Tests: XX</p>
        <p>Users: XX</p>
        <p>Attempts: XX</p>
        <p>Avg attempts: XX</p>
    </div>


<?php
echo $this->endSection();