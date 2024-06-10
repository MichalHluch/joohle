<?php
use CodeIgniter\View\Table;

echo $this->extend("layout/master");
echo $this->section("content");

echo form_open("dashboard/update-test/" . $test->id);
?>

    <div class="col-lg-8 col-md-10 col-12 offset-lg-2 offset-md-1 pt-5">
        <h1 class="text-center fw-bold pb-5">TEST EDIT</h1>

        <div class="pt-3">
            <label for="name">Name:</label><input type="text" name="name" class="form-control" id="name" value="<?=$test->nazev?>" required>
        </div>
        <div class="pt-3">
            <label for="description">Description:</label><textarea name="description" class="form-control" id="description" rows="5"><?=$test->description?></textarea>
        </div>
        <div class="pt-3">
            <label for="max_attempts">Max attempts:</label><input type="number" name="max_attempts" class="form-control" id="max_attempts" value="<?=$test->max_attempts?>" required>
        </div>
        <div class="pt-3">
            <label for="question_amount">Max showed questions:</label><input type="number" name="question_amount" class="form-control" id="question_amount" value="<?=$test->question_amount?>" placeholder="For all leave blank.">
        </div>
        <?php
        if ($test->shuffle == 1){
            echo '<div class="pt-3 form-check">
                    <label for="shuffle" class="mx-2 form-check-label">Shuffle</label><input type="checkbox" name="shuffle" class="form-control form-check-input" id="shuffle" checked>
                    </div>';
        } else {
            echo '<div class="pt-3 form-check">
                    <label for="shuffle" class="mx-2 form-check-label">Shuffle</label><input type="checkbox" name="shuffle" class="form-control form-check-input" id="shuffle">
                    </div>';
        }
        ?>
        



        <div class="pt-3">
            <label for="password">Password:</label><input type="test" name="password" class="form-control" id="password" value="<?=$test->password?>" placeholder="For none leave blank.">
        </div>
        <div class="pt-3">
            <label>Difficulty:</label>
        <?php
        foreach ($difficulty as $diff){
            if($test->joohle_difficulty_id == $diff->id){
                echo '<div class="form-check">
                <input class="form-check-input" type="radio" name="difficulty" id="'.$diff->id.'" value="'.$diff->id.'" checked>
                <label class="form-check-label" for="'.$diff->id.'">
                '.$diff->name.'
                </label>
                </div>';
            } else {
                echo '<div class="form-check">
                <input class="form-check-input" type="radio" name="difficulty" id="'.$diff->id.'" value="'.$diff->id.'">
                <label class="form-check-label" for="'.$diff->id.'">
                '.$diff->name.'
                </label>
                </div>';
            }
        }
        ?>
        <div class="text-center">
            <button type="submit" class="btn btn-primary my-5">Update</button>
        </div>
        <?php
        echo form_close();
        ?>
        
        </div>
        </div>
        <div>
            <h3 class="text-center fw-bold pb-3 mt-3">QUESTIONS</h3>
            <hr class="">
            <?php
            $table = new Table();
            $table->setHeading('NUMBER', 'QUESTION', 'DESCRIPTION', 'MAX SCORE', 'ANSWER', 'SCORE', '');
            $template = array('table_open' => '<table class="table">', 'thead_open' => '<thead>', 'thead_close' => '</thead>', 'heading_row_start' => '<tr>', 'heading_row_end' => ' </tr>', 'heading_cell_start' => '<th class="fw-bold text-center">', 'heading_cell_end' => '</th>', 'tbody_open' => '<tbody>', 'tbody_close' => '</tbody>', 'row_start' => '<tr class="text-center align-middle">', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr class="text-center align-middle">', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table>');

            $table->setTemplate($template);
            $i = 1;

            foreach($questions as $question) {
                foreach ($answers as $answer){
                    if ($question->id == $answer->joohle_question_id){
                        $deleteBtn = "<button type=\"button\" class=\"btn btn-outline-danger ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $question->id . "\">Delete</button>";

                        $table->addRow($i, $question->question, $question->description, $question->max_score, $answer->answer, $answer->score, $deleteBtn);

                        echo form_modal("modal" . $question->id, $question->id, "Delete User", "Do you really want to delete question \"" . $question->question . "\"?", "dashboard/delete-question/" . $question->id);
                        $i += 1;
                    }
                }
                
            }

            echo $table->generate();

            echo form_open("dashboard/create-question");
            ?>
            <input type="hidden" name="testId" value="<?= $test -> id ?>">
            <div class="d-flex align-items-center justify-content-center mt-5">
                <div class="col p-3">
                    <label for="question">Question:</label><input type="text" name="question" class="form-control" id="question" required>
                </div>
                <div class="col p-3">
                    <label for="description">Description:</label><input type="text" name="description" class="form-control" id="description">
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <div class="col p-3">
                    <label for="answer">Answer:</label><input type="text" name="answer" class="form-control" id="answer" required>
                </div>
                <div class="col p-3">
                    <label for="question-score">Question max score:</label><input type="text" name="question-score" class="form-control" id="question-score" required>
                </div>
                <div class="col p-3">
                    <label for="answer-score">Answer max score:</label><input type="text" name="answer-score" class="form-control" id="answer-score" required>
                </div>
            </div>
            <div class="col p-3 text-center mb-5">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>

<?php
echo form_close();
echo $this->endSection();
