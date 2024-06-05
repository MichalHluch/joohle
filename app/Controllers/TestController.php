<?php

namespace App\Controllers;

use App\Models\TestModel;
use App\Models\CategoryModel;
use App\Models\TestHasCategoryModel;
use App\Models\DifficultyModel;
use App\Models\AttemptModel;
use App\Models\QuestionModel;
use App\Models\AnswerModel;
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
    var $difficultyModel;
    var $attemptModel;
    var $questionModel;
    var $answerModel;
    

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->ionAuth = new IonAuth();
        $this->testModel = new TestModel();
        $this->categoryModel = new CategoryModel();
        $this->testHasCategoryModel = new TestHasCategoryModel();
        $this->difficultyModel = new DifficultyModel();
        $this->attemptModel = new AttemptModel();
        $this->questionModel = new QuestionModel();
        $this->answerModel = new AnswerModel();
    }

    public function index(): string|RedirectResponse {
        $data["title"] = "All tests";
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
        $data["title"] = "Tests in category " . $data["categories"][0]->name;
        return $this->ionAuth->loggedIn() ? view('tests/category', $data) : redirect()->to('login');
    }
    public function test($id): string|RedirectResponse {
        $user = $this->ionAuth->user()->row();
        $data["test"] = $this->testModel->orderBy('nazev', 'RANDOM')->where('id', $id)->findAll()[0];
        $data["attempts"] = $this->attemptModel->orderBy('finished_at', 'ASC')->where('user_id', $user->id)->where('joohle_test_id', $id)->findAll();
        $data["difficulty"] = $this->difficultyModel->orderBy('id', 'ASC')->where('id', $data["test"]->joohle_difficulty_id)->findAll()[0];
        $data["title"] = "Test " . $data["test"]->nazev;
        $data["testAttempt"] = $this->session->testAttempt;
        $data["timeAttempt"] = $this->session->timeAttempt;
        return $this->ionAuth->loggedIn() ? view('tests/testDetails', $data) : redirect()->to('login');
    }
    public function testPassword(): string|RedirectResponse {
        $testId = $this->request->getPost("testId");
        $password = $this->request->getPost("password");
        $test = $this->testModel->orderBy('nazev', 'RANDOM')->where('id', $testId)->findAll()[0];
        if ($password == $test->password){
            $now = date('Y-m-d H:i:s', now());
            $newdata = [
                'testAttempt' => $testId,
                'timeAttempt' => $now,
            ];
            $this->session->set($newdata);
            return redirect()->to('test-attempt/'.$testId);
        } else {
            return redirect()->to('test/'.$testId);
        }
    }
    public function testFree($id): string|RedirectResponse {
        $now = date('Y-m-d H:i:s', now());
        $newdata = [
            'testAttempt' => $id,
            'timeAttempt' => $now,
        ];
        $this->session->set($newdata);
        return redirect()->to('test-attempt/'.$id);
    }
    public function testAttempt($id): string|RedirectResponse {
        $data["testAttempt"] = $this->session->testAttempt;
        $data["timeAttempt"] = $this->session->timeAttempt;
        $data["test"] = $this->testModel->orderBy('nazev', 'RANDOM')->where('id', $id)->findAll()[0];
        if ($data["test"]->shuffle == 1){
            $data["questions"] = $this->questionModel->orderBy('id', 'RANDOM')->where('joohle_test_id', $id)->limit((int) $data["test"]->question_amount)->findAll();
        } else {
            $data["questions"] = $this->questionModel->orderBy('id', 'ASC')->where('joohle_test_id', $id)->limit((int) $data["test"]->question_amount)->findAll();
        }
        $data["title"] = "Test " . $data["test"]->nazev;
        try {
            if ($this->session->testAttempt == $id){
                return $this->ionAuth->loggedIn() ? view('tests/questions', $data) : redirect()->to('login');
            } else {
                return redirect()->to('test/'.$id);
            }
        } catch(Exception $e) {
            return redirect()->to('test/'.$id);
        }
    }
    public function testComplete(): string|RedirectResponse {
        $finished = date('Y-m-d H:i:s', now());
        $started = $this->session->timeAttempt;
        $user = $this->ionAuth->user()->row();
        $testId = $this->request->getPost("testId");
        $test = $this->testModel->orderBy('nazev', 'RANDOM')->where('id', $testId)->findAll()[0];
        $gainedScore = 0.0;
        $maximumScore = 0.0;
        $i = 1;
        while ($i <= $test->question_amount){
            $questionId = $this->request->getPost('qh-' . $i);
            $question = $this->questionModel->orderBy('id', 'ASC')->where('id', $questionId)->findAll()[0];
            $answer = $this->answerModel->orderBy('id', 'ASC')->where('joohle_question_id', $questionId)->findAll()[0];
            if ($this->request->getPost('question-' . $i) == $answer->answer){
                $gainedScore += $answer->score;
            }
            $maximumScore += $question->max_score;
            $i += 1;
        }
        $data = array(
            'max_score' => $maximumScore,
            'score' => $gainedScore,
            'user_id' => $user->id,
            'joohle_test_id' => $testId,
            'started_at' => $started,
            'finished_at' => $finished,
        );
        $this->attemptModel->save($data);
        $this->session->remove('testAttempt');
        $this->session->remove('timeAttempt');
        return redirect()->to('test/'.$testId);
    }


}
