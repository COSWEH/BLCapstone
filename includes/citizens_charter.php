<style>
    .active-category {
        text-decoration: underline;
    }

    .card .card-body p {
        font-size: 16px;
    }

    .card .card-body ul li {
        font-size: 16px;
    }

    .card table tr th {
        font-size: 1.75rem;
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

    <nav class="navbar mb-3 sticky-top bg-success rounded-3 p-2">
        <div class="container-fluid">
            <div class="row w-100">
                <div class="col text-center">
                    <a href="#" id="cat1" class="fw-bold text-decoration-none text-success-emphasis link-offset-3 active"
                        title="Office of the Municipal Civil Registrar">
                        OMCR
                    </a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat2" class="fw-bold text-decoration-none text-light link-offset-3"
                        title="Municipal Social Welfare and Development Office External Services">
                        MSWD
                    </a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat3" class="fw-bold text-decoration-none text-light link-offset-3"
                        title="Office of the Municipal Treasurer External Services">
                        MTO
                    </a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat4" class="fw-bold text-decoration-none text-light link-offset-3"
                        title="Office of the Municipal Agriculturist External Services">
                        OMA
                    </a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat5" class="fw-bold text-decoration-none text-light link-offset-3"
                        title="Office of the Municipal Assessor External Services">
                        OMAss
                    </a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat6" class="fw-bold text-decoration-none text-light link-offset-3"
                        title="Municipal Health Office External Services">
                        MHO
                    </a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat7" class="fw-bold text-decoration-none text-light link-offset-3"
                        title="Office of the Municipal Accountant Internal Services">
                        OMAc
                    </a>
                </div>
                <div class="col text-center">
                    <a href="#" id="cat8" class="fw-bold text-decoration-none text-light link-offset-3"
                        title="Office of the Municipal Disaster Risk Reduction and Management External Services">
                        MDRRMO
                    </a>
                </div>
            </div>
        </div>

        <hr>

        <div class="container mt-5 w-100">
            <label for="searchCat1" class="form-label text-light fs-5">Search</label>
            <div class="input-group">
                <!-- Search Icon with Light Background -->
                <span class="input-group-text bg-light border-light" id="search-icon">
                    <i class="bi bi-search text-dark"></i> <!-- Icon color set to dark -->
                </span>
                <!-- Search Input with Light Background -->
                <input type="search" class="form-control bg-light border-light text-dark" name="searchCat1" id="searchCat1" placeholder="Search..." aria-label="Search">
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

    <div id="showCat6">
        <?php
        include('cc/category_6.php');
        ?>
    </div>

    <div id="showCat7">
        <?php
        include('cc/category_7.php');
        ?>
    </div>

    <div id="showCat8">
        <?php
        include('cc/category_8.php');
        ?>
    </div>

    <!-- faqs -->
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                    What is a Citizen's Charter?
                </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    A Citizen's Charter is a document that outlines the services provided by a government office or agency, including the procedures, requirements, service fees, and timelines for availing of these services. It promotes transparency, efficiency, and accountability in public service delivery.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                    What are the components of a Citizen's Charter?
                </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    A Citizen's Charter typically includes: <br>
                    - A list of services provided <br>
                    - Step-by-step procedures <br>
                    - Requirements and necessary documents <br>
                    - Service fees (if applicable) <br>
                    - Estimated processing times <br>
                    - Contact details of responsible personnel <br>
                    - Feedback and complaint mechanisms
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                    How does the Citizen's Charter benefit the public?
                </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    The Citizen's Charter benefits the public by providing clear and accessible information about government services, reducing red tape, ensuring faster service delivery, and holding government offices accountable for their commitments.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                    Where can I find the Citizen's Charter in my municipality?
                </button>
            </h2>
            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    The Citizen's Charter is usually displayed in government offices, such as municipal halls, and can also be accessed on the official websites of local government units or agencies.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                    What should I do if a government office fails to comply with the Citizen's Charter?
                </button>
            </h2>
            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    If a government office fails to comply with its Citizen's Charter, you can file a complaint through the designated feedback and complaint mechanism specified in the Charter or report it to the Civil Service Commission (CSC) or the Anti-Red Tape Authority (ARTA).
                </div>
            </div>
        </div>
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
            $('a[id^="cat"]').removeClass('active text-success-emphasis').addClass('text-light');
            $(this).addClass('active text-success-emphasis').removeClass('text-light');
        });

        document.getElementById('searchCat1').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const headings = document.querySelectorAll('h4');

            // Loop through all <h4> elements to find a match
            for (const heading of headings) {
                if (heading.textContent.toLowerCase().includes(query)) {
                    // Scroll to the matched heading
                    heading.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    heading.style.backgroundColor = '#3b3b3b'; // Highlight the matched heading
                    setTimeout(() => heading.style.backgroundColor = '', 2000); // Remove highlight after 2 seconds
                    break;
                }
            }
        });
    });
</script>