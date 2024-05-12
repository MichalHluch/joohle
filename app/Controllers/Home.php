<?php

namespace App\Controllers;

use IonAuth\Libraries\IonAuth;

class Home extends BaseController {

    var $ionAuth;
    public function __construct()
    {
        $this->ionAuth = new IonAuth();
    }

    public function index(): string {
        return $this->ionAuth->loggedIn() ? view('index') : view('auth/login');
    }
}
