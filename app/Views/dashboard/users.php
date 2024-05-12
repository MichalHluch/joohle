<?php

use CodeIgniter\View\Table;
use IonAuth\Libraries\IonAuth;

echo $this->extend("layout/master");
echo $this->section("content");

$ionAuth = new IonAuth();
?>

    <div class="col-lg-6 col-md-8 col-10 offset-lg-3 offset-md-2 offset-1 pt-5">
        <h1 class="text-center fw-bold pb-5">DASHBOARD</h1>

        <?php
        $table = new Table();
        $table->setHeading('ID', 'USERNAME', 'EMAIL', 'GROUPS', '');
        $template = array('table_open' => '<table class="table">', 'thead_open' => '<thead class="text-center">', 'thead_close' => '</thead>', 'heading_row_start' => '<tr>', 'heading_row_end' => ' </tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'tbody_open' => '<tbody>', 'tbody_close' => '</tbody>', 'row_start' => '<tr class="text-center">', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table>');

        $table->setTemplate($template);

        foreach($users as $user) {

            $editBtn = anchor('dashboard/edit-user/' . $user->id, 'Edit', 'class="btn btn-outline-primary"');
            $deleteBtn = "<button type=\"button\" class=\"btn btn-outline-primary ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $user->id . "\">Delete User</button>";

            $userGroups = $ionAuth->getUsersGroups($user->id)->getResult();

            $groupNames = array();
            foreach($userGroups as $group) {
                $groupNames[] = "<span class=\"badge bg-primary\">" . $group->name . "</span>";
            }

            $groupList = implode(' ', $groupNames);

            $table->addRow($user->id, $user->username, $user->email, $groupList, $editBtn . $deleteBtn);

            echo form_modal("modal" . $user->id, $user->id, "Delete User", "Do you really want to delete " . $user->username . "?", "dashboard/delete-user/" . $user->id);
        }

        echo $table->generate();
        ?>
    </div>


<?php
echo $this->endSection();