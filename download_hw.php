<?php 

    //$id=(int)$_GET['id'];
    $name=$_GET['file'];

    if(!empty($name))
    {
        $filename = basename($name);
        $filepath = '/upload_homeworks/'.$filename;
        if(!empty($filename)){

    //Define Headers
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");

            readfile($filepath);
            exit;
        }
        else{
            echo "This File Does not exist.";
        }
        
    }
    header('Location: homeworks.php');