<?php

class Questions
{
    protected $id;

    protected $question;

    public function getId(){
      return $this->id;
    }

    public function getQuestion(){
      return $this->question;
    }

    public function setQuestion($question){
      $this->question = $question;
    }
}

?>