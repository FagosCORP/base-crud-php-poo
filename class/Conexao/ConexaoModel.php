<?php
require_once(dirname(__DIR__) . '/Helpers/HelpersConexao.php');

class ConexaoModel extends \PDO
{
    protected function __construct(array $data)
    {
        foreach (CONF_CONEXAO_BANCO as $atributos => $valor) {
            if ($valor !== "string") {
                $argsConexao = "Não foi possível realizar a conexão, confira os parâmetros digitados.";
            }
        }

        $config = CONF_CONEXAO_BANCO;
        $argsConexao =
            [
                'stringConexao' => "{$config['driver']}:host={$config['servidor']};dbname={$config['banco']}",
                'usuario' => "{$config['usuario']}",
                'senha' => "{$config['senha']}"
            ];

        try {

            parent::__construct($argsConexao['stringConexao'], $argsConexao['usuario'], $argsConexao['senha']);
        } catch (PDOException $e) {

            return $argsConexao = $e;
            exit();
        }
    }
}
