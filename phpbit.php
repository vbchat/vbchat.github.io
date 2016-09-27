<?php
//******************************************************************************
//check if any errors occurred during the upload.
$isDocUploaded = true; //initialise flag that says whether jpg was uploaded
$errorsOccurred = false;
 
echo '<div style="font-family: tahoma, sans-serif; font-size: 10pt">';
 
foreach($_FILES['txtUploadFile']['error'] as $key => $value) {
    if($_FILES['txtUploadFile']['name'][$key] != '') {
        echo '<p><hr />Uploading File: '.$_FILES['txtUploadFile']['name'][$key].'</p>';
        if($value > 0) {
            $isDocUploaded = false; //attachment was not submitted or an upload error occurred
            $errorsOccurred = true;
            switch($value) {    //check which error code was returned
                case 1:
                    echo '<p style="color: rgb(178,34,34)">** Error: Attachment file is larger than allowed by the server.</p>';
                    break;
                case 2:
                    echo '<p style="color: rgb(178,34,34)">** Error: Attachment file is larger than the maximum allowed - 100kb.</p>';
                    break;
                case 3:
                    echo '<p style="color: rgb(178,34,34)">** Error: Attachment file was only partially uploaded.</p>';
                    break;
                //case 4: echo 'No attachment file was uploaded. '; break;
            }
        }
 
        //if an attachment document was uploaded, move the file to desired folder
        if($isDocUploaded && $_FILES['txtUploadFile']['name'][$key] != '') {
        
            $uploadedFile = '../images/'.$_FILES['txtUploadFile']['name'][$key];
            if(@is_uploaded_file($_FILES['txtUploadFile']['tmp_name'][$key])) //initial temp location of uploaded file
            {
                if(@!move_uploaded_file($_FILES['txtUploadFile']['tmp_name'][$key], $uploadedFile)) { //move the file to images folder
                    echo '<p style="color: rgb(178,34,34)"><br />**Error**: Could not move '.$_FILES['txtUploadFile']['name'][$key].' to the destination folder on the server.<br /></p>';
                    $errorsOccurred = true;
                } else {    //file was uploaded successfully
                    echo '<p style="color: rgb(0,128,0)"> File: '.$_FILES['txtUploadFile']['name'][$key].' was uploaded successfully</p>';
                }
            } else {
                echo '<p style="color: rgb(178,34,34)">Error: '.$_FILES['txtUploadFile']['name'][$key].' was not uploaded correctly to temp area.</p>';
                $errorsOccurred = true;
            }
        }
        $isDocUploaded = true;  //reset to true for the next document
    }
}   //end of Main foreach
 
$message = "\r\nMVC Uploader - New files were uploaded - with UNKNOWN errors";
if($errorsOccurred) {
    echo '<p><input type="button" value="Go back" onclick="window.history.back();" />'.
        '<a href="displayImages.php">Display Uploaded Files</a></p>';
    $message = "\r\nMVC Uploader - New files were uploaded - with errors";
} else {    //at this point, the file was uploaded successfully
    echo '<script type="text/javascript">window.location.href="displayImages.php"</script>';
    $message = "\r\nMVC Uploader - New files were uploaded - without errors";
}
 
echo '</div>';
 
?>