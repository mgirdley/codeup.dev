<?php

class AddressDataStore {

    public $filename = '';

    function __construct($name = 'addressbook.csv')
    {
        $this->filename = $name;
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
?>