<?php
use CodeIgniter\View\Table;
use IonAuth\Libraries\IonAuth;

$ionAuth = new IonAuth();

echo $this->extend("layout/master");
echo $this->section("content");
?>
<h1 class="h1 text-dark mb-3 fw-bolder"><?=$test -> nazev?></h1>
<div class="mx-1">
<p class="mt-4 mb-3"><span class="card-text text-muted fw-bolder mt-3">Started at:&nbsp<span class="text-muted fw-normal"><?=$timeAttempt?></span></span>
<div class="mt-5">
<?php
echo form_open("test-complete");
echo '<input type="hidden" name="testId" value="'.$test -> id.'">';
$i = 1;
$allQuestions = array();
foreach($questions as $question) {
    $allQuestions[] = $question;
    echo '<input type="hidden" name="'.'qh-' . $i.'" value="'.$question->id.'">';
    echo '<label class="fw-bolder" for="'.'question-' . $i.'">'.$i.'.&nbsp'.$question->question.'</label><br>';
    echo '<label class="text-muted fw-normal mb-2" for="'.'question-' . $i.'">'.$question->description.'</label><br>';
    ${'question-' . $i} = ['id' => 'question-'.$i, 'name' => 'question-'.$i, 'type' => 'text', 'class' => 'form-control mb-5'];
    echo form_input(${'question-' . $i});
    $i += 1;
}

echo '<button type="submit" class="btn btn-primary mb-5">Send</button>';
echo form_close();
?>
</div>
</div>
<?php

echo $this->endSection();