<?php

require_once("../controller/respostaFuncao.php");

class ConexaoController {

    // endereço do servidor MySQL
    private $servidor;

    // usuário do banco de dados
    private $usuario;

    // senha do banco de dados
    private $senha;

    // nome do banco utilizado pelo sistema
    private $bancoDeDados;

    // objeto PDO responsável pela conexão
    private $conexao;

    // objeto padrão de resposta
    private $resposta;

    public function __construct(){

        // define os dados de conexão
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->senha = "";
        $this->bancoDeDados = "db_alpha";

        // instancia o gerador de respostas padronizadas
        $this->resposta = new RespostaFuncao();
    }

    /**
     * cria conexão com o banco de dados
     * 
     * retorna: ["status" => bool, "message" => string, "dados" => array]
     */
    private function conectarBd(){

        try {
            // cria conexão PDO com charset UTF8
            $this->conexao = new PDO("mysql:host=$this->servidor;dbname=$this->bancoDeDados;charset=utf8", $this->usuario, $this->senha);

            // ativa tratamento de erros do PDO
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->resposta->respostaFuncao(true, "Conexão bem-sucedida", []);
        } catch (PDOException $error){
            // retorna erro de conexão
            return $this->resposta->respostaFuncao(false, "Erro de conexão com banco de dados: " . $error->getMessage(), []);
        }
    }

    /**
     * encerra conexão ativa
     */
    public function fecharConexao(){

        // remove objeto PDO da memória
        $this->conexao = null;
    }

    /**
     * busca conta bancária do usuário
     */
    public function buscarConta(int $id){

        // tenta iniciar conexão
        $conexao = $this->conectarBd();

        // verifica falha na conexão
        if (!$conexao['status']){
            $this->fecharConexao();
            return $conexao;
        }

        try {

            // comando SQL
            $comando = "SELECT * FROM tb_conta_usuario WHERE id_usuario = :id";

            // prepara query
            $sql = $this->conexao->prepare($comando);

            // substitui placeholder
            $sql->bindValue(":id", $id);

            // executa query
            $sql->execute();

            // verifica se encontrou dados
            if ($sql->rowCount() == 0){
                return $this->resposta->respostaFuncao(false, "conta não registrada", []);
            }

            // captura dados encontrados
            $dados = $sql->fetch(PDO::FETCH_ASSOC);
            return $this->resposta->respostaFuncao(true, "Conta localizada", $dados);
        } catch (PDOException $erro){
            return $this->resposta->respostaFuncao(false, $erro->getMessage(), []);
        } finally {
            // encerra conexão independentemente do resultado
            $this->fecharConexao();
        }
    }

    /**
     * busca usuário através do e-mail
     */
    public function buscarUsuario(string $email){
        $conexao = $this->conectarBd();
        if (!$conexao['status']){
            $this->fecharConexao();
            return $conexao;
        }

        try {
            $comando = "SELECT * FROM tb_usuario WHERE email_usuario = :email";// comando SQL
            $sql = $this->conexao->prepare($comando);// prepara query
            $sql->bindValue(":email", $email);// substitui parâmetro
            $sql->execute();// executa consulta
            
            if ($sql->rowCount() == 0){ // verifica se o usuário existe
                return $this->resposta->respostaFuncao(false, "E-mail não cadastrado", []);
            }

            $dados_localizados = $sql->fetch(PDO::FETCH_ASSOC); // captura dados localizados
            return $this->resposta->respostaFuncao(true, "Cadastro Localizado", $dados_localizados);
        } catch (PDOException $erro){
            return $this->resposta->respostaFuncao(false, "Erro SQL: " . $erro->getMessage(), []);
        } finally {
            $this->fecharConexao();
        }
    }

    /**
     * registra conta bancária do usuário
     */
    public function inserirConta($id, $banco, $conta){
        $conexao = $this->conectarBd();
        if (!$conexao['status']){
            $this->fecharConexao();
            return $conexao;
        }

        try {
            $comando = "INSERT INTO tb_conta_usuario ( id_usuario, nome_banco_conta, numero_conta) VALUES (:id_usuario, :nome_banco, :numero_conta)";
            $sql = $this->conexao->prepare($comando);
            $sql->bindValue(':id_usuario', (int)$id);
            $sql->bindValue(':nome_banco', $banco);
            $sql->bindValue(':numero_conta', (int)$conta);
            $sql->execute();
            return $this->resposta->respostaFuncao(true, "Dados inseridos com sucesso", []);
        } catch (PDOException $erro){
            return $this->resposta->respostaFuncao(false, "Erro Conexão: " . $erro->getMessage(), []);
        } finally {
            $this->fecharConexao();
        }
    }

    /**
     * registra cálculo/rendimento realizado pelo usuário
     */
    public function registrarPedido(int $id, float $taxa, int $tempo, float $capital, float $rendimento){

        $conexao = $this->conectarBd();

        if (!$conexao['status']){
            $this->fecharConexao();
            return $conexao;
        }

        try {

            // comando SQL
            $comando = "INSERT INTO tb_registros (id_usuario, taxa_registro, tempo_registro, capital_registro, rendimento_registro ) VALUES (:id_usuario, :taxa, :tempo, :capital_pedido, :rendimento)";

            // prepara query
            $sql = $this->conexao->prepare($comando);

            // substitui parâmetros
            $sql->bindValue(":id_usuario", $id);
            $sql->bindValue(":taxa", $taxa);
            $sql->bindValue(":tempo", $tempo);
            $sql->bindValue(":capital_pedido", $capital);
            $sql->bindValue(":rendimento", $rendimento);

            // executa insert
            $sql->execute();

            return $this->resposta->respostaFuncao(true, "Dados inseridos com sucesso", []);

        } catch (PDOException $erro){
            return $this->resposta->respostaFuncao(false, "Erro Conexão: " . $erro->getMessage(), []);
        } finally {
            $this->fecharConexao();
        }
    }

    /**
     * cadastra novo usuário
     */
    public function inserirUsuario(array $dadosUsuario){

        // inicia conexão
        $conexao = $this->conectarBd();

        if (!$conexao['status']){
            $this->fecharConexao();
            return $conexao;
        }

        try {

            // comando SQL de cadastro
            $sql = "INSERT INTO tb_usuario (nome_usuario, email_usuario, cpf_usuario, celular_usuario, data_nascimento_usuario, senha_usuario)
                VALUES (:nome, :email, :cpf, :celular, :data_nascimento, :senha)";

            // prepara query
            $consulta = $this->conexao->prepare($sql);

            // vincula dados recebidos
            $consulta->bindValue(":nome", $dadosUsuario['nomeUsuario']);
            $consulta->bindValue(":email", $dadosUsuario['emailUsuario']);
            $consulta->bindValue(":cpf", $dadosUsuario['cpfUsuario']);
            $consulta->bindValue(":celular", $dadosUsuario['celularUsuario']);
            $consulta->bindValue(":data_nascimento", $dadosUsuario['nascimentoUsuario']);
            $consulta->bindValue(":senha", $dadosUsuario['senhaUsuario']);

            // executa cadastro
            $consulta->execute();
            return $this->resposta->respostaFuncao(true, "Cadastro efetuado", []);

        } catch (PDOException $error){
            /**
             * código 23000:
             * violação de integridade
             * geralmente duplicidade UNIQUE
             */
            if ($error->getCode() == "23000") {
                $msg_erro = $error->getMessage();

                // verifica duplicidade de e-mail
                if (str_contains($msg_erro, 'email')){
                    return $this->resposta->respostaFuncao(false, "Este e-mail já está em uso.", []);
                }

                // verifica duplicidade de CPF
                if (str_contains($msg_erro, 'cpf')){
                    return $this->resposta->respostaFuncao(false, "Este CPF já está cadastrado.", []);
                }
            }
            return $this->resposta->respostaFuncao(false, "Erro conexão: " . $error->getMessage(), []);

        } finally {

            $this->fecharConexao();
        }
    }

    /**
     * retorna histórico de registros do usuário
     */
    public function buscarRegistros(int $id){

        $conexao = $this->conectarBd();

        if (!$conexao['status']){
            $this->fecharConexao();
            return $conexao;
        }

        try {

            // comando SQL
            $comando = " SELECT taxa_registro, tempo_registro, capital_registro, rendimento_registro FROM tb_registros WHERE id_usuario = :id ORDER BY id_registro DESC ";

            // prepara query
            $sql = $this->conexao->prepare($comando);

            // substitui parâmetro
            $sql->bindValue(":id", $id);

            // executa consulta
            $sql->execute();

            // captura múltiplos registros
            $dados = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $this->resposta->respostaFuncao(true, "Registros localizados com sucesso !!!", $dados);

        } catch(PDOException $erro){
            return $this->resposta->respostaFuncao(false, $erro->getMessage(), []);
        } finally {
            $this->fecharConexao();
        }
    }

    /**
     * altera nome do usuário
     */
    public function editarNome(int $id, string $novo_nome){

        $conexao = $this->conectarBd();

        if (!$conexao['status']){
            $this->fecharConexao();
            return $conexao;
        }

        try {

            // comando UPDATE
            $comando = "UPDATE tb_usuario SET nome_usuario = :nome WHERE id_usuario = :id ";

            // prepara query
            $sql = $this->conexao->prepare($comando);

            // substitui parâmetros
            $sql->bindValue(":nome", $novo_nome);
            $sql->bindValue(":id", $id);

            // executa atualização
            $sql->execute();

            return $this->resposta->respostaFuncao(true, "Nome modificado com sucesso",[]);
        } catch (PDOException $erro){
            return $this->resposta->respostaFuncao(false, $erro->getMessage(),[]);
        } finally {
            $this->fecharConexao();
        }
    }

    /**
     * altera e-mail do usuário
     */
    public function editarEmail(int $id, string $novo_email){
        $conexao = $this->conectarBd();
        if (!$conexao['status']){
            $this->fecharConexao();
            return $conexao;
        }

        try {

            // comando UPDATE
            $comando = "UPDATE tb_usuario SET email_usuario = :email WHERE id_usuario = :id ";
            // prepara query
            $sql = $this->conexao->prepare($comando);

            // substitui parâmetros
            $sql->bindValue(":email", $novo_email);
            $sql->bindValue(":id", $id);

            // executa atualização
            $sql->execute();
            return $this->resposta->respostaFuncao(true, "Nome modificado com sucesso", []);
        } catch (PDOException $erro){
            return $this->resposta->respostaFuncao(false, $erro->getMessage(), []);
        } finally {
            $this->fecharConexao();
        }
    }
}