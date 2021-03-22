<?php

class Dimension
{
    protected $id;

    protected $dimension;

    public function getId(){
      return $this->id;
    }

    public function getDimension(){
      return $this->dimension;
    }

    public function setDimension($dimension){
      $this->dimension = $dimension;
    }
}

?>