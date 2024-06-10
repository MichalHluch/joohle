<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\TestModel;
use App\Models\TestHasCategoryModel;
use App\Models\DifficultyModel;
use App\Models\QuestionModel;
use App\Models\AnswerModel;
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
    var $testHasCategoryModel;
    var $difficultyModel;
    var $questionModel;
    var $answerModel;
    


    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->ionAuth = new IonAuth();

        $this->attemptModel = new AttemptModel();
        $this->testModel = new TestModel();
        $this->categoriesModel = new CategoryModel();
        $this->testHasCategoryModel = new TestHasCategoryModel();
        $this->difficultyModel = new DifficultyModel();
        $this->questionModel = new QuestionModel();
        $this->answerModel = new AnswerModel();
    }

    /**
     * Shows login form.
     */
    public function index(): string {
        $data = ['users' => $this->ionAuth->users()->result(), 'title' => "Dashboard", 'attempts' => $this->attemptModel->where('deleted_at', null)->countAllResults(), 'tests' => $this->testModel->where('deleted_at', null)->countAllResults(), 'categories' => $this->categoriesModel->where('deleted_at', null)->countAllResults()];
        return view("dashboard/index", $data);
    }

    public function users(): string {
        return view("dashboard/users/index", ['users' => $this->ionAuth->users()->result(), 'title' => "Dashboard | Users"]);
    }

    /**
     * Shows all tests
     */
    public function tests(): string {
        return view("dashboard/tests/index", ["tests" => $this->testModel->where('deleted_at', null)->findAll(), "title" => "Dashboard | Categories"]);
    }
    public function editTest($id): string {
        $data = ['test' => $this->testModel->where("id", $id)->first(), 'difficulty' => $this->difficultyModel->orderBy('id', 'ASC')->findAll(), 'questions' => $this->questionModel->orderBy('id', 'ASC')->where("joohle_test_id", $id)->findAll(), 'answers' => $this->answerModel->orderBy('id', 'ASC')->findAll(), "title" => "Dashboard | Test Edit"];
        return view("dashboard/tests/editTest", $data);
    }
    public function updateTest($id): RedirectResponse {
        $name = $this->request->getVar('name');
        $description = $this->request->getVar('description');
        $max_attempts = $this->request->getVar('max_attempts');
        if ($this->request->getVar('question_amount') == ""){
            $question_amount = 1;
        } else {
            $question_amount = $this->request->getVar('question_amount');
        }
        if ($this->request->getVar('shuffle') == NULL){
            $shuffle = 0;
        } else {
            $shuffle = 1;
        }
        if ($this->request->getVar('password') == ""){
            $required_password = 0;
        } else {
            $required_password = 1;
        }
        $password = $this->request->getVar('password');
        $difficulty = $this->request->getVar('difficulty');

        $this->testModel->set([
            'nazev' => $name,
            'description' => $description,
            'max_attempts' => $max_attempts,
            'question_amount' => $question_amount,
            'shuffle' => $shuffle,
            'required_password' => $required_password,
            'password' => $password,
            'joohle_difficulty_id' => $difficulty,
            'updated_at' => date('Y-m-d H:i:s')
        ])->where('id', $id)->update();
        
        return redirect()->to('dashboard/tests');

    }
    public function deleteTest($id): RedirectResponse {
        return view("dashboard/tests", ["title" => "Dashboard | Test delete"]);
    }
    public function addTest(): string {
        return view("dashboard/tests/addTest", ["title" => "Dashboard | Test add", 'difficulty' => $this->difficultyModel->orderBy('id', 'ASC')->findAll()]);
    }
    public function createTest(): RedirectResponse {
        $name = $this->request->getVar('name');
        $description = $this->request->getVar('description');
        $max_attempts = $this->request->getVar('max_attempts');
        if ($this->request->getVar('question_amount') == ""){
            $question_amount = 1;
        } else {
            $question_amount = $this->request->getVar('question_amount');
        }
        if ($this->request->getVar('shuffle') == NULL){
            $shuffle = 0;
        } else {
            $shuffle = 1;
        }
        if ($this->request->getVar('password') == ""){
            $required_password = 0;
        } else {
            $required_password = 1;
        }
        $password = $this->request->getVar('password');
        $difficulty = $this->request->getVar('difficulty');

        $this->testModel->insert([
            'nazev' => $name,
            'description' => $description,
            'max_attempts' => $max_attempts,
            'question_amount' => $question_amount,
            'shuffle' => $shuffle,
            'required_password' => $required_password,
            'password' => $password,
            'joohle_difficulty_id' => $difficulty,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('dashboard/tests');
    }

    public function createQuestion(): RedirectResponse {
        $id = $this->request->getVar('testId');
        $question = $this->request->getVar('question');
        $answer = $this->request->getVar('answer');
        $questionScore = $this->request->getVar('question-score');
        $answerScore = $this->request->getVar('answer-score');
        $description = $this->request->getVar('description');
        $now = date('Y-m-d H:i:s');
        
        $idQ = $this->questionModel->insert([
            'question' => $question,
            'description' => $description,
            'max_score' => $questionScore,
            'joohle_test_id' => $id,
            'joohle_question_type_id' => 1,
            'created_at' => $now
        ]);

        $this->answerModel->insert([
            'answer' => $answer,
            'score' => $answerScore,
            'joohle_question_id' => $idQ,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to('dashboard/edit-test/'.$id);
    }
    public function deleteQuestion($id): RedirectResponse {
        $testId = $this->questionModel->where('id', $id)->findAll()[0]->joohle_test_id;
        $this->questionModel->set(['deleted_at' => date('Y-m-d H:i:s')])->where('id', $id)->update();
        $this->answerModel->set(['deleted_at' => date('Y-m-d H:i:s')])->where('joohle_question_id', $id)->update();
        return redirect()->to('dashboard/edit-test/'.$testId);
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

        $picture = $this->request->getFile('pic');
        $img_name = $picture === null ? null : "img-" . $picture->getCTime() . '.' . $picture->getClientExtension();


        $data = ['name' => $name, 'updated_at' => date('Y-m-d H:i:s')];
        if($img_name != null) {
            $picture->move('assets/img/', $img_name);
            $data['img_path'] = $img_name;
        }

        // Update with human-readable datetime
        $this->categoriesModel->set($data)->where('id', $id)->update();

        // Redirect or return a response
        return redirect()->to('dashboard/categories');
    }


    public function addCategory(): string {
        return view("dashboard/categories/addCategory", ["title" => "Dashboard | Create Category"]);
    }

    public function createCategory(): RedirectResponse {
        $picture = $this->request->getFile('pic');
        if($picture === null) return redirect()->to('dashboard/');
        $name = "img-" . $picture->getCTime() . '.' . $picture->getClientExtension();
        $picture->move('assets/img/', $name);
        $this->categoriesModel->insert(['name' => $this->request->getPost("name"), 'img_path' => $name]);
        return redirect()->to('dashboard/categories');
    }

    public function deleteCategory($id): RedirectResponse {
        $this->categoriesModel->set(['deleted_at' => date('Y-m-d H:i:s')])->where('id', $id)->update();
        return redirect()->route('dashboard/categories');
    }

    public function attempts(): string {
        return view("dashboard/attempts/index", ["attempts" => $this->attemptModel->select("attempt.id as attempt_id, attempt.*, users.id as user_id, users.username, test.nazev, test.id as test_id")->join('users', 'users.id = user_id', 'left')->join('test', 'test.id = attempt.joohle_test_id', 'left')->findAll(), "title" => "Dashboard | Attempts"]);
    }

    public function deleteAttempt($id): RedirectResponse {
        $this->attemptModel->set(['deleted_at' => date('Y-m-d H:i:s')])->where('id', $id)->update();
        return redirect()->route("dashboard/attempts");
    }

}
