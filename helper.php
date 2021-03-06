<?php
if (session_id() == ""){
  session_start();
}

//userdata table => (ID, NAME, folders, EMAILID, PASSWORD)
//paths table    => (id, name, tags)

function is_valid_foldername($folder){
    if(strpos($folder, DIRECTORY_SEPARATOR) !== false || empty($folder)){
        return false;
    }

    return true;
}

function create_folder($db, $email, $folder){
    global $repo_root, $table_userdata;

    $ret=1;
    $folder_root=$repo_root.date('Y-F', time());

    if(!is_dir($folder_root)){
        mkdir($folder_root, 0660);
    }

    $fqf=$folder_root . '/'. $folder;

    if(is_dir($fqf)){
        return 2;
    }

    mkdir($fqf, 660);

    $com="UPDATE {$table_userdata} SET folders = concat(folders, '{$fqf}', ';') WHERE EMAILID = '{$email}'";
    if ($db->query($com) === true) {
      $ret=0;
    }
    else {
		var_dump($db->error);
      $ret=15;
    }

    return $ret;
}

function check_ownership($db, $email, $folder){
    global $table_userdata;

    $is_owner=false;

    $com="SELECT folders from {$table_userdata} WHERE EMAILID = '{$email}'";
    $result = $db->query($com);

    if(!$result){
        return 15;
    }

    if(strpos($result->fetch_row()[0], ';'.$folder.';') !== false){
        $is_owner=true;
    }
    $result->close();

    return $is_owner;
}

function add_tag($db, $path, $tag_array){
    global $table_paths;

    $com="INSERT INTO {$table_paths} (name, tags) VALUES ('{$path}', ';')";
    $result=$db->query($com);
    if(!$result){
        return 15;
    }

    $str='';
    foreach($tag_array as $e){
        $str=$e.';'.$str;
    }

    $com="UPDATE {$table_paths} SET tags = concat(tags,'{$str}') WHERE name = '{$path}'";
    $result=$db->query($com);
    if(!$result){
        return 15;
    }

    return 0;
}

function parse_result($res){
    $ret=array();
    for($i=0;$i<$res->num_rows;$i++){
        array_push($ret, $res->fetch_row()[0]);
    }

    return $ret;
}

function search_by_tags($db, $tag_array){
    global $table_paths;

    $ret=array();
    foreach($tag_array as $tag){
        $com="SELECT name FROM {$table_paths} WHERE tags LIKE '%;{$tag}%'";
        $result=$db->query($com);
        if(!$result){
            continue;
        }
        $arr=parse_result($result);
        $ret=array_merge($ret, $arr);
    }

    return $ret;
}

function search_by_filename($db, $needle){
    global $table_paths;

    $com="SELECT name FROM {$table_paths} WHERE name LIKE '%{$needle}%'";
    $result=$db->query($com);
    if(!$result){
        return 15;
    }

    $ret=parse_result($result);
    $result->close();

    return $ret;
}
?>
