<style>
    .active-category {
        text-decoration: underline;
    }
</style>


<div class="container">
    <div class="d-flex justify-content-center align-items-center mb-3">
        <div class="row align-items-center text-center w-100 px-3">
            <!-- Logo -->
            <div class="col-12 col-md-auto mb-3 mb-md-0">
                <img src="img/san_isidroLogo.png" alt="San Isidro Logo" class="img-fluid" style="max-height: 100px;">
            </div>
            <!-- Header Text -->
            <div class="col-12 col-md">
                <h1 class="mb-0 fw-bold text-success">CITIZEN'S CHARTER</h1>
            </div>
        </div>
    </div>

    <nav class="navbar mb-3">
        <div class="container-fluid">
            <div class="row w-100">
                <div class="col text-center">
                    <a href="#" id="cat1" class="fw-bold text-decoration-none text-primary link-offset-3 active">Category 1</a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat2" class="fw-bold text-decoration-none text-success link-offset-3">Category 2</a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat3" class="fw-bold text-decoration-none text-success link-offset-3">Category 3</a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat4" class="fw-bold text-decoration-none text-success link-offset-3">Category 4</a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat5" class="fw-bold text-decoration-none text-success link-offset-3">Category 5</a>
                </div>
            </div>
        </div>
    </nav>




    <div id="showCat1">
        <?php
        include('cc/category_1.php');
        ?>
    </div>

    <div id="showCat2">
        <?php
        include('cc/category_2.php');
        ?>
    </div>

    <div id="showCat3">
        <?php
        include('cc/category_3.php');
        ?>
    </div>

    <div id="showCat4">
        <?php
        include('cc/category_4.php');
        ?>
    </div>

    <div id="showCat5">
        <?php
        include('cc/category_5.php');
        ?>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#showCat1').show();
        $('[id^="showCat"]').not('#showCat1').hide();

        // Handle click events for categories
        $('a[id^="cat"]').on('click', function() {
            const clickedId = $(this).attr('id');
            const targetToShow = `#show${clickedId.charAt(0).toUpperCase() + clickedId.slice(1)}`;

            // Hide all categories
            $('[id^="showCat"]').hide();

            // Show the selected category
            $(targetToShow).show();

            // Update active state for the navigation links
            $('a[id^="cat"]').removeClass('active text-primary').addClass('text-success');
            $(this).addClass('active text-primary').removeClass('text-success');
        });
    });
</script>