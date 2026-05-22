-- Banco de dados do projeto alpha
-- Um usuario possui suma única conta cadastrada
-- Um usuario pode ter varias simulações de calculo de rendimento

create database db_alpha;
use db_alpha;

create table tb_usuario(
	id_usuario int unsigned not null auto_increment primary key,
    nome_usuario varchar(80) not null,
    -- Char é mais rapido e indicado para valores constantes 
    cpf_usuario char(11) not null unique,
    email_usuario varchar(80) not null unique,
    -- telefone celular -> (xx) 9xxxx-xxxx : 11 digitos numericos com DDD
    celular_usuario char(11) not null unique,
    data_nascimento_usuario date not null,
    senha_usuario varchar(30) not null
);

create table tb_conta_usuario(
    -- essa linha força apenas uma conta por usuario cadastrado
	id_usuario int unsigned not null unique,
    nome_banco_conta varchar(80) not null,
    numero_conta varchar(13) not null,
    foreign key (id_usuario) references tb_usuario (id_usuario)
);

create table tb_registros(
	id_registro int unsigned auto_increment primary key,
    -- creio que o unico dado de usuario que se deve ter nessa tabela é o id
    id_usuario int unsigned not null,
    -- um valor decimal com 3 digitos inteiros e duas casas decimais 
    taxa_registro decimal(5, 2) not null,
    tempo_registro int unsigned not null,
    -- aceita numeros até 99 999 999,99
    capital_registro decimal(10, 2) not null,
    rendimento_registro decimal(10, 2) not null
);
