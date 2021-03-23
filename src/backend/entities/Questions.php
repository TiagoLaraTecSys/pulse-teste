<?php

/**
 * @Entity
 */
class Questions
{
    /** @Id @Column(type="integer") @GeneratedValue */
    protected $id;

    /** @Column(type="string") */
    protected $question;

    /** 
     * @ManyToOne(targetEntity="Dimension")
     * @JoinColumn(name="dimension_id", referencedColumnName="id")
     */
    protected $dimension;

    public function getId(){
      return $this->id;
    }

    public function getQuestion(){
      return $this->question;
    }

    public function setQuestion($question){
      $this->question = $question;
    }

    public function getDimension(){
      return $this->dimension;
    }

    public function setDimension($dimension){
      $this->dimension = $dimension;
    }

}

?>