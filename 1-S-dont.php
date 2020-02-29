<?php

class Post
{

  protected $titulo;

  public function getTitulo()
  {
    return $this->titulo;
  }

  public function formataJson()
  {
    return json_encode($this->getTitulo());
  }

}