-- Alunos: Valter Sergio Ribeiro Tertuliano, Lucas Braz da Silva, Felipe Rodrigo dos Santos Rodrigues


create database db_imoveis;

use db_imoveis;

create table tb_imoveis(
id_movel int auto_increment,
valor_imovel decimal(10,2) unsigned not null,
quant_quartos_imovel int unsigned not null,
endereco_imovel varchar(50) not null,
bairro_imovel varchar(50) not null,
cidade_imovel varchar(50) not null,
status_imovel enum("venda", "vendido", "alugada", "aluguel") not null,
data_cadastro_imovel date not null,
primary key(id_movel)
);

-- 1
select * from tb_imoveis order by cidade_imovel asc;

-- 2
select endereco_imovel, bairro_imovel, status_imovel from tb_imoveis where cidade_imovel = "Piracicaba" or "piracicaba";

-- 3
select * from  tb_imoveis where endereco_imovel = "R. Carmo Oliveira, 34" and cidade_imovel = "Porto Ferreira" or "porto ferreira";

-- criar uma coluna estado
alter table tb_imoveis add column estado_imovel varchar(2) not null;
alter table tb_imoveis drop column estado_imovel;

-- continuando exercicio
-- 4
select * from tb_imoveis order by status_imovel asc;

-- 5
select * from tb_imoveis order by valor_imovel asc;

-- 6
select * from tb_imoveis where (cidade_imovel = "Votorantim" || "Sorocaba" || "votorantim" || "sorocaba") and valor_imovel < 2000.00;

-- 7 
select * from tb_imoveis where  year(data_cadastro_imovel) < 2022 and (cidade_imovel) = "Bauru" or "bauru"  order by (quant_quartos_imovel) asc;

-- 8
select * from tb_imoveis where quant_quartos_imovel = 2 or 3;

 