<?php

class Filestore {

    public $filename = '';

    function __construct($filename = '') 
    {
        $this->filename=$filename;
    }

    /**
     * Returns array of lines in $this->filename
     */
    function read_lines()
    {
      $handle = fopen($this->filename, 'r');
      $filesize = filesize($this->filename);

      if($filesize > 0) {
        $contents = trim(fread($handle, $filesize));
        $contents_array = explode("\n", $contents);
      } else {
        // echo "Made it to filesize!\n";
        $contents_array = array();
      }

      fclose($handle);
      return $contents_array;
    }

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    function write_lines($array)
    {
        $handle = fopen($this->filename, 'w');
        $array2 = implode("\n", $array);
        fwrite($handle, $array2); 
        // echo "I wrote...\n";
        // var_dump($array2);      
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    function read_csv()
    {
      $temp_array = [];
      $row = 1;
      if (($handle = fopen($this->filename, "r")) !== FALSE) {
         while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
             // $num = count($data);
             $temp_entry = $data;
             array_push($temp_array,$temp_entry);
         }
        fclose($handle);
      }
      //echo "temp addy boook:";
      // var_dump($temp_address_book);
      return $temp_array;
    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    function write_csv($array)
    {
        $handle = fopen($this->filename, 'w');
        // var_dump($items);
        foreach ($array as $fields) {
            fputcsv($handle, $fields);
            // var_dump($fields);
        }
        fclose($handle);
        // Code to write $addresses_array to file $this->filename        
    }

}