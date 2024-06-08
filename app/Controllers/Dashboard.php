<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\TestModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use IonAuth\Libraries\IonAuth;
use App\Models\AttemptModel;

class Dashboard extends BaseController {

    var $ionAuth;
    var $attemptModel;
    var $testModel;
    var $categoriesModel;


    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->ionAuth = new IonAuth();

        $this->attemptModel = new AttemptModel();
        $this->testModel = new TestModel();
        $this->categoriesModel = new CategoryModel();
    }

    /**
     * Shows login form.
     */
    public function index(): string {
        $data = ['users' => $this->ionAuth->users()->result(), 'title' => "Dashboard",
            'attempts' => $this->attemptModel->countAll(),
            'tests' => $this->testModel->countAll(),
            'categories' => $this->categoriesModel->where('deleted_at', null)->countAllResults()];
        return view("dashboard/index", $data);
    }

    public function users(): string {
        return view("dashboard/users/index", ['users' => $this->ionAuth->users()->result(), 'title' => "Dashboard | Users"]);
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
        $data = ['user' => $this->ionAuth->user($id)->row(), "title" => "Dashboard | User Edit"];
        return view("dashboard/editUser", $data);
    }

    public function updateUser($id): RedirectResponse {

        $data = ['first_name' => $this->request->getVar('first_name'), 'last_name' => $this->request->getVar('last_name'), 'username' => $this->request->getPost('username'), 'email' => $this->request->getPost('email')];

        $this->updateGroups($id, $this->request->getPost('groups'));
        $this->ionAuth->update($id, $data);
        return redirect()->to("dashboard/");
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

    public function categories(): string {
        return view("dashboard/categories/index", ["categories" => $this->categoriesModel->where('deleted_at', null)->findAll(), "title" => "Dashboard | Categories"]);
    }

    public function editCategory($id): string {
        $data = ['category' => $this->categoriesModel->where("id", $id)->first(), "title" => "Dashboard | Category Edit"];
        return view("dashboard/categories/editCategory", $data);
    }

    public function updateCategory($id): RedirectResponse {
        // Load the request and model
        $name = $this->request->getVar('name');

        // Update with human-readable datetime
        $this->categoriesModel->set([
            'name' => $name,
            'updated_at' => date('Y-m-d H:i:s')
        ])->where('id', $id)->update();

        // Redirect or return a response
        return redirect()->to('dashboard/categories');
    }


    public function addCategory(): string {
        return view("dashboard/categories/addCategory", ["title" => "Dashboard | Create Category"]);
    }

    public function createCategory(): RedirectResponse {
        $this->categoriesModel->insert(['name' => $this->request->getPost("name")]);
        return redirect()->to('dashboard/categories');
    }

    public function deleteCategory($id): RedirectResponse {
        $this->categoriesModel->set([
            'deleted_at' => date('Y-m-d H:i:s')
        ])->where('id', $id)->update();
        return redirect()->route('dashboard/categories');
    }
}
