<?php

use CodeIgniter\View\Table;

echo $this->extend("layout/master");
echo $this->section("content");
?>

    <div class="col-lg-4 col-md-8 col-10 offset-lg-4 offset-md-2 offset-1 pt-5">
        <h1 class="text-center fw-bold">DASHBOARD</h1>


        <p>users - edit, remove</p>

        <?php
        $table = new Table();
        $table->setHeading('id', 'username', 'email', 'admin');
        $template = array(
            'table_open'=> '<table class="table table-bordered">',
            'thead_open'=> '<thead class="text-center">',
            'thead_close'=> '</thead>',
            'heading_row_start'=> '<tr>',
            'heading_row_end'=>' </tr>',
            'heading_cell_start'=> '<th>',
            'heading_cell_end' => '</th>',
            'tbody_open' => '<tbody>',
            'tbody_close' => '</tbody>',
            'row_start' => '<tr class="text-center">',
            'row_end'  => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );

        $table->setTemplate($template);
        foreach ($users as $user) {
            $table->addRow($user->id, $user->username, $user->email, $ionAuth->isAdmin($user->id) ? 'Yes' : 'No');
        }
        echo $table->generate();
        ?>
    </div>


<?php
echo $this->endSection();