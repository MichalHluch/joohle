<?php

use CodeIgniter\View\Table;
use IonAuth\Libraries\IonAuth;

$ionAuth = new IonAuth();

echo $this->extend("layout/master");
echo $this->section("content");
?>
    <h1 class="h1 text-dark mb-3 fw-bolder"><?= $test->nazev ?></h1>
    <div class="mx-1">
        <span class="text-muted fw-normal"><?= $test->description ?></span>

        <p class="mt-4 mb-3"><span class="card-text text-muted fw-bolder mt-3">Difficulty:&nbsp<span
                        class="text-muted fw-normal"><?= $difficulty->name ?></span></span></br>
            <span class="card-text text-muted fw-bolder">Max attempts:&nbsp<span
                        class="text-muted fw-normal"><?= $test->max_attempts ?></span></span></p>
        <?php
        if (count($attempts) < $test->max_attempts) {
            if ($test->required_password == 1) {
                $password = ['id' => 'password', 'name' => 'password', 'type' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', "required" => true];
                echo form_open("test-password");
                echo '<input type="hidden" name="testId" value="' . $test->id . '">';
                echo '<div class="input-group w-25">';
                echo form_input($password);
                echo '<button type="submit" class="btn btn-primary">Start</button>';
                echo '</div>';
                echo '</div>';
                echo form_close();
            } else {
                echo anchor('/test-start/' . $test->id, 'Start', 'class="btn btn-primary"');
            }
        } else {
            echo '<div class="d-block-inline">';
            echo '<button class="btn btn-outline-secondary" disabled>Start</button>';
            echo '<p>You have reached max allowed attempts!</p>';
            echo '</div>';
        }
        echo '<hr class="mt-4">';
        echo '<div><h3 class="h3 text-dark fw-bolder my-5">Attempts</h3>';
        if (count($attempts) != 0) {
            $table = new Table();
            $table->setHeading('ID', 'STARTED', 'FINISHED', 'SCORE');
            $template = array('table_open' => '<table class="table" style="table-layout: fixed;">', 'thead_open' => '<thead>', 'thead_close' => '</thead>', 'heading_row_start' => '<tr>', 'heading_row_end' => ' </tr>', 'heading_cell_start' => '<th class="fw-bold text-center">', 'heading_cell_end' => '</th>', 'tbody_open' => '<tbody>', 'tbody_close' => '</tbody>', 'row_start' => '<tr class="text-center align-middle">', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr class="text-center align-middle">', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table>');
            $table->setTemplate($template);
            $number = 1;
            foreach ($attempts as $attempt) {
                $table->addRow($number, $attempt->started_at, $attempt->finished_at, $attempt->score . '/' . $attempt->max_score);
                $number += 1;
            }

            echo $table->generate();
        } else {
            echo '<p class="text-center fst-italic">No attempts found.</p>';
        }
        echo '</div>';
        ?>
    </div>
<?php

echo $this->endSection();