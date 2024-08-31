 <?php
    include('conn.inc.php');
    session_start();
    $sql = "SELECT * FROM tbl_faqs ORDER BY faq_created_at DESC";
    $result = mysqli_query($con, $sql);
    ?>
 <div class="accordion accordion-flush shadow" id="faqAccordion">
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
                     </div>
                 </div>
             </div>
         <?php } // End of while loop
        } else { ?>
         <p>No FAQs available.</p>
     <?php } ?>
 </div>