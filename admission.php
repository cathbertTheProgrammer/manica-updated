<?php
// Connect to your MySQL database
$host = 'localhost';
$username = 'psaweb_admissions';
$password ='admissions@2024';
$dbname = 'psaweb_admission_applications';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract user data from the request
    $program = $_POST['program'];
    $academic_year = $_POST['academic_year'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];
    $category_id = $_POST['category_id'];
    $dob = $_POST['dob'];
    $nation_identification_number = $_POST['nation_identification_number'];
    $mobile_number = $_POST['mobile_number'];
    $previous_school = $_POST['previous_school'];
    $father_name = $_POST['father_name'];
    $father_phone = $_POST['father_phone'];
    $father_occupation = $_POST['father_occupation'];
    $mother_name = $_POST['mother_name'];
    $mother_phone = $_POST['mother_phone'];
    $mother_occupation = $_POST['mother_occupation'];
    $guardian = $_POST['guardian_is'];
    $guardian_name = $_POST['guardian_name'];
    $guardian_relation = $_POST['guardian_relation'];
    $guardian_phone = $_POST['guardian_phone'];
    $guardian_email = $_POST['guardian_email'];
    $guardian_address = $_POST['guardian_address'];

    $student_image_filename = $_FILES["student_image"]["name"];
    $student_image_temp_path = $_FILES["student_image"]["tmp_name"];
   
    $national_id_filename = $_FILES["national_id"]["name"];
    $national_id_temp_path = $_FILES["national_id"]["tmp_name"];

    $school_certificate_filename = $_FILES["school_certificate"]["name"];
    $school_certificate_temp_path = $_FILES["school_certificate"]["tmp_name"];

    $supporting_documents_filename = $_FILES["supporting_documents"]["name"];
    $supporting_documents_temp_path = $_FILES["supporting_documents"]["tmp_name"];

    $status = "submited";

    // Save the file to a directory
    $target_dir = "uploads/";
    if (!empty($student_image_filename)) {
        $target_path = $target_dir . basename($student_image_filename);
        move_uploaded_file($student_image_temp_path, $target_path);
    }

    if (!empty($national_id_filename)) {
        $target_path = $target_dir . basename($national_id_filename);
        move_uploaded_file($national_id_temp_path, $target_path);
    }

    if (!empty($school_certificate_filename)) {
        $target_path = $target_dir . basename($school_certificate_filename);
        move_uploaded_file($school_certificate_temp_path, $target_path);
    }

    if (!empty($supporting_documents_filename)) {
        $target_path = $target_dir . basename($supporting_documents_filename);
        move_uploaded_file($supporting_documents_temp_path, $target_path);
    }
  
  
  
    // Get current date and time
    $create_date = date("Y-m-d H:i:s");

    // Prepare and execute SQL statement to insert user data into the database
    $stmt = $conn->prepare("INSERT INTO student_admission (program, academic_year, firstname, lastname, email, student_image, gender, blood_group, category_id, dob, nation_identification_number, mobile_number, previous_school, father_name, father_phone, father_occupation, mother_name, mother_phone, mother_occupation, guardian, guardian_name, guardian_relation, guardian_phone, guardian_email, guardian_address, national_id, school_certificate, supporting_documents, status, createDate) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssssssssssssssssssssss", 
    $program,
    $academic_year,
    $firstname,
    $lastname,
    $email,
    $student_image_filename,
    $gender,
    $blood_group,
    $category_id,
    $dob,
    $nation_identification_number,
    $mobile_number,
    $previous_school,
    $father_name,
    $father_phone,
    $father_occupation,
    $mother_name,
    $mother_phone,
    $mother_occupation,
    $guardian,
    $guardian_name,
    $guardian_relation,
    $guardian_phone,
    $guardian_email,
    $guardian_address,
    $national_id_filename,
    $school_certificate_filename,
    $supporting_documents_filename,
    $status,
    $create_date
);


    
    if ($stmt->execute()) {
        // Send email with user data
        send_email_with_userdata($program, $academic_year, $firstname, $lastname, $email, $student_image_filename, $gender, $blood_group, $category_id, $dob, $nation_identification_number, $mobile_number, $previous_school, $father_name, $father_phone, $father_occupation, $mother_name, $mother_phone, $mother_occupation, $guardian, $guardian_name, $guardian_relation, $guardian_phone, $guardian_email, $guardian_address, $national_id_filename, $school_certificate_filename, $supporting_documents_filename);
        header("Location: admissiom-success.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}


    function send_email_with_userdata($program, $academic_year, $firstname, $lastname,  $email, $student_image_filename, $gender, $blood_group, $category_id, $dob, $nation_identification_number, $mobile_number, $previous_school, $father_name, $father_phone, $father_occupation, $mother_name, $mother_phone, $mother_occupation, $guardian, $guardian_name, $guardian_relation, $guardian_phone, $guardian_email, $guardian_address, $national_id_filename, $school_certificate_filename, $supporting_documents_filename) {
        // Configure email settings (SMTP server, sender, recipients, etc.)
        $to_admin = 'admissions@manicauniversity.com';
        // Email address of the administrator
        $to_user = $email; // User's email address
        $subject_admin = 'Student Application Form Submission'; 

       // Boundary for email parts
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

        // Headers for email
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"{$mime_boundary}\"\r\n";
        $headers .= "From:  admissions@manicauniversity.com\r\n";
        $headers .= "Reply-To:  admissions@manicauniversity.com\r\n";

        // Content of the email
        $admin_email_body = "--{$mime_boundary}\r\n";
        $admin_email_body .= "Content-Type:text/html;charset=UTF-8\r\n";
        $admin_email_body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            
            // Message for admin email
        $admin_email_body .= "
        <html>
        <head>
        <title>Student Application Form Submission</title>
        </head>
        <body>
        <p>Dear Admin,</p>
        <p>{$firstname} {$lastname} has just submitted their Application Form:</p>
        <p><strong>Program:</strong> {$program}</p>
        <p><strong>Academic Year:</strong> {$academic_year}</p>
        <p><strong>First Name:</strong> {$firstname}</p>
        <p><strong>Last Name:</strong> {$lastname}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Gender:</strong> {$gender}</p>
        <p><strong>Blood Group:</strong> {$blood_group}</p>
        <p><strong>Category ID:</strong> {$category_id}</p>
        <p><strong>Date of Birth:</strong> {$dob}</p>
        <p><strong>National Identification Number:</strong> {$nation_identification_number}</p>
        <p><strong>Mobile Number:</strong> {$mobile_number}</p>
        <p><strong>Previous School:</strong> {$previous_school}</p>
        <p><strong>Father's Name:</strong> {$father_name}</p>
        <p><strong>Father's Phone:</strong> {$father_phone}</p>
        <p><strong>Father's Occupation:</strong> {$father_occupation}</p>
        <p><strong>Mother's Name:</strong> {$mother_name}</p>
        <p><strong>Mother's Phone:</strong> {$mother_phone}</p>
        <p><strong>Mother's Occupation:</strong> {$mother_occupation}</p>
        <p><strong>Guardian:</strong> {$guardian}</p>
        <p><strong>Guardian's Name:</strong> {$guardian_name}</p>
        <p><strong>Guardian's Relation:</strong> {$guardian_relation}</p>
        <p><strong>Guardian's Phone:</strong> {$guardian_phone}</p>
        <p><strong>Guardian's Email:</strong> {$guardian_email}</p>
        <p><strong>Guardian's Address:</strong> {$guardian_address}</p>
        </body>
        </html>
        ";

        // Attachments array
        $attachments = array();

        $target_dir = "uploads/";

        // Add attachments if they exist and are not empty
        if (!empty($student_image_filename)) {
            if(file_exists($target_dir . $student_image_filename)) {
                $attachments[] = $target_dir . $student_image_filename;
            }
        }

        // Add attachments if they exist and are not empty
        if (!empty($national_id_filename)) {
            if(file_exists($target_dir . $national_id_filename)) {
                $attachments[] = $target_dir . $national_id_filename;
            }
        }

        if (!empty($school_certificate_filename)) {
            if(file_exists($target_dir . $school_certificate_filename)) {
                $attachments[] = $target_dir . $school_certificate_filename;
            }
        }
        if (!empty($supporting_documents_filename)) {
            if(file_exists($target_dir . $supporting_documents_filename)) {
                $attachments[] = $target_dir . $supporting_documents_filename;
            }
        }

        // Add attachments to email
        foreach ($attachments as $file) {
            $file_size = filesize($file);
            $handle = fopen($file, "r");
            $content = fread($handle, $file_size);
            fclose($handle);
            $content = chunk_split(base64_encode($content));
            $admin_email_body .= "\r\n--{$mime_boundary}\r\n" .
                "Content-Type: application/octet-stream;\r\n" .
                " name=\"" . basename($file) . "\"\r\n" .
                "Content-Disposition: attachment;\r\n" .
                " filename=\"" . basename($file) . "\"\r\n" .
                "Content-Transfer-Encoding: base64\r\n\r\n" .
                $content . "\r\n";
        }

       

        // End of the email
        $admin_email_body .= "--{$mime_boundary}--\r\n";

        

        $e_email_body = "--{$mime_boundary}\r\n";
        $e_email_body .= "Content-Type:text/html;charset=UTF-8\r\n";
        $e_email_body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";

        // Message for user email
        $e_subject = 'Confirmation of your Submission of the Application Form';
        $e_email_body .= "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        <html dir='ltr' xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office'>
        
        <head>
            <meta charset='UTF-8'>
            <meta content='width=device-width, initial-scale=1' name='viewport'>
            <meta name='x-apple-disable-message-reformatting'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta content='telephone=no' name='format-detection'>
            <title></title>
        
            <link href='https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap' rel='stylesheet'>
            
        </head>
        
        <body style='font-family: 'Kumbh Sans', sans-serif;'>
            <div dir='ltr' class='es-wrapper-color'>
            
                <table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0'>
                    <tbody>
                        <tr>
                            <td class='esd-email-paddings' valign='top'>
                                <table cellpadding='0' cellspacing='0' class='esd-header-popover es-header' align='center'>
                                    <tbody>
                                        <tr>
                                            <td class='esd-stripe' align='center'>
                                                <table bgcolor='#ffffff' class='es-header-body' align='center' cellpadding='0' cellspacing='0' width='600'>
                                                    <tbody>
                                                        <tr>
                                                            <td class='esd-structure es-p40' align='left' background='https://tlr.stripocdn.email/content/guids/CABINET_0fa486e736790bd0e3fdb2f0eb814a76/images/hectorjrivas1fxmet2u5duunsplash_1.png' style='background-image: url(https://tlr.stripocdn.email/content/guids/CABINET_0fa486e736790bd0e3fdb2f0eb814a76/images/hectorjrivas1fxmet2u5duunsplash_1.png); background-repeat: no-repeat; background-position: center top;'>
                                                                
                                                                <table cellpadding='0' cellspacing='0' class='es-left' align='left'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td width='156' class='es-m-p0r es-m-p20b esd-container-frame' valign='top' align='center'>
                                                                                <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align='center' class='esd-block-image es-m-txt-c es-p15b' style='font-size: 0px;'><a target='_blank' href='https://manicauniversity.com/'><img src='images/MANICA_logo.png' alt style='display: block;' height='60'></a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table cellpadding='0' cellspacing='0' class='es-content' align='center'>
                                    <tbody>
                                        <tr>
                                            <td class='esd-stripe' align='center'>
                                                <table bgcolor='#ffffff' class='es-content-body' align='center' cellpadding='0' cellspacing='0' width='600'>
                                                    <tbody>
                                                        <tr>
                                                            <td class='esd-structure es-p40t es-p30b es-p40r es-p40l es-m-p0b' align='cnter'>
                                                                <table cellpadding='0' cellspacing='0' width='100%'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td width='520' align='center' class='esd-container-frame'>
                                                                                <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align='center' class='esd-block-text' style='color: # #00D082;'>
                                                                                                <h2>Confirmation of Receipt of Your Application Form </h2>
                                                                                        
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class='esd-structure es-p30b es-p40r es-p40l' align='left'>
                                                                <table cellpadding='0' cellspacing='0' width='100%'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td width='520' class='esd-container-frame' align='center' valign='top'>
                                                                                <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align='left' class='esd-block-text'>
                                                                                                <p>We wanted to inform you that we have received your application form for the  {$program}. We appreciate the time and effort you put into completing the application.</p>
                                                                                                <p>Your application is currently under review. Our admissions team will carefully assess your qualifications and suitability for the program. Once the review process is complete, you will receive an acceptance letter via email. </p>
                                                                                                <p>In the meantime, if you have any questions or need further assistance, please feel free to reach out to us. We are here to help. </p>
                                                                                                <p>Thank you for choosing Manica University. We look forward to the possibility of welcoming you to our academic community.
                                                                                                <p>Warm Regards,</p>
                                                                                                <p>Manica University</p>
                                                                                            </td>
                                                                                    
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table cellpadding='0' cellspacing='0' class='es-content' align='center'>
                                    <tbody>
                                        <tr>
                                            <td class='esd-stripe' align='center'>
                                                <table bgcolor='#ffffff' class='es-content-body' align='center' cellpadding='0' cellspacing='0' width='600'>
                                                    <tbody>
                                                        <tr>
                                                            <td class='esd-structure es-p20t es-p40b es-p40r es-p40l' align='left'>
                                                            
                                                                <table cellpadding='0' cellspacing='0' class='es-right' align='center'>
                                                                    <tbody>
                                                                        <tr>
                                                                            
                                                                            <td align='center' class='esd-block-text text-center'>
                                                                                <h3>Manica University</h3>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!--[if mso]></td></tr></table><![endif]-->
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table cellpadding='0' cellspacing='0' class='es-footer' align='center'>
                                    <tbody>
                                        <tr>
                                            <td class='esd-stripe' align='center'>
                                                <table bgcolor='#ffffff' class='es-footer-body' align='center' cellpadding='0' cellspacing='0' width='600'>
                                                    <tbody>
                                                        <tr>
                                                            <td class='esd-structure es-p30t es-p30b es-p40r es-p40l' align='left' background='https://tlr.stripocdn.email/content/guids/CABINET_0fa486e736790bd0e3fdb2f0eb814a76/images/hectorjrivas1fxmet2u5duunsplash_1.png' style='background-image: url(https://tlr.stripocdn.email/content/guids/CABINET_0fa486e736790bd0e3fdb2f0eb814a76/images/hectorjrivas1fxmet2u5duunsplash_1.png); background-repeat: no-repeat; background-position: center top;'>
                                                                <!--[if mso]><table width='520' cellpadding='0' cellspacing='0'><tr><td width='194' valign='top'><![endif]-->
                                                                <table cellpadding='0' cellspacing='0' align='left' class='es-left'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td width='194' class='esd-container-frame es-m-p20b' align='left'>
                                                                                <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align='center' class='esd-block-image es-m-txt-c es-p15b' style='font-size: 0px;'><a target='_blank' href='https://pharmaconnectafrica.com/'><img src='images/MANICA_logo.png' alt style='display: block;' height='60'></a></td>
                                                                                        </tr>
                                                                                        
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!--[if mso]></td><td width='20'></td><td width='306' valign='top'><![endif]-->
                                                                <table cellpadding='0' cellspacing='0' class='es-right' align='right'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td width='306' align='left' class='esd-container-frame'>
                                                                                <table cellpadding='0' cellspacing='0' width='100%'>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align='center' class='esd-block-text es-p5t es-p15b'>
                                                                                            
                                        
                                                                                                <p><a > +260 772 166 392&nbsp;</a></p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!--[if mso]></td></tr></table><![endif]-->
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </body>
        
        </html>
        ";
        
    

        // Send emails to admin and user
        // mail($to_admin, $subject_admin, $message_admin, $headers);
        mail($to_admin, $subject_admin, $admin_email_body, $headers);
        mail($to_user, $e_subject, $e_email_body, $headers);
}

$conn->close();
?>