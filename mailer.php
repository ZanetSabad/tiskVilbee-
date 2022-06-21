<?php

    // Načítá pole z formuláře - name, email a message; odstraňuje bílé znaky; odstraňuje HTML
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);
    $typ = filter_var(trim($_POST["typ"]));
    $typ1 = filter_var(trim($_POST["typ1"]));
    $telNumber = filter_var(trim($_POST["telNumber"]));
    
 

    // Kontroluje data popř. přesměruje na chybovou adresu
    if (empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: http://www.sabadtest.fun/chyba.html?success=-1#form");
        exit;
    }

    // Nastavte si email, na který chcete, aby se vyplněný formulář odeslal - jakýkoliv váš email
    $recipient = "zaneta.sabadkova@gmail.com";

    // Nastavte předmět odeslaného emailu
    $subject = "Máte nový kontakt od: $name";

    // Obsah emailu, který se vám odešle
    $email_content = "Jméno: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Telefon: $telNumber\n\n";
    $email_content .= "Typ: $typ\n\n";
    $email_content .= "Doprava: $typ1\n\n";
    $email_content .= "Zpráva:\n$message\n"; 
    

    // Emailová hlavička
    $email_headers = "From: $name <$email>";

    // Odeslání emailu - dáme vše dohromady
    mail($recipient, $subject, $email_content, $email_headers, $attach_filepath);

      // Přesměrování na stránku, pokud vše proběhlo v pořádku
      header("Location:http://www.sabadtest.fun/dekuji.html?success=1#form");{
          
      }

      function xmail($attach_filepath)
{
  $b = 0;
  $mail_attached = "";
  $boundary = md5(uniqid(time(),1))."_xmail";
  if (count($attach_filepath)>0)
  {
    for ($a=0;$a < count($attach_filepath);$a++) 
    {
      if ($fp = fopen($attach_filepath[$a],"rb"))
      {
        $file_name = basename($attach_filepath[$a]);
        $content[$b] = fread($fp,filesize($attach_filepath[$a]));
        $mail_attached .= "--".$boundary."\r\n".
          "Content-Type: image/jpeg; name=\"$file_name\"\r\n".
          "Content-Transfer-Encoding: base64\r\n".
          "Content-Disposition: inline; filename=\"$file_name\"\r\n\r\n".
          chunk_split(base64_encode($content[$b]))."\r\n";
        $b++;
        fclose($fp);
      }
//      else  echo "NE";
    }
    $mail_attached .= "--".$boundary." \r\n";
    $add_header ="MIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"$boundary\"";
    $mail_content = "--".$boundary."\r\n".
      "Content-Type: text/plain; charset=iso-8859-1; format=flowed\r\n".
      "Content-Transfer-Encoding: ."\r\n\r\n".$mail_attached;
    return mail($mail_content,.$add_header);
  }
}

//     $target_dir = "php/uploads/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $uploadOk = 1;
// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// // Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
//   $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//   if($check !== false) {
//     echo "File is an image - " . $check["mime"] . ".";
//     $uploadOk = 1;
//   } else {
//     echo "File is not an image.";
//     $uploadOk = 0;
//   }
// }

// // Check if file already exists
// if (file_exists($target_file)) {
//   echo "Sorry, file already exists.";
//   $uploadOk = 0;
// }

// // Check file size
// if ($_FILES["fileToUpload"]["size"] > 500000) {
//   echo "Sorry, your file is too large.";
//   $uploadOk = 0;
// }

// // Allow certain file formats
// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
// && $imageFileType != "gif" ) {
//   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//   $uploadOk = 0;
// }

// // Check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) {
//   echo "Sorry, your file was not uploaded.";
// // if everything is ok, try to upload file
// } else {
//   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//     echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
//   } else {
//     echo "Sorry, there was an error uploading your file.";
//   }
// }
    
  



?>