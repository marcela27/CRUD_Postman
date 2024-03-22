<?php
namespace App\Model;

class Cliente
{
    private int $cliente_id;
    private string $nome;
    private string $email;
    private string $cidade;
    private string $estado;

    public function __construct() 
    {
        
    }


    public function getCliente_Id(): int
    {
        return $this->cliente_id;
    }

    public function setCliente_Id(int $cliente_id)
    {
        $this->cliente_id = $cliente_id;
    }


    public function getNome(): String
    {
        return $this->nome;
    }

    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }


    public function getCidade(): string
    {
        return $this->cidade;
    }

    public function setCidade(string $cidade)
    {
        $this->cidade = $cidade;
    }


    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado)
    {
        $this->estado = $estado;
    }
}