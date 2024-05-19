<?php

echo $this->extend("layout/master");
echo $this->section("content");
?>

    <div class="col-12 pt-5">
        <h1 class="text-center pt-5">Tests</h1>

        <?php
        echo '<div class="row">';
        foreach($tests as $test) {
            echo '<div class="col-4">
                <div class="card bg-secondary mb-3" style="max-width: 20rem;">
                    <div class="card-body">
                        <h4 class="card-title text-black">' . $test->nazev . '</h4>
                        <div class="pt-1"></div>
                        <p class="card-text">
                            ' . anchor('test/' . $test->id, 'Open', 'class="btn btn-outline-primary"') . '<br></p>
                    </div>
                </div>
                <div class="pt-3"></div>
            </div>';
        }

        echo '</div>';
        ?>

    </div>

<?php
if($pager->getPageCount() > 1) echo $pager->links();
echo $this->endSection();