<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use IonAuth\Libraries\IonAuth;

class Auth extends BaseController {

    var $ionAuth;
    var $config;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        $this->ionAuth = new IonAuth();
        $this->config = new \IonAuth\Config\IonAuth();
    }

    /**
     * Shows login form.
     */
    public function login(): string {
        return view("auth/login", ["title" => "Login"]);
    }

    public function register(): string {
        $data = ['minPasswordLength' => $this->config->minPasswordLength, 'title' => "Registration"];
        return view("auth/register", $data);
    }


    /**
     * Will process login form
     */
    public function loginComplete(): RedirectResponse {
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");
        $remember = !($this->request->getPost("remember") == null);

        $valid = $this->ionAuth->login($username, $password, $remember);

        if($valid) return redirect()->to("/");

        $this->session->setFlashdata('errorMessage', 'Invalid login data!');
        return redirect()->to("login");
    }

    public function registerComplete(): RedirectResponse {
        $username = $this->request->getPost('username');
        $username = (string)$username;
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $email = $this->request->getPost('email');
        $email = (string)$email;
        $password = $this->request->getPost('password');
        $password = (string)$password;

        $data = array('first_name' => $name, 'last_name' => $surname);

        $result = $this->ionAuth->register($username, $password, $email, $data);
        if(is_int($result)) {
            $this->ionAuth->login($username, $password);
            return redirect()->route('/');
        } else {
            $this->session->setFlashdata('error', 'Něco se nepodařilo');
            $this->session->setFlashData('type', 'error');
            return redirect()->route('register');
        }
    }

    public function registerUsername(): void {
        $username = $this->request->getPost("username");
        $rules = ['username' => "is_unique[joohle_users.username]",];
        $data = array('username' => $username,);
        $this->validation->setRules($rules);
        $result = $this->validation->run($data);
        $result2 = json_encode($result);
        echo $result2;
    }

    public function registerEmail(): void {
        $email = $this->request->getPost("email");
        $rules = ['email' => "is_unique[joohle_users.email]",];
        $data = array('email' => $email,

        );
        $this->validation->setRules($rules);
        $result = $this->validation->run($data);
        $result2 = json_encode($result);
        echo $result2;
    }

    public function logout(): RedirectResponse {
        $this->ionAuth->logout();
        return redirect()->to("/");
    }
}
