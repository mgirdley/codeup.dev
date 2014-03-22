<?php

class AddressDataStore {

    public $filename = '';

    function __construct($name = 'addressbook.csv')
    {
        $this->filename = $name;
    }

    function __destruct() 
    {
        echo "Class dismissssssssed!";
    }

    function read_address_book()
    {
      $temp_address_book = [];
      $row = 1;
      if (($handle = fopen($this->filename, "r")) !== FALSE) {
         while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
             $num = count($data);
             $temp_entry = [$data[0],$data[1],$data[2],$data[3],$data[4]];
             array_push($temp_address_book,$temp_entry);
         }
        fclose($handle);
      }
      //echo "temp addy boook:";
      // var_dump($temp_address_book);
      return $temp_address_book;
    }
    
    function write_address_book($items) 
    {
      $handle = fopen($this->filename, 'w');
      // var_dump($items);
      foreach ($items as $fields) {
        fputcsv($handle, $fields);
        // var_dump($fields);
      }
    fclose($handle);
        // Code to write $addresses_array to file $this->filename
    }

}

function add_entry($address_book) {
  // var_dump($_POST);
  if (($_POST['name']!='') &&
       ($_POST['address']!='') &&
       ($_POST['city']!='') &&
       ($_POST['state']!='') &&
       ($_POST['zip'])!='') {
        $newentry[0] = $_POST['name'];
        $newentry[1] = $_POST['address'];
        $newentry[2] = $_POST['city'];
        $newentry[3] = $_POST['state'];
        $newentry[4] = $_POST['zip'];
        array_push($address_book, $newentry);

  } else echo "Error: You're missing a field.  Try again!\n"; 
  // echo "This is the addy book after adding an entry:\n";
  // var_dump($address_book);
  return $address_book;
 }

$address_store = new AddressDataStore();

//$address_store->filename = 'addressbook.csv';

$address_book = $address_store->read_address_book($file);

// var_dump($address_book);

if($_GET)
{
  $key = $_GET['key'];
  unset($address_book[$key]);
  unset($_GET);
  $address_store->write_address_book($address_book);
}

if($_POST)
{
  $address_book = add_entry($address_book);
  $address_store->write_address_book($address_book);
}


?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>MICHAEL'S AMAZING ADDRESS BOOK</title>
  </head>

  <body>
    <h1>MICHAEL'S AMAZING ADDRESS BOOK</h1>
    <ul>
      <? foreach($address_book as $key => $entry) : ?>
        <li>
          <? foreach ($entry as $key2 => $value) : ?>
            <? echo htmlspecialchars(strip_tags($value)); if ($key2!=4) { echo ", ";} ?> 
          <? endforeach; ?>
          | <a href=?key=<? echo $key; ?>>Delete Entry</a></li>
       <? endforeach; ?>
    </ul>

    <form method="POST" action="address_book.php">
      <input type="text" id="name" name="name" placeholder="Enter name">
      <input type="text" id="address" name="address" placeholder="Enter street address">
      <input type="text" id="city" name="city" placeholder="Enter city">
      <input type="text" id="state" name="state" placeholder="Enter state">
      <input type="text" id="zip" name="zip" placeholder="Enter zip">
      <button>Add</button>
    </form>

    <br>

    <form method="POST" enctype="multipart/form-data" action="file-upload.php">
    <p>
        <label for="file">File to upload: </label>
        <input type="file" id="file1" name="file1">
    </p>
    <p>
        <input type="submit" value="Upload">
    </p>
    </form>

    <? unset($address_store); ?>

   </body>
</html>

