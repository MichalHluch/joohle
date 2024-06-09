<?php

echo $this->extend("layout/master");
echo $this->section("content");

echo form_open_multipart("dashboard/create-category");
?>

    <div class="col-lg-8 col-md-10 col-12 offset-lg-2 offset-md-1 pt-5">
        <h1 class="text-center fw-bold pb-5">CREATE A CATEGORY</h1>

        <div class="pt-3">
            <label for="name">Name:</label><input type="text" name="name" class="form-control" id="name" required>
        </div>

        <label for="pic">Category Image</label>
        <input type="file" name="pic" id="pic" class="form-control" required/>


        <div class="text-center">
            <button type="submit" class="btn btn-primary mt-5">Create</button>
        </div>
    </div>

<?php
echo form_close();
echo $this->endSection();
