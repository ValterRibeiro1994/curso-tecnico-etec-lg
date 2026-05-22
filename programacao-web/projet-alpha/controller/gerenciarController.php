<?php

require_once("../template/templateGerenciar.php");
require_once("../controller/validateController.php");
require_once("../controller/conexaoController.php");
require_once("../controller/sessaoController.php");

// carrega o template responsável pela página de gerenciamento
$template = new TemplateGerenciar();

// carrega o controlador de validações
$validador = new ValidateController();

// carrega o controlador de acesso ao banco de dados
$database = new ConexaoController();

/**
 * função auxiliar responsável por:
 * 
 * 1. buscar registros do usuário
 * 2. montar tabela HTML
 * 3. substituir placeholders do template
 */
function criarTabela(
    SessaoController $gerenciador_sessao,
    TemplateGerenciar $template,
    ValidateController $validador,
    ConexaoController $database
){

    // captura o ID do usuário autenticado
    $id = (int) $gerenciador_sessao->obterId();

    // busca registros financeiros do usuário
    $resposta = $database->buscarRegistros($id);

    // verifica falha ao buscar registros
    if (!$resposta['status']){

        echo(
            $template->criarTemplate(
                true,
                $resposta['message']
            )
        );

        return;
    }

    // captura dados retornados pelo banco
    $dados_registro = $resposta['dados'];

    // define colunas da tabela
    $chaves = ["taxa", "tempo", "capital", "rendimento"];

    // cria tabela HTML dinâmica
    $template->criarTabela($chaves, $dados_registro);

    // captura nome e e-mail armazenados na sessão
    $nome = $gerenciador_sessao->obterNome();
    $email = $gerenciador_sessao->obterEmail();

    // substitui placeholders do template
    $template->editarPlaceHolder($nome, $email);

    return;
}

/**
 * verifica se o usuário possui:
 * 
 * 1. sessão autenticada
 * 2. conta bancária cadastrada
 */
function autorizarPagina(SessaoController $gerenciador_sessao){

    // valida sessão do usuário
    $resposta = $gerenciador_sessao->validarSessao();

    // impede acesso sem login
    if (!$resposta['status']){

        header("Location: loginController.php");
        return;
    }

    // verifica se o usuário possui conta cadastrada
    $resposta = $gerenciador_sessao->validarConta();

    // caso não exista conta, redireciona para cadastro bancário
    if (!$resposta['status']){

        header("Location: bancoController.php");
        return;
    }
}

// instancia gerenciador de sessão
$gerenciador_sessao = new SessaoController();

// verifica método HTTP recebido
if ($_SERVER['REQUEST_METHOD'] === "GET"){

    /**
     * fluxo GET:
     * 
     * apenas exibe página de gerenciamento
     */

    // valida acesso do usuário
    autorizarPagina($gerenciador_sessao);

    // monta tabela e placeholders
    criarTabela(
        $gerenciador_sessao,
        $template,
        $validador,
        $database
    );

    // renderiza página
    echo(
        $template->criarTemplate(
            false,
            ""
        )
    );

    exit();

} else if ($_SERVER['REQUEST_METHOD'] === "POST"){

    /**
     * fluxo POST:
     * 
     * responsável por:
     * 
     * 1. editar nome
     * 2. editar e-mail
     * 3. redirecionar para cálculo
     */

    // valida autorização da página
    autorizarPagina($gerenciador_sessao);

    /**
     * ==========================================
     * EDIÇÃO DE NOME
     * ==========================================
     */

    if (isset($_POST['editarNome'])){

        // captura novo nome enviado pelo formulário
        $novo_nome = $_POST['editarNome'];

        // valida nome
        $resposta = $validador->validarNome($novo_nome);

        // verifica falha na validação
        if (!$resposta['status']){

            criarTabela(
                $gerenciador_sessao,
                $template,
                $validador,
                $database
            );

            echo(
                $template->criarTemplate(
                    true,
                    $resposta['message']
                )
            );

            exit();
        }

        // captura ID do usuário autenticado
        $id = (int) $gerenciador_sessao->obterId();

        // atualiza nome no banco de dados
        $resposta = $database->editarNome($id, $novo_nome);

        // verifica erro SQL
        if (!$resposta['status']){

            criarTabela(
                $gerenciador_sessao,
                $template,
                $validador,
                $database
            );

            echo(
                $template->criarTemplate(
                    true,
                    $resposta['message']
                )
            );

            exit();
        }

        // atualiza nome armazenado na sessão
        $gerenciador_sessao->editarNome($novo_nome);

        // recria tabela e placeholders
        criarTabela(
            $gerenciador_sessao,
            $template,
            $validador,
            $database
        );

        // renderiza página com mensagem de sucesso
        echo(
            $template->criarTemplate(
                true,
                "Nome modificado com sucesso"
            )
        );

        exit();
    }

    /**
     * ==========================================
     * EDIÇÃO DE E-MAIL
     * ==========================================
     */

    if (isset($_POST['editarEmail'])){

        // captura novo e-mail enviado pelo formulário
        $novo_email = $_POST['editarEmail'];

        // valida e-mail
        $resposta = $validador->validarEmail($novo_email);

        // verifica falha de validação
        if (!$resposta['status']){

            criarTabela(
                $gerenciador_sessao,
                $template,
                $validador,
                $database
            );

            echo(
                $template->criarTemplate(
                    true,
                    $resposta['message']
                )
            );

            exit();
        }

        // captura ID do usuário autenticado
        $id = (int) $gerenciador_sessao->obterId();

        // atualiza e-mail no banco
        $resposta = $database->editarEmail($id, $novo_email);

        // verifica erro SQL
        if (!$resposta['status']){

            criarTabela(
                $gerenciador_sessao,
                $template,
                $validador,
                $database
            );

            echo(
                $template->criarTemplate(
                    true,
                    $resposta['message']
                )
            );

            exit();
        }

        // atualiza e-mail armazenado na sessão
        $gerenciador_sessao->editarEmail($novo_email);

        // recria tabela e placeholders
        criarTabela(
            $gerenciador_sessao,
            $template,
            $validador,
            $database
        );

        // renderiza página com mensagem de sucesso
        echo(
            $template->criarTemplate(
                true,
                "E-mail modificado com sucesso"
            )
        );

        exit();
    }

    /**
     * ==========================================
     * REDIRECIONAMENTO PARA CÁLCULO
     * ==========================================
     */

    if (isset($_POST['btnCalcularRendimento'])){

        // envia usuário para página de cálculo
        header("Location: pedidoController.php");

        exit();
    }

} else {

    // método HTTP não permitido
    echo("Requisição invalida para esse projeto");

    exit();
}