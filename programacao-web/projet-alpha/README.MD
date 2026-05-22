# Projeto Alpha - Aplicação Web de Cálculo de Rendimento

## Visão Geral
Este projeto foi desenvolvido como exercício de programação web para a disciplina de Desenvolvimento de Sistemas. Trata-se de uma aplicação em PHP com conexão MySQL e interface em Bootstrap, que implementa cadastro de usuário, autenticação, registro de conta bancária, cálculo de rendimento por juros compostos e histórico de cálculos.

O objetivo principal do exercício é demonstrar o conhecimento aplicado em:
- arquitetura de controllers e templates em PHP
- requisições HTTP `GET` e `POST`
- validação de formulários no servidor
- conexão segura com banco de dados usando PDO
- gerenciamento de sessão do usuário com controle de expiração
- persistência de dados em tabelas normalizadas
- integração de envio de email com PHPMailer
- aplicação de lógica matemática em PHP (juros compostos)

---

## Funcionalidades implementadas

1. **Cadastro de usuário**
   - Registro de nome, email, CPF, celular, data de nascimento e senha.
   - Validação de campos obrigatórios, formato de email, CPF e telefone com 11 dígitos.
   - Tratamento de duplicidade de email e CPF no banco de dados.

2. **Login e autenticação**
   - Login via email e senha.
   - Opção "Lembrar usuário" para estender o tempo de sessão.
   - Validação de sessão ativa em todas as páginas protegidas.

3. **Cadastro de conta bancária**
   - Após login, o usuário deve cadastrar conta bancária.
   - Apenas bancos conhecidos pelo sistema são aceitos.
   - Uma conta por usuário.

4. **Cálculo de rendimento por juros compostos**
   - Lógica implementada no `pedidoController.php`.
   - Fórmula utilizada:
     - `M = C * (1 + i)^t`
   - Resultado exibido ao usuário e salvo no histórico.

5. **Histórico de cálculos**
   - Página de gerenciamento exibe os pedidos registrados pelo usuário.
   - Exibe taxa, tempo, capital e rendimento.

6. **Recuperação de senha por email**
   - Validação de email, CPF, telefone e data de nascimento.
   - Envio do email com a senha cadastrada usando PHPMailer.

7. **Edição de perfil**
   - Permite alterar nome e email na página de gerenciamento.

---

## Estrutura do projeto

- `index.php`
  - Entrypoint do sistema. Redireciona para `controller/loginController.php`.

- `controller/`
  - `loginController.php` - processamento de login e redirecionamento.
  - `cadastroController.php` - cadastro de usuário.
  - `bancoController.php` - cadastro de conta bancária.
  - `pedidoController.php` - cálculo de rendimento e registro do pedido.
  - `gerenciarController.php` - histórico e edição de dados.
  - `recuperarSenhaController.php` - processo de recuperação de senha por email.
  - `conexaoController.php` - conexão com MySQL e operações CRUD.
  - `validateController.php` - validações de campos e regras de negócio.
  - `sessaoController.php` - gerenciamento de sessão e autenticação.
  - `respostaFuncao.php` - padronização das respostas internas.

- `template/`
  - Templates de interface para login, cadastro, conta bancária, recuperação de senha e gerenciamento.
  - `appTemplate.php` escolhe o template correto para cada página.

- `bootstrap/`
  - Arquivos CSS e JS do Bootstrap usados para a interface responsiva.

- `banco_de_dados/`
  - `codigo_tabela.md` - script SQL para criar as tabelas do banco de dados.

- `src/`
  - Biblioteca PHPMailer utilizada no envio de emails.

---

## Banco de dados

O projeto usa o banco de dados `db_alpha` com as seguintes tabelas:

### `tb_usuario`
- `id_usuario` INT AUTO_INCREMENT PRIMARY KEY
- `nome_usuario` VARCHAR(80)
- `cpf_usuario` CHAR(11) UNIQUE
- `email_usuario` VARCHAR(80) UNIQUE
- `celular_usuario` CHAR(11) UNIQUE
- `data_nascimento_usuario` DATE
- `senha_usuario` VARCHAR(30)

### `tb_conta_usuario`
- `id_usuario` INT UNIQUE
- `nome_banco_conta` VARCHAR(80)
- `numero_conta` VARCHAR(13)
- `FOREIGN KEY (id_usuario)` referencia `tb_usuario(id_usuario)`

### `tb_registros`
- `id_registro` INT AUTO_INCREMENT PRIMARY KEY
- `id_usuario` INT
- `taxa_registro` DECIMAL(5,2)
- `tempo_registro` INT
- `capital_registro` DECIMAL(10,2)
- `rendimento_registro` DECIMAL(10,2)

> Observação: o arquivo `banco_de_dados/codigo_tabela.md` contém a criação completa das tabelas.

---

## Fluxo de uso

1. Acessar `index.php`.
2. O sistema redireciona para a tela de login.
3. Se não tiver conta, clicar em "Cadastrar".
4. Após cadastrar, efetuar login.
5. Cadastrar a conta bancária.
6. Informar taxa, tempo e capital para calcular o rendimento.
7. Visualizar o resultado e acessar o histórico em "Gerenciar".
8. Editar nome ou email e visualizar todos os cálculos já realizados.

---

## Conceitos aplicados

- `GET` e `POST` para separar visualização e processamento.
- `require_once` para incluir classes e manter o código organizado.
- `PDO` com tratamento de exceções para consultas SQL seguras.
- Validação no servidor para evitar dados inválidos e injeção.
- Sessões PHP para controle de login.
- Uso de templates para separar camada de apresentação da lógica de negócio.
- Lógica financeira com juros compostos para calcular rendimentos.
- Envio de email com PHPMailer para funcionalidade de recuperação de senha.

---

## Métricas de qualidade no exercício

- Separação clara de responsabilidades:
  - `controller/` trata regras de negócio e rotas.
  - `template/` trata visualização.
  - `src/` contém bibliotecas externas.
- Reuso via classes `ConexaoController`, `ValidateController` e `SessaoController`.
- Mensagens de erro amigáveis ao usuário.
- Redirecionamento lógico entre páginas protegido por sessão.

---

## Instruções de instalação e execução

1. Configure um servidor PHP local que suporte MySQL (XAMPP, WAMP, Laragon etc.).
2. Copie a pasta do projeto para a pasta pública do servidor.
3. Crie o banco de dados `db_alpha` e execute o script SQL do arquivo `banco_de_dados/codigo_tabela.md`.
4. Verifique as credenciais MySQL em `controller/conexaoController.php`:
   - `localhost`
   - `root`
   - senha vazia `""`
   - banco `db_alpha`
5. Ajuste as configurações de email em `controller/recuperarSenhaController.php` se desejar usar recuperação de senha real.
6. Abra o navegador em `http://localhost/<pasta-do-projeto>/index.php`.

---

## Observações importantes

- A senha atualmente é armazenada em texto simples no banco de dados. Em um sistema real, deve ser usada hash segura (`password_hash` / `password_verify`).
- A funcionalidade de recuperação de senha demonstra integração com email, mas exige configuração de SMTP e credenciais corretas.
- O projeto foi desenvolvido como exercício didático e demonstra conceitos fundamentais de programação web em PHP.

---

## Conclusão
Este README explica a arquitetura e a lógica aplicada no exercício de programação web, com foco nos conceitos de cadastro, autenticação, persistência em banco de dados, sessão, validação e cálculo de juros compostos. O projeto serve como um bom exemplo prático do conteúdo da aula, mantendo a organização de pastas e a separação entre lógica e apresentação.
