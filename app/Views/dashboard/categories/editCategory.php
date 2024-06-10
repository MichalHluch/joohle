<?php

echo $this->extend("layout/master");
echo $this->section("content");

echo form_open("dashboard/update-category/" . $category->id);
?>

    <div class="col-lg-8 col-md-10 col-12 offset-lg-2 offset-md-1 pt-5">
        <h1 class="text-center fw-bold pb-5">CATEGORY EDIT</h1>

        <div class="pt-3">
            <label for="name">Name:</label><input type="text" name="name" class="form-control" id="name" value="<?=$category->name?>" required>
        </div>

        <label for="pic">Category Image</label>
        <input type="file" name="pic" id="pic" class="form-control"/>

        <div class="text-center">
            <button type="submit" class="btn btn-primary mt-5">Update</button>
        </div>
    </div>

<?php
echo form_close();
echo $this->endSection();
