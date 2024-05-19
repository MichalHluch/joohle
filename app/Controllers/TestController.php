<?php

namespace App\Controllers;

use App\Models\TestModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use IonAuth\Libraries\IonAuth;
use Psr\Log\LoggerInterface;

class TestController extends BaseController {

    var $ionAuth;
    var $testModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->ionAuth = new IonAuth();
        $this->testModel = new TestModel();
    }

    public function index(): string|RedirectResponse {
        $data = ["title" => "TestController", "tests" => $this->testModel->orderBy('nazev', 'DESC')->paginate(10), "pager" => $this->testModel->pager];
        return $this->ionAuth->loggedIn() ? view('index', $data) : redirect()->to('login');
    }
}
