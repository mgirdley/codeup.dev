<?

$file = 'todolist.txt';

function read_file($filename)
{
  $handle = fopen($filename, 'r');
  $filesize = filesize($filename);

  if($filesize > 0) {
    $contents = trim(fread($handle, $filesize));
    $contents_array = explode("\n", $contents);
  } else {
    $contents_array = array();
  }

  fclose($handle);
  return $contents_array;
}

function write_to_file($filename, $items)
{
  $handle = fopen($filename, 'w');
  $items = implode("\n", $items);
  fwrite($handle, $items);
}

$items = read_file($file);

if($_GET)
{
  $key = $_GET['key'];
  unset($items[$key]);
  unset($_GET);
  write_to_file($file, $items);
}

if($_POST)
{
  $todoitem = $_POST['todoitem'];
  array_push($items, $todoitem);
  write_to_file($file, $items);
}

?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>TODO List</title>
  </head>

  <body>
    <h1>TODO List</h1>
    <ul>
      <?php 
        foreach($items as $key => $value)
        {
          echo "<li>{$value} | <a href=\"?key={$key}\">Mark Complete</a></li>";
        }
      ?>
    </ul>

    <form method="POST" action="todo-list.php">
      <input type="text" id="todoitem" name="todoitem" placeholder="Add your TODO">
      <button>Add</button>
    </form>
  </body>
</html>