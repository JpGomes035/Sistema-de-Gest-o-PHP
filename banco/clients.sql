-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/06/2024 às 21:10
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `clients`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clients`
--

CREATE TABLE `clients` (
  `cliente_id` int(11) NOT NULL,
  `razao_social_cliente` varchar(255) DEFAULT NULL,
  `documento_cliente` varchar(25) DEFAULT NULL,
  `nome_cliente` varchar(100) DEFAULT NULL,
  `valor_mensalidade` decimal(10,2) DEFAULT NULL,
  `pago` enum('sim','nao') DEFAULT 'nao',
  `inicio_contrato` datetime DEFAULT NULL,
  `responsavel_contrato` varchar(100) DEFAULT NULL,
  `info_database` varchar(150) DEFAULT NULL,
  `senha_database` varchar(150) DEFAULT NULL,
  `email_contato` varchar(150) DEFAULT NULL,
  `tel_contato` varchar(150) DEFAULT NULL,
  `ativo` char(5) DEFAULT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clients`
--

INSERT INTO `clients` (`cliente_id`, `razao_social_cliente`, `documento_cliente`, `nome_cliente`, `valor_mensalidade`, `pago`, `inicio_contrato`, `responsavel_contrato`, `info_database`, `senha_database`, `email_contato`, `tel_contato`, `ativo`, `deletado`, `id_reg_delet`) VALUES
(13, 'ProControl', '28.230.375/0001-67', 'Jorge', 150.99, 'sim', '2024-03-20 12:51:10', 'João Pedro', 'estoque', 'null', 'joaopedrogomes@gmail.com', '+55 (35) 8468-7649', 'sim', 'n', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Nome` varchar(80) NOT NULL,
  `Sobrenome` varchar(90) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Senha` varchar(256) NOT NULL,
  `NivelUsuario` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `telefoneUsuario` varchar(20) NOT NULL,
  `cpfUsuario` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Nome`, `Sobrenome`, `Email`, `Senha`, `NivelUsuario`, `Status`, `telefoneUsuario`, `cpfUsuario`) VALUES
(1, 'João', 'Pedro', 'joao@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 'Ativo', '+55 (35) 8468-7649', '139.527.326-05'),
(43, 'Jorge', 'Lenda', 'jorge@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 'Ativo', '+55 (35) 8468-7649', '121.354.645-45');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
