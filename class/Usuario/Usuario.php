<?php

namespace Usuario;

require_once('UsuarioModel.php');


class Usuario extends \UsuarioModel
{
    private $idUsuario;
    private $senha;
    private $desLogin;
    private $dataCadastro;

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
    public function getSenha()
    {
        return $this->senha;
    }
    public function setDesLogin($desLogin)
    {
        $this->desLogin = $desLogin;
    }
    public function getDesLogin()
    {
        return $this->desLogin;
    }
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;
    }

    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    public  function buscarPorId(array $data)
    {
        // query, parametros
        return parent::select([
            'columns' => 'categories.id,categories.title',
            'conditions' => 'where categories.id = :id',
            'parametros' => [':id' => $data['id']]
        ]);
    }

    public  function buscarTodos()
    {
        // query, parametros
        return parent::select([
            'columns' => '*',
        ]);
    }
}
