<?php

use CodeIgniter\View\Table;

echo $this->extend("layout/master");
echo $this->section("content");

?>

    <div class="col-lg-10 col-md-10 col-12 offset-lg-1 offset-md-1 pt-5">
        <h1 class="text-center fw-bold pb-5">ATTEMPTS</h1>

        <?php
        $table = new Table();
        $table->setHeading('ID', 'USERNAME', 'TEST', 'SCORE', '');
        $template = array('table_open' => '<table class="table">', 'thead_open' => '<thead>', 'thead_close' => '</thead>', 'heading_row_start' => '<tr>', 'heading_row_end' => ' </tr>', 'heading_cell_start' => '<th class="fw-bold text-center">', 'heading_cell_end' => '</th>', 'tbody_open' => '<tbody>', 'tbody_close' => '</tbody>', 'row_start' => '<tr class="text-center align-middle">', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr class="text-center align-middle">', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table>');

        $table->setTemplate($template);

        foreach($attempts as $attempt) {

            $deleteBtn = "<button type=\"button\" class=\"btn btn-outline-danger ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $attempt->id . "\">Delete</button>";

            $table->addRow($attempt->attempt_id, $attempt->username, $attempt->nazev, $attempt->score . '/' . $attempt->max_score, $deleteBtn);

            echo form_modal("modal" . $attempt->id, $attempt->id, "Delete Attempt", "Do you really want to delete attempt of \"" . $attempt->username . "\" test: \"".$attempt->nazev ."\"?", "dashboard/delete-attempt/" . $attempt->id);
        }

        echo $table->generate();

        ?>
    </div>

<?php
echo $this->endSection();