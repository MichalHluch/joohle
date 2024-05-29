<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use IonAuth\Libraries\IonAuth;

class Dashboard extends BaseController {

    var $ionAuth;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->ionAuth = new IonAuth();
    }

    /**
     * Shows login form.
     */
    public function index(): string {
        $data = ['users' => $this->ionAuth->users()->result(), 'title' => "Dashboard"];
        return view("dashboard/index", $data);
    }

    /**
     * Shows all tests
     */
    public function tests(): string {
        return view("dashboard/tests", ["title" => "Dashboard | Tests"]);
    }

    public function deleteUser($id): RedirectResponse {
        $this->ionAuth->deleteUser($id);
        return redirect()->route('dashboard/users');
    }

    public function editUser($id): string {
        $data = ['user' => $this->ionAuth->user($id)->row(), "title" => "Dashboard | Edit User"];
        return view("dashboard/editUser", $data);
    }

    public function updateUser($id): RedirectResponse {

        $data = ['first_name' => $this->request->getVar('first_name'), 'last_name' => $this->request->getVar('last_name'), 'username' => $this->request->getPost('username'), 'email' => $this->request->getPost('email')];

        $this->updateGroups($id, $this->request->getPost('groups'));
        $this->ionAuth->update($id, $data);
        return redirect()->to("dashboard/users");
    }

    public function updateGroups($id, $newGroups): void {
        // Assuming $this->ionAuth is your IonAuth instance
        // and $id is the user ID

        // 1. Retrieve current groups of the user
        $currentGroups = $this->ionAuth->getUsersGroups($id)->getResultArray();
        $currentGroupIds = array_column($currentGroups, 'id');

        // 2. Retrieve new groups from the POST request
        if(!is_array($newGroups)) {
            $newGroups = [];
        }

        // 3. Determine groups to add and remove
        $groupsToAdd = array_diff($newGroups, $currentGroupIds);
        $groupsToRemove = array_diff($currentGroupIds, $newGroups);

        // 4. Add new groups
        foreach($groupsToAdd as $groupId) {
            $this->ionAuth->addToGroup($groupId, $id);
        }

        // 5. Remove old groups
        foreach($groupsToRemove as $groupId) {
            $this->ionAuth->removeFromGroup($groupId, $id);
        }
    }


    public function createTest() {

    }

    public function editTest($id) {

    }

    public function deleteTest($id) {

    }
}
