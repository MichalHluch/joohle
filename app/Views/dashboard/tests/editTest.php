<?php

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
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary my-5">Update</button>
        </div>
    </div>

<?php
echo form_close();
echo $this->endSection();
