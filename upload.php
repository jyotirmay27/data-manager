<?php
require(__DIR__.'/import.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	    if(!empty(array_filter($_FILES['filetoupload']['name']))) { 
  
        foreach ($_FILES['filetoupload']['tmp_name'] as $key => $value) { 
			
	$target_dir = $_POST["folder"].'/';
	$target_file = $target_dir . basename($_FILES["filetoupload"]["name"][$key]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$tag_array= json_decode($_POST["tags"], true);
	$tag_arrays = array();
	foreach($tag_array as $arr){
		if(!isset($arr['value'])){
			continue;
		}
		array_push($tag_arrays, $arr['value']);
	}
	$v="";
	if(!empty($_POST["name1"])){
	$v=$_POST["name1"]. '.' .$imageFileType;}
	else{
	$v=$_FILES["filetoupload"]["name"][$key];}

	$name = $target_dir . $v ;

	$extensions = array("jpg", "jpeg", "png" , "gif", "webp", "webm", "svg", "weba", "mp4", "mp3" , "mp2", "mpg", "opus", "mkv", "xls", "xlsx", "doc", "docx", "rtf", "odt", "pdf", "ppt", "pptx");

	// Check if file already exists
	if (file_exists($target_file)) {
	  echo "Sorry, file already exists.";
	  $uploadOk = 0;
	}

	// Check file size
	if ($_FILES["filetoupload"]["size"][$key] > 50000000000) {
	  echo "Sorry, your file is too large.";
	  $uploadOk = 0;
	}

	// Allow certain file formats
	if( !in_array($imageFileType , $extensions)  ) {
	  echo "Sorry, this file is allowed.";
	  $uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	  echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else
	 {
		 
		 /*$i=0;
		 while(file_exists($name)){
		 $i++;
		 $}*/


	  if (move_uploaded_file($_FILES["filetoupload"]["tmp_name"][$key], $name)) {
		// add tags
		$tagg = add_tag($db, $name ,$tag_arrays);

		echo "The file ". htmlspecialchars( basename( $_FILES["filetoupload"]["name"][$key])). " has been uploaded." . $tagg;
        header("location: home.php");
	  } else
	  {
		echo "Sorry, there was an error uploading your file.";
	  }
	}
}
		}
}
?>
<!DOCTYPE html>
<html>

<head>

    <title>
        Select and upload multiple
        files to the server
    </title>
	<link rel="stylesheet" href="assets/css/tagify.css"></link>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css"></link>
	<link rel="stylesheet" href="assets/css/signin.css"></link>

<style>
body {
  background-image: url('assets/img/it.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}

</style>
 </head>

<body>
	<script src="assets/js/tagify.min.js"></script>

    <!-- multipart/form-data ensures that form
    data is going to be encoded as MIME data -->
    <form action="" class="form-signin" method="post"
            enctype="multipart/form-data">

        <h2 class="h3 mb-3 font-weight-normal text-center" style="font-size:40px; color:white;"> Upload Files</h2>



            <!-- name of the input fields are going to
                be used in our php script-->
			<input type="file" name="filetoupload[]" class="form-control-file btn btn-lg btn-block" id="filetoupload" multiple>
            </br>
			<input type="text" class="form-control" name="name1" id="name1" placeholder="File name after upload (without extension)">
            </br>
      <input name='tags' class="form-control" value='point,soft'>
      </br>
      <select name="folder" class="form-control" id="select-folder">
      <?php
           $email = split_session()[1];
           $sql = "SELECT folders FROM {$table_userdata} WHERE EMAILID = '{$email}'";
           $result=$db->query($sql);
           $dirs = explode(";", $result->fetch_row()[0]);
		   $dirs = array_diff($dirs, array(''));

           foreach($dirs as $value)
           {
      $x=explode("/", $value);
      $foldername=end($x);
			$folder=rtrim($value, $foldername);
	  $folder=trim($folder, '/');
      $folder=urlencode(trim($folder, $repo_root)).'/'.$foldername;
             echo "<option value='{$value}'>{$folder}</option>";
           }
      ?>
	  </select>
            </br></br>
            <button type="submit" class="btn btn-lg btn-primary btn-block"> Upload</button>


    </form>
    <script>
    var input = document.querySelector('input[name=tags]'),
    tagify = new Tagify(input, {
        pattern             : /^.{0,20}$/,  // Validate typed tag(s) by Regex. Here maximum chars length is defined as "20"
        delimiters          : ",| ",        // add new tags when a comma or a space character is entered
        keepInvalidTags     : true,         // do not remove invalid tags (but keep them marked as invalid)

        editTags            : {
            clicks: 1,              // single click to edit a tag
            keepInvalid: false      // if after editing, tag is invalid, auto-revert
        },
        maxTags             : 6,
        blacklist           : [],
        whitelist           : [],
        transformTag        : transformTag,
        backspace           : "edit",
        placeholder         : "Type something",
        dropdown : {
            enabled: 1,            // show suggestion after 1 typed character
            fuzzySearch: false,    // match only suggestions that starts with the typed characters
            position: 'text',      // position suggestions list next to typed text
            caseSensitive: true,   // allow adding duplicate items if their case is different
        },
        templates: {
            dropdownItemNoMatch: function(data) {
                return `
                    No suggestion found for: ${data.value}
                `
            }
        }
    })

// generate a random color (in HSL format, which I like to use)
function getRandomColor(){
    function rand(min, max) {
        return min + Math.random() * (max - min);
    }

    var h = rand(1, 360)|0,
        s = rand(40, 70)|0,
        l = rand(65, 72)|0;

    return 'hsl(' + h + ',' + s + '%,' + l + '%)';
}

function transformTag( tagData ){
    tagData.style = "--tag-bg:" + getRandomColor();
}

tagify.on('add', function(e){
    console.log(e.detail)
})

tagify.on('invalid', function(e){
    console.log(e, e.detail);
})


    </script>
</body>

</html>
