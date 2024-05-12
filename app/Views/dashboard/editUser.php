<?php

use IonAuth\Libraries\IonAuth;

echo $this->extend("layout/master");
echo $this->section("content");


echo form_open("dashboard/update-user/".$user->id);

$ionAuth = new IonAuth();
?>

    <div class="col-lg-4 col-md-8 col-10 offset-lg-4 offset-md-2 offset-1 pt-5">
        <h1 class="text-center fw-bold">EDIT USER</h1>

        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" id="username" value="<?= $user->username ?>" required>
        </div>

        <div class="mt-5">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email" value="<?= $user->email ?>" required>
        </div>

        <div class="mt-5">
            <label for="groups">Groups:</label>

            <select name="groups[]" id="groups" class="form-multi-select" multiple data-coreui-search="true" required>
                <?php

                foreach($ionAuth->groups()->result() as $group) {
                    echo '<option ' . ($ionAuth->inGroup($group, $user->id) ? 'selected' : '') . ' value="' . $group->id . '">' . $group->name . '</option>';
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-5">Update</button>

    </div>

<?php

echo form_close();
echo $this->endSection();
?>