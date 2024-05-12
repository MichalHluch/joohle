<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use IonAuth\Libraries\IonAuth;

class Dashboard extends BaseController
{

    var $ionAuth;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->ionAuth = new IonAuth();
    }

    /**
     * Shows login form.
     */
    public function index(): string {
        return view("dashboard/index");
    }

    /**
     * Shows all users
     */
    public function users(): string {
        $data = [
            'users' => $this->ionAuth->users()->result(),
            'ionAuth' => $this->ionAuth
        ];

        return view("dashboard/users", $data);
    }

    /**
     * Shows all tests
     */
    public function tests(): string {
        return view("dashboard/tests");
    }


    public function createTest() {

    }

    public function editTest($id) {

    }

    public function deleteTest($id) {

    }
}
