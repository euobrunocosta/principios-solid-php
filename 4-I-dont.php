<?php

interface Colaborador
{

  public function darUmaPausa();

  public function desenvolver();

  public function ligarParaCliente();

  public function irParaReuniao();

  public function receberPagamento();

}

class Gerente implements Colaborador
{
  public function desenvolver()
  {
    return false;
  }
}

class Desenvolvedor implements Colaborador
{
  public function ligarParaCliente()
  {
    echo "Pedirei ao meu gerente que faça ¯\_(ツ)_/¯";
  }
}