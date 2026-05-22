<?php
require_once("../controller/respostaFuncao.php");

class ValidateController {
    private RespostaFuncao $resposta;

    public function __construct() {
        $this->resposta = new RespostaFuncao();
    }

    public function validarLogin(array $post) {
        // verifica se o botão submit está indentificado como login
        if (!isset($post['login'])) {
            return $this->resposta->respostaFuncao(false, "Erro dev: Botão não indentificado para login !!!", []);
        }

        $campos = ["emailUsuario", "senhaUsuario"];
        $n = count($campos);

        for ($x = 0; $x < $n; $x++) {
            $campo = $campos[$x];

            if (!isset($post[$campo])) {
                return $this->resposta->respostaFuncao(false, "Preencha todos os campos !!! -> " . $campo, []);
            }
        }

        // para o login são verificados 3 entradas (email, senha e lembrar)
        $resposta = $this->validarEmail($post['emailUsuario']);
        if (!$resposta['status']){
            return $resposta;
        }

        $senha = $post['senhaUsuario'];
        if (empty($senha)) {
            return $this->resposta->respostaFuncao(false, "Senha não informada", []);
        }

        return $this->resposta->respostaFuncao(true, "Dados fornecidos validados", []);
    }

    public function validarBanco(array $post) {
        /**
         * O metodo deve validar se o numero da conta e o capital
         * são valores numericos e se o banco é conhecido pelo sistema
         */

        // verifica se o botão submit está indentificado como banco
        if (!isset($post['banco'])) {
            return $this->resposta->respostaFuncao(false, "Erro dev: Botão não indentificado para banco !!!", []);
        }

        $campos = ["bancoUsuario", "contaUsuario"];
        $n = count($campos);

        for ($x = 0; $x < $n; $x++) {
            $campo = $campos[$x];

            if (!isset($post[$campo])) {
                return $this->resposta->respostaFuncao(false, "Preencha todos os campos !!! -> " . $campo, []);
            }
        }

        $bancos_conhecidos = ["nubank", "caixa economica", "banco do brasil","santander"];
        $n = count($bancos_conhecidos);
        $encontrado = false;

        for ($x = 0; $x < $n; $x++) {
            $banco_recebido = strtolower($post['bancoUsuario']);
            if ($banco_recebido === $bancos_conhecidos[$x]) {
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            return $this->resposta->respostaFuncao(false, "Banco informado não conhecido pelo sistema", []);
        }

        // valida o numero da conta
        if (empty($post['contaUsuario'])) {
            return $this->resposta->respostaFuncao(false, "Número da conta não enviado", []);
        }

        if (!is_numeric($post['contaUsuario'])) {
            return $this->resposta->respostaFuncao(false, "Numero da conta deve possuir apenas números", []);
        }

        return $this->resposta->respostaFuncao(true, "Dados validados", []);
    }

    public function validarPedido(array $post) {
        // verifica se o botão submit está indentificado como banco
        if (!isset($post['pedido'])) {
            return $this->resposta->respostaFuncao(false, "Erro dev: Botão não indentificado para pedido !!!", []);
        }

        $campos = ["taxaUsuario", "tempoUsuario", "capitalUsuario"];
        $n = count($campos);

        for ($x = 0; $x < $n; $x++) {
            $campo = $campos[$x];

            if (!isset($post[$campo]) or empty($post[$campo])) {
                return $this->resposta->respostaFuncao(false, "Preencha todos os campos !!! -> " . $campo, []);
            }
        }

        if (!is_numeric($post['taxaUsuario'])) {
            return $this->resposta->respostaFuncao(false, "O valor capital deve receber apenas números !!!", []);
        }
        if (!is_numeric($post['tempoUsuario'])) {
            return $this->resposta->respostaFuncao(false, "O valor capital deve receber apenas números !!!", []);
        }
        if (!is_numeric($post['capitalUsuario'])) {
            return $this->resposta->respostaFuncao(false, "O valor capital deve receber apenas números !!!", []);
        }

        return $this->resposta->respostaFuncao(true, "Dados enviado com sucesso", []);
    }

    public function validarCadastro(array $post) {
        if (!isset($post['cadastro'])) {
            return $this->resposta->respostaFuncao(false, "Erro dev: Botão não indentificado para cadastro !!!", []);
        }

        $campos = ["nomeUsuario", "emailUsuario", "cpfUsuario", "celularUsuario", "senhaUsuario", "senhaConfirmacaoUsuario"];
        $n = count($campos);

        for ($x = 0; $x < $n; $x++) {
            $campo = $campos[$x];

            if (!isset($post[$campo])) {
                return $this->resposta->respostaFuncao(false, "Preencha todos os campos !!! -> " . $campo, []);
            }
        }

        $resposta = $this->validarNome($post['nomeUsuario']);
        if (!$resposta['status']) {
            return $resposta;
        }

        $resposta = $this->validarNascimento($post['nomeUsuario']);
        if (!$resposta['status']) {
            return $resposta;
        }

        $resposta = $this->validarEmail($post['emailUsuario']);
        if (!$resposta['status']) {
            return $resposta;
        }

        $resposta = $this->validarCpf($post['cpfUsuario']);
        if (!$resposta['status']) {
            return $resposta;
        }

        $resposta = $this->validarCelular($post['celularUsuario']);
        if (!$resposta['status']) {
            return $resposta;
        }

        if (empty($post['senhaUsuario'])) {
            return $this->resposta->respostaFuncao(false, "Senha não enviada", []);
        }

        if (empty($post['senhaConfirmacaoUsuario'])) {
            return $this->resposta->respostaFuncao(false, "Senha de confirmação não enviado", []);
        }

        // verifica a senha de confirmação e a senha enviada
        if ($post['senhaUsuario'] !== $post['senhaConfirmacaoUsuario']) {
            return $this->resposta->respostaFuncao(false, "Senhas não conferem", []);
        }

        return $this->resposta->respostaFuncao(true, "Cadastro realizado", []);
    }

    public function validarRecuperarSenha(array $post) {
        $campos = ["emailUsuario", "cpfUsuario", "celularUsuario", "nascimentoUsuario"];

        $n = count($campos);
        for ($x = 0; $x < $n; $x++) {
            $campo = $campos[$x];

            if (!isset($post[$campo])) {
                return $this->resposta->respostaFuncao(false, "Preencha todos os campos !!!", []);
            }
        }

        $resposta = $this->validarEmail($post['emailUsuario']);
        if (!$resposta['status']) {
            return $resposta;
        }

        $resposta = $this->validarCpf($post['cpfUsuario']);
        if (!$resposta['status']) {
            return $resposta;
        }

        $resposta = $this->validarNascimento($post['nascimentoUsuario']);
        if (!$resposta['status']) {
            return $resposta;
        }
        
        $resposta = $this->validarCelular($post['celularUsuario']);
        if (!$resposta['status']) {
            return $resposta;
        }

        return $this->resposta->respostaFuncao(true, "", []);
    }

    public function validarNome(string $nome) {
        if (empty($nome)) {
            return $this->resposta->respostaFuncao(false, "Nome não informado", []);
        }

        $comprimento = $this->validarComprimento($nome);

        if (!$comprimento['status']) {
            return $comprimento;
        }

        return $this->resposta->respostaFuncao(true, "Nome validado", []);
    }

    public function validarComprimento(string $str) {
        $n = strlen($str);

        if ($n > 80) {
            return $this->resposta->respostaFuncao(false, "Limite de caracteres excedido, maximo 80 caracteres", []);
        }

        if ($n < 3) {
            return $this->resposta->respostaFuncao(false, "Caracteres informados são insuficiente para registro !!!", []);
        }

        return $this->resposta->respostaFuncao(true, "", []);
    }

    public function validarEmail(string $email) {
        if (empty($email)) {
            return $this->resposta->respostaFuncao(false, "E-mail não enviado", []);
        }

        $comprimento = $this->validarComprimento($email);

        if (!$comprimento['status']) {
            return $comprimento;
        }

        // valida o Email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->resposta->respostaFuncao(false, "E-mail Invalido", []);
        }

        return $this->resposta->respostaFuncao(true, "", []);
    }

    public function validarCpf(string $cpf) {
        if (empty($cpf)) {
            return $this->resposta->respostaFuncao(false, "CPF não enviado", []);
        }

        if (!is_numeric($cpf)) {
            return $this->resposta->respostaFuncao(false, "CPF invalido, informe apenas números", []);
        }

        if (strlen($cpf) !== 11) {
            return $this->resposta->respostaFuncao(false, "Cpf invalido !!!", []);
        }

        return $this->resposta->respostaFuncao(true, "", []);
    }

    public function validarCelular(string $celular) {
        if (empty($celular)) {
            return $this->resposta->respostaFuncao(false, "Numero celular não enviado", []);
        }

        if (!is_numeric($celular)) {
            return $this->resposta->respostaFuncao(false, "Celular invalido, informe apenas números", []);
        }

        if (strlen($celular) !== 11) {
            return $this->resposta->respostaFuncao(false, "Celular invalido, informe o DDD, celular deve ter 11 caracteres", []);
        }

        return $this->resposta->respostaFuncao(true, "Celular validado com sucesso", []);
    }

    public function validarNascimento(string $nascimento) {
        if (empty($nascimento)) {
            return $this->resposta->respostaFuncao(false, "Data de nascimento não enviada", []);
        }

        return $this->resposta->respostaFuncao(true, "", []);
    }


}