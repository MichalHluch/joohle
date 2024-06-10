<?php

use CodeIgniter\View\Table;

echo $this->extend("layout/master");
echo $this->section("content");
?>

    <div class="col-lg-8 col-md-10 col-12 offset-lg-2 offset-md-1 pt-5">
        <h1 class="text-center fw-bold pb-5">TESTS</h1>

        <?php
        $table = new Table();
        $table->setHeading('ID', 'NAME', '');
        $template = array('table_open' => '<table class="table">', 'thead_open' => '<thead>', 'thead_close' => '</thead>', 'heading_row_start' => '<tr>', 'heading_row_end' => ' </tr>', 'heading_cell_start' => '<th class="fw-bold text-center">', 'heading_cell_end' => '</th>', 'tbody_open' => '<tbody>', 'tbody_close' => '</tbody>', 'row_start' => '<tr class="text-center align-middle">', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr class="text-center align-middle">', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table>');

        $table->setTemplate($template);

        foreach($tests as $test) {

            $editBtn = anchor('dashboard/edit-test/' . $test->id, 'Edit', 'class="btn btn-outline-primary"');
            $deleteBtn = "<button type=\"button\" class=\"btn btn-outline-danger ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $test->id . "\">Delete</button>";

            $table->addRow($test->id, $test->nazev, $editBtn . $deleteBtn);

            echo form_modal("modal" . $test->id, $test->id, "Delete User", "Do you really want to delete test \"" . $test->nazev . "\"?", "dashboard/delete-test/" . $test->id);
        }

        $table->addRow(anchor('dashboard/add-test', 'ADD MORE', 'class="btn btn-outline-primary"'), "", "");

        echo $table->generate();

        ?>
    </div>

<?php
echo $this->endSection();