<?php
if (session_id() == ""){
  session_start();
}

function split_session(){
    if(!isset($_SESSION['uid'])) {
        header("Location: login.php");
        exit;
    }

    $session_data=$_SESSION['uid'];

    return explode('|', $session_data, 2);
}

function set_token($email){
    $_SESSION['uid']="email".'|'.$email;

    return 1;
}

function dir_in_tree($path){
    global $repo_root;

    $fqf = $repo_root. $path;
    if(file_exists($fqf) || is_dir($fqf)){
        return false;
    }

    return true;
}

function filetypeimg($file){
    $name_ext=explode('.', $file);
    $ext=end($name_ext);
    $ret="";

    switch($ext){

        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'svg':
            $ret='assets/img/img.png';
            break;

        case 'ppt':
        case 'pptx':
            $ret='assets/img/ppt.png';
            break;

        case 'doc':
        case 'docx':
            $ret='assets/img/doc.jpg';
            break;

        case 'xls':
        case 'xlsx':
            $ret='assets/img/xls.jpg';
            break;

        case 'pdf':
            $ret='assets/img/pdf.jpg';
            break;

        default:
            $ret='assets/img/fv.png';
    }
    return $ret;
}
?>
