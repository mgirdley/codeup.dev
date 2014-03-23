<?php

require("filestore.php");

class AddressDataStore extends Filestore {

    function __construct($filename = '') 
    {
        parent::__construct(strtolower($filename));
    }


    function read_address_book()
    {
      return $this->read_csv();
    }
    
    function write_address_book($items) 
    {

      $this->write_csv($items);
    }

} 
?>