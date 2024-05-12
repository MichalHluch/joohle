<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use IonAuth\Libraries\IonAuth;

class Auth extends BaseController {

    var $ionAuth;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->ionAuth = new IonAuth(); 
    }

    /**
     * Shows login form.
     */
    public function login() {
        return view("auth/login");
    }


    /**
     * Will process login form
     */
    public function loginComplete() {
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");
        $remember = $this->request->getPost("remember") == null ? false : true;

        $valid = $this->ionAuth->login($username, $password, $remember);
        
        if($valid) return redirect()->to("dashboard/");

        $this->session->setFlashdata('errorMessage', 'Špatné přihlašovací údaje!');
        return redirect()->to( "login");
    }

    public function register() {
        return view("register");
    }

    public function registerComplete() {
        $rules = [
            'username'          => 'required|min_length[2]|max_length[50]',
            'email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
            'confirmpassword'  => 'matches[password]'
        ];
          
        if($this->validate($rules)){
            $username = $this->request->getPost("username");
            $email = $this->request->getPost("email");
            $password = $this->request->getPost("password");
            $additional_data = array(
                'first_name' => $this->request->getPost("name"),
                'last_name' => $this->request->getPost("lastname"),
            );

            $this->ionAuth->register($username, $password, $email, $additional_data);
 
            $valid = $this->ionAuth->login($username, $password);
        
            if($valid) return redirect()->to("admin/dash");
            else redirect()->to('login');
        } else {
            return redirect()->to('login');//->with('errorMessage', $this->validator);
        }
          
    }

    public function logout() {
        $this->ionAuth->logout();
        return redirect()->to("/");
    }
}
