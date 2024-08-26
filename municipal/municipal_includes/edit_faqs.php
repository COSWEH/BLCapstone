<!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php
include('../../includes/conn.inc.php');
session_start();

$sql = "SELECT * FROM tbl_faqs ORDER BY faq_created_at DESC";
$result = mysqli_query($con, $sql);
?>
<form method="POST" action="municipal_includes/update_faqs.php">
    <div class="accordion" id="faqAccordion">
        <input type="hidden" id="faqid" name="faqid">
        <!-- FAQs -->
        <?php if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?php echo $row['faq_id']; ?>">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $row['faq_id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $row['faq_id']; ?>">
                            <?php echo $row['faq_question']; ?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $row['faq_id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $row['faq_id']; ?>" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p><?php echo $row['faq_answer']; ?></p>

                            <!-- Button to trigger the form submission -->
                            <button type="submit" class="btn btn-outline-danger faq" name="btnDelete" value="<?php echo $row['faq_id']; ?>">
                                Delete <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php } // End of while loop
        } else { ?>
            <p>No FAQs available.</p>
        <?php } ?>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.faq', function() {
            let f_id = $(this).val();
            console.log(f_id);

            $(`#faqid`).val(f_id);
        });
    });
</script>