<?php

interface Colaborador
{

  public function darUmaPausa();

  public function receberPagamento();

}

interface Dev
{
  public function desenvolver(); 
}

interface AtendimentoCliente
{

  public function ligarParaCliente();

  public function irParaReuniao();

}

class Desenvolvedor implements Colaborador, Dev
{
  // código aqui ...
}

class Gerente implements Colaborador, AtendimentoCliente
{
  // código aqui ...
}