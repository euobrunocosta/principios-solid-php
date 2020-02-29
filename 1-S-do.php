<?php

class Post
{

  protected $titulo;

  public function getTitulo($titulo)
  {
    return $this->titulo;
  }

}

class JsonPostFormatador
{

  public function formatar(Post $post)
  {
    return json_encode($post->getTitulo());
  }
}