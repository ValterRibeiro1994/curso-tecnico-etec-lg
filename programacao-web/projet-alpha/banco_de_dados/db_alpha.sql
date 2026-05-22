-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 18/05/2026 às 09:44
-- Versão do servidor: 8.4.7
-- Versão do PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_alpha`
--
CREATE DATABASE IF NOT EXISTS `db_alpha` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_alpha`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_conta_usuario`
--

DROP TABLE IF EXISTS `tb_conta_usuario`;
CREATE TABLE IF NOT EXISTS `tb_conta_usuario` (
  `id_usuario` int UNSIGNED NOT NULL,
  `nome_banco_conta` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_conta` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_conta_usuario`
--

INSERT INTO `tb_conta_usuario` (`id_usuario`, `nome_banco_conta`, `numero_conta`) VALUES
(4, 'Nubank', '1238');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_registros`
--

DROP TABLE IF EXISTS `tb_registros`;
CREATE TABLE IF NOT EXISTS `tb_registros` (
  `id_registro` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario` int UNSIGNED NOT NULL,
  `taxa_registro` decimal(5,2) NOT NULL,
  `tempo_registro` int UNSIGNED NOT NULL,
  `capital_registro` decimal(10,2) NOT NULL,
  `rendimento_registro` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_registro`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_registros`
--

INSERT INTO `tb_registros` (`id_registro`, `id_usuario`, `taxa_registro`, `tempo_registro`, `capital_registro`, `rendimento_registro`) VALUES
(32, 4, 0.01, 3, 2000.00, 2060.60),
(31, 4, 0.01, 12, 100.00, 112.68),
(30, 4, 0.03, 12, 100.00, 142.58),
(29, 4, 0.01, 3, 100.00, 103.03);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `id_usuario` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf_usuario` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_usuario` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `celular_usuario` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nascimento_usuario` date NOT NULL,
  `senha_usuario` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `cpf_usuario` (`cpf_usuario`),
  UNIQUE KEY `email_usuario` (`email_usuario`),
  UNIQUE KEY `celular_usuario` (`celular_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `nome_usuario`, `cpf_usuario`, `email_usuario`, `celular_usuario`, `data_nascimento_usuario`, `senha_usuario`) VALUES
(4, 'valter sergio', '07845179914', 'valtertert@gmail.com', '16994030287', '1994-10-13', '321');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
