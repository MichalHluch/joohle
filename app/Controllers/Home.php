<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use IonAuth\Libraries\IonAuth;

class Home extends BaseController {

    var $ionAuth;
    public function __construct()
    {
        $this->ionAuth = new IonAuth();
    }

    public function index(): string|RedirectResponse {
        return $this->ionAuth->loggedIn() ? view('index', ["title" => "Home"]) : redirect()->to('login');
    }
}
