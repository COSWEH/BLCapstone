<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../document.c.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT req_id, user_id, req_date, req_fname, req_mname, req_lname, req_contactNo, req_gender, req_brgy, req_purok, req_age, req_dateOfBirth, req_placeOfBirth, req_civilStatus, req_typeOfDoc, req_status
          FROM tbl_requests
          WHERE user_id = '$user_id' && req_brgy = '$civilian_brgy' && req_status = 'Approved'
          ORDER BY req_date DESC";


$result = mysqli_query($con, $query);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

$rowCount = mysqli_num_rows($result);

if ($rowCount == 0) {
    echo "<p>No document requests found.</p>";
}

while ($data = mysqli_fetch_assoc($result)) {
    // Fetch data from tbl_requests
    $reqId = $data['req_id'];
    $userId = $data['user_id'];
    $reqDate = $data['req_date'];
    $fname = $data['req_fname'];
    $mname = $data['req_mname'];
    $lname = $data['req_lname'];
    $contactNo = $data['req_contactNo'];
    $gender = $data['req_gender'];
    $brgy = $data['req_brgy'];
    $purok = $data['req_purok'];
    $age = $data['req_age'];
    $dateOfBirth = $data['req_dateOfBirth'];
    $req_placeOfBirth = $data['req_placeOfBirth'];
    $req_civilStatus = $data['req_civilStatus'];
    $docType = $data['req_typeOfDoc'];
    $status = $data['req_status'];

    $docTypeWithoutBrgy = preg_replace('/\s*\(.*?\)\s*/', '', $docType);

    $get_Time_And_Day = new DateTime($reqDate);
    $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');

    $getDocTemplateQuery = "SELECT doc_template FROM tbl_typedoc WHERE docType = '$docType'";
    $getDtResult = mysqli_query($con, $getDocTemplateQuery);

    if (
        mysqli_num_rows($getDtResult) > 0
    ) {
        $row = mysqli_fetch_assoc($getDtResult);

        $getDocumentTemplate = $row['doc_template'];
        $pdfFileUrl = 'civilian_includes/doc_template/' . $getDocumentTemplate;
    }
?>

    <!-- List of Document Requests -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-2">
        <div class="card shadow border border-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center text-center ">
                    <h5 class="card-title mb-0 mx-auto"><?php echo $docTypeWithoutBrgy; ?></h5>
                    <a type="button" class="btn btn-sm shadow position-relative btnPreview<?php echo $reqId; ?>" data-doc-type="<?php echo $docTypeWithoutBrgy; ?>" data-bs-toggle="modal" data-bs-target="#docTypePreviewModal<?php echo $reqId; ?>" data-bs-toggle="tooltip" title="Document Preview">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </a>
                </div>
                <hr>
                <div class="d-flex flex-column mb-2">
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <small>
                                <i class="bi bi-person-fill me-2">
                                    <span class="ms-2">Name:</span>
                                </i>
                            </small>
                            <?php echo $fname . " " . $mname . " " . $lname; ?>
                        </h6>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <small>
                                <i class="bi bi-phone-fill me-2">
                                    <span class="ms-2">Contact No:</span>
                                </i>
                            </small>
                            <?php echo $contactNo; ?>
                        </h6>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <small>
                                <i class="bi bi-calendar3 me-2">
                                    <span class="ms-2">Age:</span>
                                </i>
                            </small>
                            <?php echo $age; ?> years old
                        </h6>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <small>
                                <i class="bi bi-house-door-fill me-2">
                                    <span class="ms-2">Barangay:</span>
                                </i>
                            </small>
                            <?php echo $brgy; ?>
                        </h6>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <small>
                                <i class="bi bi-check-circle-fill">
                                    <span class="ms-2">Status:</span>
                                </i>
                            </small>
                            <span class="text-success">
                                <?php echo $status; ?>
                            </span>
                            <span class="text-body-tertiary">
                                (You can now go to your respective Barangay halls to pickup your request document)
                            </span>
                        </h6>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- doc type preview modal -->
    <div class="modal fade" id="docTypePreviewModal<?php echo $reqId; ?>" tabindex="-1" aria-labelledby="docTypePreviewModal<?php echo $reqId; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto mb-3" style="height: 50px; width: 50px;">
                        <i class="bi bi-eye-fill text-primary" style="font-size: 25px;"></i>
                    </div>

                    <h5 class="fw-semibold">Document Preview</h5>
                    <p class="text-muted mb-4">This is just a template preview. The actual document will be available at the designated pickup location.</p>

                    <!-- Container for PDF.js -->
                    <div id="pdf-container<?php echo $reqId; ?>" class="row"></div>
                </div>

                <!-- Modal Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js"></script>

    <script>
        document.querySelectorAll('.btnPreview<?php echo $reqId; ?>').forEach(button => {
            button.addEventListener('click', function() {
                const reqId = "<?php echo $reqId; ?>";
                const pdfUrl = "<?php echo $pdfFileUrl; ?>";
                const container = document.getElementById(`pdf-container${reqId}`);

                console.log(pdfUrl);

                // Clear the container in case it has content from previous renders
                container.innerHTML = '';

                // Loading the PDF
                pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
                    // Loop through each page and render it
                    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                        pdf.getPage(pageNum).then(page => {
                            const scale = 1.5; // Adjust scale as needed
                            const viewport = page.getViewport({
                                scale: scale
                            });

                            // Create a canvas element for each page
                            const canvas = document.createElement('canvas');
                            canvas.width = viewport.width;
                            canvas.height = viewport.height;
                            container.appendChild(canvas);

                            const context = canvas.getContext('2d');

                            // Render the page into the canvas context
                            const renderContext = {
                                canvasContext: context,
                                viewport: viewport
                            };
                            page.render(renderContext);
                        }).catch(error => {
                            console.error("Error rendering page:", error);
                        });
                    }
                }).catch(error => {
                    console.error('Error loading PDF:', error);
                });
            });
        });
    </script>

<?php
}
?>

<script>
    $(document).ready(function() {
        $(document).on('click', '.btnCancelRequest', function() {
            let p_id = $(this).data('post-id'); // Retrieve post ID from update button
            $('#getReqID').val(p_id);

            console.log(p_id);

        });
    });
</script>