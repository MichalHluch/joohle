<?php

use IonAuth\Libraries\IonAuth;

echo $this->extend("layout/master");
echo $this->section("content");

$ionAuth = new IonAuth();
?>
    <div class="justify-content-center">
    <h2 class="mb-5 text-white">Stats Card</h2>
    <div class="row justify-content-center">
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">REGISTERED USERS</h5>
                            <span class="h2 font-weight-bold mb-0"><?=sizeof($ionAuth->users()->result())?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">ATTEMPTS</h5>
                            <span class="h2 font-weight-bold mb-0">0</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">TESTS</h5>
                            <span class="h2 font-weight-bold mb-0">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
echo $this->endSection();