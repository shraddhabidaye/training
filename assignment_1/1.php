<?php
  abstract class Fruit                                  //parent class
    {
      public $name;
      public function __construct($name)
      {
        $this->name = $name;
      }
      abstract public function getFruit() : string;
    }
  class Fruitname extends Fruit                          //child class
    {
      public function getFruit() : string               //abstract function definition
      {
        return "this is $this->name";
      }
    }
    $apple=new Fruitname("apple");
    echo $apple->getFruit();
?>
