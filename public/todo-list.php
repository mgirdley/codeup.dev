<?

require("filestore.php");

$filestore = new Filestore('todolist.txt');

$items = $filestore->read_lines();

// var_dump($items);
// var_dump($_POST);

if($_GET)
{
  $key = $_GET['key'];
  unset($items[$key]);
  unset($_GET);
  $filestore->write_lines($items);
}

if($_POST)
{
  $todoitem = $_POST['todoitem'];

  try {
    if (strlen($todoitem)>240) {
      throw new Exception("Error Processing Request. Your todo items is too long. Must be less than or equal to 240 chars.", 1);   
    } elseif (strlen($todoitem)==0) {
      throw new Exception("Error Processing Request. Your todo items is too short. Must be 1 character or longer.", 1);   
    } else {
      array_push($items, $todoitem);
      // var_dump($items);
      // var_dump($todoitem);
      $filestore->write_lines($items);
    }
  } catch (Exception $e) {
      echo "Please try again! Error message: " . $e . "\n";
    }
}

?>

<?php 

// Verify there were uploaded files and no errors

if (count($_FILES) > 0 && $_FILES['file1']['error'] ==0) {
    // var_dump($_FILES);
    if ($_FILES['file1']['type']!='text/plain') {
        echo "<p>Sorry.  There was an error with your file upload. Is it the right file type? (text/plain) \n";
    } else {
      // Set the destination directory for uploads
      $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
      // Grab the filename from the uploaded file by using basename
      $filename = basename($_FILES['file1']['name']);
      // Create the saved filename using the file's original name and our upload directory
      $saved_filename = $upload_dir . $filename;
      // Move the file from the temp location to our uploads directory
      move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);      
    }
}

?>

<? // Check if we saved a file
 if (isset($saved_filename)) : ?>
    <? // If we did, show a link to the uploaded file ?>
    <p>You can download your file <a href='/uploads/<?echo $filename; ?>'>here</a>.</p>
<? endif; ?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>TODO List</title>
  </head>

  <body>
    <h1>TODO List</h1>
    <ul>
      <? foreach($items as $key => $value) : ?>
          <li><? echo htmlspecialchars(strip_tags($value)); ?> | <a href=?key=<? echo $key; ?>>Mark Complete</a></li>
      <? endforeach; ?>
    </ul>

    <form method="POST" action="todo-list.php">
      <input type="text" id="todoitem" name="todoitem" placeholder="Add your TODO">
      <button>Add</button>
    </form>

    <h1>Upload File</h1>

    <form method="POST" enctype="multipart/form-data">
        <p>
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1">
        </p>
        <p>
            <input type="submit" value="Upload">
        </p>
    </form>

  </body>
</html>