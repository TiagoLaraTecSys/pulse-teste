<?php

/**
 * @Entity
 */
class Dimension
{
    /** @Id @Column(type="integer") @GeneratedValue */
    protected $id;

    /** @Column(type="string") @Unique */
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