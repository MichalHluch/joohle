<?php

echo $this->extend("layout/master");
echo $this->section("content");
?>

        <?php
        echo '<div class="container px-5">';
        echo '  <div class="row gx-5 justify-content-center">';
        echo '    <div class="col-lg-8 col-xl-6">';
        echo '      <div class="text-center">';
        echo '        <h1 class="fw-bolder mb-5">TESTS</h1>';
        echo '      </div>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row d-flex justify-content-center ">';
        echo '<div class="text-center">';
        echo '<h4>Categories</h4>';
        echo '</div>';
        foreach($categories as $category) {
            echo '<div class="card border-1 m-3" style="max-width: 10rem;">';
            $echo_card = '
                <div class="card-body">
                    <p class="card-title text-dark fw-bolder">'.$category -> name.'</p>
                </div></div>';
            echo anchor("category/".$category -> id.'/', $echo_card, 'class="text-decoration-none"');
        }

        echo '</div>';
        echo '<div class="row d-flex justify-content-center mt-5">';
        echo '<div class="text-center">';
        echo '<h4>All tests</h4>';
        echo '</div>';
        foreach($tests as $test) {
            echo '
            <div class="card border-1 m-3" style="max-width: 20rem;">
                <div class="card-body">
                    <h5 class="card-title h4 text-dark fw-bolder">'.$test -> nazev.'</h5>
                    <p class="card-text text-muted fw-bolder"><span class="text-muted fw-normal">'.$test -> description.'</span></p>
                </div>
                <div class="card-footer mb-3 bg-transparent border-0">' . anchor('test/' . $test->id, 'Start', 'class="btn btn-outline-primary"') . '</div>
          </div>';
        }

        echo '</div>';
        ?>

    </div>

<?php
echo '<div class="d-flex justify-content-center m-5">';
if($pager->getPageCount() > 1) echo $pager->links();
echo '</div>';
echo $this->endSection();