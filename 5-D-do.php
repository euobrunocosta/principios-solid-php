<?php

interface BdConexaoInterface
{
  public function connect();
}

class MySQLConexao implements BdConexaoInterface
{
  public function connect()
  {
    // código aqui ...
  }
}

class CarregarPagina
{

  private $bdConexao;

  public function __construct(BdConexaoInterface $bdConexao)
  {
    $this->bdConexao = $bdConexao;
  }

}