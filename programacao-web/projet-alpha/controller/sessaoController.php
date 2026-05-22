<?php

require_once("../controller/respostaFuncao.php");

/**
 * Classe responsável pelo gerenciamento da sessão do usuário.
 */
class SessaoController {

    /**
     * Classe de resposta padronizada.
     */
    private RespostaFuncao $resposta;

    /**
     * Inicializa a sessão e o objeto de resposta.
     */
    public function __construct()
    {
        session_start();
        $this->resposta = new RespostaFuncao();
    }

    /**
     * Retorna resposta de erro.
     */
    private function erro(string $msg): array
    {
        return $this->resposta->respostaFuncao(false, $msg, []);
    }

    /**
     * Retorna resposta de sucesso.
     */
    private function sucesso(string $msg): array
    {
        return $this->resposta->respostaFuncao(true, $msg, []);
    }

    /**
     * Retorna um dado da sessão do usuário.
     */
    private function obter(string $chave): mixed
    {
        return $_SESSION['usuario'][$chave] ?? null;
    }

    /**
     * Salva um dado na sessão do usuário.
     */
    private function salvar(string $chave, mixed $valor): void
    {
        $_SESSION['usuario'][$chave] = $valor;
    }

    /**
     * Verifica se existe um dado salvo na sessão.
     */
    private function existe(string $chave): bool
    {
        return isset($_SESSION['usuario'][$chave]);
    }

    /**
     * Retorna o ID do usuário.
     */
    public function obterId(): mixed
    {
        return $this->obter("id");
    }

    /**
     * Retorna o nome do usuário.
     */
    public function obterNome(): mixed
    {
        return $this->obter("nome");
    }

    /**
     * Retorna o e-mail do usuário.
     */
    public function obterEmail(): mixed
    {
        return $this->obter("email");
    }

    /**
     * Atualiza o nome do usuário.
     */
    public function editarNome(string $nome): void
    {
        $this->salvar("nome", $nome);
    }

    /**
     * Atualiza o e-mail do usuário.
     */
    public function editarEmail(string $email): void
    {
        $this->salvar("email", $email);
    }

    /**
     * Salva os dados da conta bancária.
     */
    public function salvarConta(string $nomeBanco, string $numeroConta): void
    {
        $this->salvar("banco", $nomeBanco);
        $this->salvar("conta", $numeroConta);
    }

    /**
     * Verifica se o usuário possui conta cadastrada.
     */
    public function validarConta(): array
    {
        if (!$this->existe("banco") || !$this->existe("conta")) {
            return $this->erro("Conta não existe");
        }

        return $this->sucesso("Conta cadastrada");
    }

    /**
     * Cria os dados do usuário na sessão.
     */
    public function criarUsuario(array $dados): array
    {
        try {

            $_SESSION['usuario'] = [
                "id" => $dados['id_usuario'],
                "nome" => $dados['nome_usuario'],
                "cpf" => $dados['cpf_usuario'],
                "email" => $dados['email_usuario']
            ];

            $this->logarUsuario($dados['lembrarUsuario']);

            return $this->sucesso("Usuario criado com sucesso");

        } catch(Exception $error){

            return $this->erro($error->getMessage());
        }
    }

    /**
     * Define a autenticação e tempo de expiração da sessão.
     */
    private function logarUsuario(bool $lembrar): void
    {
        $data = new DateTime();

        if ($lembrar) {
            $data->modify('+10 minutes');
        } else {
            $data->modify('+30 seconds');
        }

        $_SESSION['logado'] = true;
        $_SESSION['expira_em'] = $data->getTimestamp();
    }

    /**
     * Remove todos os dados da sessão.
     */
    public function desconectarUsuario(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Verifica se a sessão do usuário ainda é válida.
     */
    public function validarSessao(): array
    {
        if (!isset($_SESSION['logado'])) {
            return $this->erro("Usuario não está logado");
        }

        if (time() > $_SESSION['expira_em']) {

            $this->desconectarUsuario();

            return $this->erro("Tempo de sessão expirado");
        }

        return $this->sucesso("Usuario conectado");
    }
}