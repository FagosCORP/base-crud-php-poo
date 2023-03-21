<?php
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Conexao/Conexao.php');


use Conexao\Conexao as Conexao;

class UsuarioModel extends Conexao
{

    private static $tabela = "users";

    public function __construct()
    {
        parent::__construct();
    }

    protected function select(array $data)
    {
        $tabela = self::$tabela;
        $from = "from";
        $data['query'] = '';
        $data['query'] .= "select {$data['columns']} ";


        if (!empty($data["joins"]) && !empty($data["conditions"])) {

            $data['query'] .= " " . "{$from} {} ";
            foreach ($data["joins"] as $key => $value) {
                $data['query'] .= $value;
            }

            $data['query'] .= " " . $data["conditions"];

            $retorno = parent::queryExecute($data);
            return $retorno->fetchAll(PDO::FETCH_CLASS, self::class);
        }

        if (empty($data["joins"]) && empty($data["conditions"])) {

            $data['query'] .= " " . "{$from} {$tabela}";
            $retorno = parent::queryExecute($data);
            return $retorno->fetchAll(PDO::FETCH_CLASS, self::class);
        }

        if (!empty($data["joins"])) {
            foreach ($data["joins"] as $key => $value) {
                $data['query'] .= $value;
            }

            $data['query'] .= " " . "{$from} {$tabela}";
        }

        if (!empty($data["conditions"])) {

            $data['query'] .= " " . "{$from} {$tabela}";

            $data['query'] .= " " . $data["conditions"];
        }

        $retorno = parent::queryExecute($data);
        return $retorno->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function insert($data)
    {
        try {
            $tabela = self::$tabela;
            $into = "into";
            $data['columns'] = str_replace(":", "", implode(",", array_keys($data['parametros'])));
            $data['bindValues'] = implode(",", array_pad([], count($data['parametros']), "?"));
            $data['query'] = '';
            $data['query'] .= "insert {$into} {$tabela} ({$data['columns']}) VALUES({$data['bindValues']}) ";

            parent::queryExecute($data);

            $ultimoIdInserido = PDO::lastInsertId('id');

            return  $usuarioInserio = self::select([
                'columns' => 'first_name,last_name,email,status',
                'conditions' => 'where id = :id',
                'parametros' => [':id' => $ultimoIdInserido]
            ]);
        } catch (\PDOException $e) {
            echo '<pre>';
            print_r($e);
            die;
        }
    }

    public function update($data)
    {
        try {
            $tabela = self::$tabela;
            $set = "set";
            $data['query'] = '';
            $data['setValues'] = '';

            foreach ($data['parametros'] as $chave => $valores) {
                $cleanColumns = str_replace(":", "", $chave);
                $data['setValues'] .= "{$cleanColumns} = {$chave}, ";
            }

            $data['setValues'] = substr($data['setValues'], 0, strripos($data['setValues'], ","));

            $data['query'] .= "update {$tabela} {$set} {$data['setValues']} {$data['conditions']} ";

            parent::queryExecute($data);
        } catch (\PDOException $e) {
            echo '<pre>';
            print_r($e);
            die;
        }
    }


    public function delete($data)
    {
        try {
            $tabela = self::$tabela;
            $from = "from";
            $data['query'] = '';

            $data['query'] .= "delete {$from}  {$tabela} {$data['conditions']} ";

            parent::queryExecute($data);
        } catch (\PDOException $e) {
            echo '<pre>';
            print_r($e);
            die;
        }
    }
}
