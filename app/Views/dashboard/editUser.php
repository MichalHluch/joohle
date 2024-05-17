<?php

use IonAuth\Libraries\IonAuth;

echo $this->extend("layout/master");
echo $this->section("content");


echo form_open("dashboard/update-user/" . $user->id);

$ionAuth = new IonAuth();
?>
    <div class="col-lg-4 col-md-8 col-10 offset-lg-4 offset-md-2 offset-1 pt-5">
        <h1 class="text-center fw-bold">EDIT USER</h1>


        <div class="pt-3">
            <label for="username">First Name:</label>
            <input type="text" name="first_name" class="form-control" id="first_name" value="<?=$user->first_name?>" required>
        </div>

        <div class="pt-3">
            <label for="username">Last Name: </label>
            <input type="text" name="last_name" class="form-control" id="last_name" value="<?=$user->last_name?>" required>
        </div>

        <div class="pt-3">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" id="username" value="<?=$user->username?>" required>
        </div>

        <div class="pt-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email" value="<?=$user->email?>" required>
        </div>


        <div class="pt-3">
            <label for="groups">Groups</label>

            <select id="groups" name="groups" data-placeholder="Select Groups" multiple data-multi-select required>
                <?php
                foreach($ionAuth->groups()->result() as $group) {
                    $selected = $ionAuth->inGroup($group->id, $user->id) ? 'selected' : '';
                    echo '<option value="' . $group->id . '" ' . $selected . '>' . $group->name . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary mt-5">Update</button>
        </div>

    </div>


    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/css/MultiSelect.css");?>">
    <script src="<?=base_url("assets/js/MultiSelect.js");?>"></script>
<?php

echo form_close();
echo $this->endSection();
?>