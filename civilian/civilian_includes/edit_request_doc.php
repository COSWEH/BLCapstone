<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['sumbitDocRequest']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $haveAuthLetter = $_POST['haveAuthLetter'];

    if ($haveAuthLetter === 'Yes') {
        // echo 'for others';
        $getSubmitReqDocId = $_POST['getSubmitReqDocId'];
        $docType = $_POST['docType'];
        $editFirstName = $_POST['editFirstName'];
        $editMiddleName = $_POST['editMiddleName'];
        $editLastName = $_POST['editFirstName'];
        $contactNum = $_POST['contactNum'];
        $barangay = $_POST['barangay'];
        $user_purok = $_POST['user_purok'];
        $gender = $_POST['gender'];
        $dateOfBirth = $_POST['dateOfBirth'];
        $age = $_POST['age'];
        $placeOfBirth = $_POST['placeOfBirth'];
        $civilStatus = $_POST['civilStatus'];

        $prevAuthLetter = $_POST['prevAuthLetter'];
        $prevESignature = $_POST['prevESignature'];
        $prevFrontValidID = $_POST['prevFrontValidID'];
        $prevBackValidID = $_POST['prevBackValidID'];

        $authLetterName = $prevAuthLetter;
        $eSignatureName = $prevESignature;
        $frontValidIDName = $prevFrontValidID;
        $backValidIDName = $prevBackValidID;
        $allowedExtensions = [
            'jpg',
            'jpeg',
            'png'
        ];

        // auth letter
        if (isset($_FILES['editAuthLetter']) && $_FILES['editAuthLetter']['error'] === UPLOAD_ERR_OK) {
            $editAuthLetter = $_FILES['editAuthLetter'];
            $editAuthLetterName = $editAuthLetter['name'];
            $editAuthLetterTmpName = $editAuthLetter['tmp_name'];
            $editAuthLetterExtension = strtolower(pathinfo($editAuthLetterName, PATHINFO_EXTENSION));

            if (in_array($editAuthLetterExtension, $allowedExtensions)) {
                $editAuthLetterBaseName = pathinfo($editAuthLetterName, PATHINFO_FILENAME);
                $newEditAuthLetterName = $editAuthLetterBaseName . '-[BayanLink-' . uniqid() . '].' . $editAuthLetterExtension;
                $authLetterPath = '../civilian_dbImg/' . $newEditAuthLetterName;

                if (move_uploaded_file($editAuthLetterTmpName, $authLetterPath)) {
                    $authLetterName = $newEditAuthLetterName;
                } else {
                    die('Error uploading the authorization letter.');
                }
            } else {
                die('Invalid file format for the authorization letter.');
            }
        }

        //e-signature
        if (isset($_FILES['editESignature']) && $_FILES['editESignature']['error'] === UPLOAD_ERR_OK) {
            $editESignature = $_FILES['editESignature'];
            $editESignatureName = $editESignature['name'];
            $editESignatureTmpName = $editESignature['tmp_name'];
            $editESignatureExtension = strtolower(pathinfo($editESignatureName, PATHINFO_EXTENSION));

            if (in_array($editESignatureExtension, $allowedExtensions)) {
                $editESignatureBaseName = pathinfo($editESignatureName, PATHINFO_FILENAME);
                $newEditESignatureName = $editESignatureBaseName . '-[BayanLink-' . uniqid() . '].' . $editESignatureExtension;
                $editESignaturePath = '../civilian_dbImg/' . $newEditESignatureName;

                if (move_uploaded_file($editESignatureTmpName, $editESignaturePath)) {
                    $eSignatureName = $newEditESignatureName;
                } else {
                    die('Error uploading the e-signature.');
                }
            } else {
                die('Invalid file format for the e-signature.');
            }
        }

        // front ID
        if (isset($_FILES['editFrontValidID']) && $_FILES['editFrontValidID']['error'] === UPLOAD_ERR_OK) {
            $editFrontValidID = $_FILES['editFrontValidID'];

            $editFrontValidIDName = $editFrontValidID['name'];
            $editFrontValidIDTmpName = $editFrontValidID['tmp_name'];
            $editFrontValidIDExtension = strtolower(pathinfo($editFrontValidIDName, PATHINFO_EXTENSION));

            if (in_array($editFrontValidIDExtension, $allowedExtensions)) {
                $editFrontValidIDBaseName = pathinfo($editFrontValidIDName, PATHINFO_FILENAME);
                $newEditFrontValidIDName = $editFrontValidIDBaseName . '-[BayanLink-' . uniqid() . '].' . $editFrontValidIDExtension;
                $editFrontValidIDPath = '../civilian_dbImg/' . $newEditFrontValidIDName;

                if (move_uploaded_file($editFrontValidIDTmpName, $editFrontValidIDPath)) {
                    $frontValidIDName = $newEditFrontValidIDName;
                } else {
                    die('Error uploading the front ID.');
                }
            } else {
                die('Invalid file format for the front ID.');
            }
        }

        // back ID
        if (isset($_FILES['editBackValidID']) && $_FILES['editBackValidID']['error'] === UPLOAD_ERR_OK) {
            $editBackValidID = $_FILES['editBackValidID'];

            $editBackValidIDName = $editBackValidID['name'];
            $editBackValidIDTmpName = $editBackValidID['tmp_name'];
            $editBackValidIDExtension = strtolower(pathinfo($editBackValidIDName, PATHINFO_EXTENSION));

            if (in_array($editBackValidIDExtension, $allowedExtensions)) {
                $editBackValidIDBaseName = pathinfo($editBackValidIDName, PATHINFO_FILENAME);
                $newEditBackValidIDName = $editBackValidIDBaseName . '-[BayanLink-' . uniqid() . '].' . $editBackValidIDExtension;
                $editBackValidIDPath = '../civilian_dbImg/' . $newEditBackValidIDName;

                if (move_uploaded_file($editBackValidIDTmpName, $editBackValidIDPath)) {
                    $backValidIDName = $newEditBackValidIDName;
                } else {
                    die('Error uploading the front ID.');
                }
            } else {
                die('Invalid file format for the front ID.');
            }
        }

        // Update the database with the new values
        $query = mysqli_query($con, "UPDATE `tbl_requests` SET 
                `req_date` = CURRENT_TIMESTAMP, 
                `req_fname` = '$editFirstName', 
                `req_mname` = '$editMiddleName', 
                `req_lname` = '$editLastName', 
                `req_contactNo` = '$contactNum', 
                `req_gender` = '$gender', 
                `req_brgy` = '$barangay', 
                `req_purok` = '$user_purok', 
                `req_age` = '$age', 
                `req_dateOfBirth` = '$dateOfBirth', 
                `req_placeOfBirth` = '$placeOfBirth', 
                `req_civilStatus` = '$civilStatus', 
                `req_eSignature` = '$eSignatureName',
                `req_typeOfDoc` = '$docType', 
                `authLetter` = '$authLetterName',
                `req_valid_front_id` = '$frontValidIDName',
                `req_valid_back_id` = '$backValidIDName',
                `req_status` = 'Pending', 
                `req_reasons` = NULL 
                WHERE `req_id` = '$getSubmitReqDocId'");

        if ($query) {
            $_SESSION['edit_req_doc'] = "Document successfully edited!";
            header('Location: ../document.c.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } else {
        // echo 'for youself';
        $getSubmitReqDocId = $_POST['getSubmitReqDocId'];
        $docType = $_POST['docType'];

        $prevESignature = $_POST['prevESignature'];
        $prevFrontValidID = $_POST['prevFrontValidID'];
        $prevBackValidID = $_POST['prevBackValidID'];

        $eSignatureName = $prevESignature;
        $frontValidIDName = $prevFrontValidID;
        $backValidIDName = $prevBackValidID;
        $allowedExtensions = [
            'jpg',
            'jpeg',
            'png'
        ];

        //e-signature
        if (isset($_FILES['editESignature']) && $_FILES['editESignature']['error'] === UPLOAD_ERR_OK) {
            $editESignature = $_FILES['editESignature'];
            $editESignatureName = $editESignature['name'];
            $editESignatureTmpName = $editESignature['tmp_name'];
            $editESignatureExtension = strtolower(pathinfo($editESignatureName, PATHINFO_EXTENSION));

            if (in_array($editESignatureExtension, $allowedExtensions)) {
                $editESignatureBaseName = pathinfo($editESignatureName, PATHINFO_FILENAME);
                $newEditESignatureName = $editESignatureBaseName . '-[BayanLink-' . uniqid() . '].' . $editESignatureExtension;
                $editESignaturePath = '../civilian_dbImg/' . $newEditESignatureName;

                if (move_uploaded_file($editESignatureTmpName, $editESignaturePath)) {
                    $eSignatureName = $newEditESignatureName;
                } else {
                    die('Error uploading the e-signature.');
                }
            } else {
                die('Invalid file format for the e-signature.');
            }
        }

        // front ID
        if (isset($_FILES['editFrontValidID']) && $_FILES['editFrontValidID']['error'] === UPLOAD_ERR_OK) {
            $editFrontValidID = $_FILES['editFrontValidID'];

            $editFrontValidIDName = $editFrontValidID['name'];
            $editFrontValidIDTmpName = $editFrontValidID['tmp_name'];
            $editFrontValidIDExtension = strtolower(pathinfo($editFrontValidIDName, PATHINFO_EXTENSION));

            if (in_array($editFrontValidIDExtension, $allowedExtensions)) {
                $editFrontValidIDBaseName = pathinfo($editFrontValidIDName, PATHINFO_FILENAME);
                $newEditFrontValidIDName = $editFrontValidIDBaseName . '-[BayanLink-' . uniqid() . '].' . $editFrontValidIDExtension;
                $editFrontValidIDPath = '../civilian_dbImg/' . $newEditFrontValidIDName;

                if (move_uploaded_file($editFrontValidIDTmpName, $editFrontValidIDPath)) {
                    $frontValidIDName = $newEditFrontValidIDName;
                } else {
                    die('Error uploading the front ID.');
                }
            } else {
                die('Invalid file format for the front ID.');
            }
        }

        // back ID
        if (isset($_FILES['editBackValidID']) && $_FILES['editBackValidID']['error'] === UPLOAD_ERR_OK) {
            $editBackValidID = $_FILES['editBackValidID'];

            $editBackValidIDName = $editBackValidID['name'];
            $editBackValidIDTmpName = $editBackValidID['tmp_name'];
            $editBackValidIDExtension = strtolower(pathinfo($editBackValidIDName, PATHINFO_EXTENSION));

            if (in_array($editBackValidIDExtension, $allowedExtensions)) {
                $editBackValidIDBaseName = pathinfo($editBackValidIDName, PATHINFO_FILENAME);
                $newEditBackValidIDName = $editBackValidIDBaseName . '-[BayanLink-' . uniqid() . '].' . $editBackValidIDExtension;
                $editBackValidIDPath = '../civilian_dbImg/' . $newEditBackValidIDName;

                if (move_uploaded_file($editBackValidIDTmpName, $editBackValidIDPath)) {
                    $backValidIDName = $newEditBackValidIDName;
                } else {
                    die('Error uploading the front ID.');
                }
            } else {
                die('Invalid file format for the front ID.');
            }
        }

        // Update the database with the new values
        $query = mysqli_query($con, "UPDATE `tbl_requests` SET 
                `req_eSignature` = '$eSignatureName',
                `req_typeOfDoc` = '$docType', 
                `req_valid_front_id` = '$frontValidIDName',
                `req_valid_back_id` = '$backValidIDName',
                `req_status` = 'Pending', 
                `req_reasons` = NULL 
                WHERE `req_id` = '$getSubmitReqDocId'");

        if ($query) {
            $_SESSION['edit_req_doc'] = "Document successfully edited!";
            header('Location: ../document.c.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    }
}
