<?php

namespace Conexao;

require_once('ConexaoModel.php');
require_once(dirname(__DIR__) . '/Helpers/HelpersConexao.php');

class Conexao extends \ConexaoModel
{

    protected function __construct()
    {
        parent::__construct(CONF_CONEXAO_BANCO);
    }

    protected function setParams(array $data)
    {
        foreach ($data['parametros'] as $key => $value) {
            $data['instancia']->bindParam($key, $value);
        }
    }

    protected function queryExecute(array $data)
    {
        try {
            $instancia = \PDO::prepare($data['query']);

            $data['parametros'] = (!empty($data['parametros'])) ? $data['parametros'] : '';

            if (!empty($data['parametros'] && strstr($data['query'], 'select'))) {
                $this->setParams(['instancia' => $instancia, 'parametros' => $data['parametros']]);
            }



            if (!strstr($data['query'], 'select')) {
                // entao e insert

                $data['parametros'] =  empty($data['parametros']) ? array() : $data['parametros'];

                if (empty($data['delete']) && empty($data['update'])) {

                    $data['parametros'] = array_values($data['parametros']);
                }

                if (!empty($data['update'])) {
                    $data['parametros'] = array_merge($data['parametros'], $data['update']);
                }

                if (!empty($data['delete'])) {

                    $data['parametros'] = array_merge($data['parametros'], $data['delete']);
                }


                return  $instancia->execute($data['parametros']);
            }

            $instancia->execute();
            return $instancia;
        } catch (\PDOException $th) {
            echo '<pre>';
            print_r($th);
            die;
        }
    }




    // select pela instancia pai

}
