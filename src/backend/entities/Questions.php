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
     * @ManyToOne(targetEntity="Dimension",cascade={"persist"})
     * @JoinColumn(name="dimension_id", referencedColumnName="id")
     */
    protected Dimension $dimension;

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

    public function setDimension(Dimension $dimension){
      $this->dimension = $dimension;
    }

}

?>