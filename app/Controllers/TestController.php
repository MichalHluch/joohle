<?php

namespace App\Controllers;

use App\Models\TestModel;
use App\Models\CategoryModel;
use App\Models\TestHasCategoryModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use IonAuth\Libraries\IonAuth;
use Psr\Log\LoggerInterface;

class TestController extends BaseController {

    var $ionAuth;
    var $testModel;
    var $categoryModel;
    var $testHasCategoryModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->ionAuth = new IonAuth();
        $this->testModel = new TestModel();
        $this->categoryModel = new CategoryModel();
        $this->testHasCategoryModel = new TestHasCategoryModel();
    }

    public function index(): string|RedirectResponse {
        $data["title"] = "Tests";
        $data["tests"] = $this->testModel->orderBy('nazev', 'RANDOM')->paginate(12);
        $data["categories"] = $this->categoryModel->orderBy('name', 'ASC')->findAll();
        $data["pager"] = $this->testModel->pager;
        return $this->ionAuth->loggedIn() ? view('index', $data) : redirect()->to('login');
    }
    public function categoryRender($id): string|RedirectResponse {
        $data["categories"] = $this->categoryModel->orderBy('name', 'ASC')->where('id', $id)->findAll();
        $data["testsCategory"] = $this->testHasCategoryModel->orderBy('joohle_test_id', 'ASC')->where('joohle_category_id', $id)->paginate(12);
        $data["tests"] = $this->testModel->orderBy('id', 'ASC')->findAll();
        $data["pager"] = $this->testHasCategoryModel->pager;
        $data["title"] = $data["categories"][0]->name;
        return $this->ionAuth->loggedIn() ? view('tests/category', $data) : redirect()->to('login');
    }
}
