-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/06/2024 às 21:09
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
-- Banco de dados: `estoque`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agenda`
--

CREATE TABLE `agenda` (
  `idAgenda` int(5) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `data` date NOT NULL,
  `descricao` varchar(1500) NOT NULL,
  `nivelAprov` varchar(15) NOT NULL,
  `telAgenda` varchar(25) NOT NULL,
  `resp` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agenda`
--

INSERT INTO `agenda` (`idAgenda`, `titulo`, `data`, `descricao`, `nivelAprov`, `telAgenda`, `resp`) VALUES
(113, 'teste', '2025-05-01', 'teste', 'Ativo', '+55 (35) 8468-7649', 'João');

-- --------------------------------------------------------

--
-- Estrutura para tabela `banco`
--

CREATE TABLE `banco` (
  `idBanco` int(5) NOT NULL,
  `nomeBanco` varchar(150) NOT NULL,
  `agencia` varchar(20) NOT NULL,
  `cc` varchar(50) NOT NULL,
  `valor_banco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `banco`
--

INSERT INTO `banco` (`idBanco`, `nomeBanco`, `agencia`, `cc`, `valor_banco`) VALUES
(1, 'Cofre', '2322', '12121-5', 99.00),
(2, 'Caixa', '1212', '12121-2', 346.84);

-- --------------------------------------------------------

--
-- Estrutura para tabela `boletos`
--

CREATE TABLE `boletos` (
  `id_boleto` int(11) NOT NULL,
  `numero_boleto` varchar(20) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_emissao` date NOT NULL,
  `data_vencimento` date NOT NULL,
  `beneficiario` varchar(100) NOT NULL,
  `pagador_nome` varchar(100) NOT NULL,
  `pagador_cpf` varchar(25) NOT NULL,
  `status_pagamento` varchar(20) DEFAULT NULL,
  `deletado` char(1) NOT NULL,
  `id_reg_delet` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `boletos`
--

INSERT INTO `boletos` (`id_boleto`, `numero_boleto`, `valor`, `data_emissao`, `data_vencimento`, `beneficiario`, `pagador_nome`, `pagador_cpf`, `status_pagamento`, `deletado`, `id_reg_delet`) VALUES
(5, '120780', 138.98, '2004-04-01', '2024-01-15', 'Jao', 'Jp', '139.527.326-05', 'Recebido', 'N', 1),
(7, '120783', 150.98, '2024-01-10', '2024-01-18', 'Jorge', 'João', '139.527.326-05', 'Vencido', 'N', 0),
(8, '125', 100.00, '2024-01-18', '2024-01-31', 'Jao', 'otario', '139.527.326-05', 'Pendente', 'N', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `IdCategoria` int(11) NOT NULL,
  `Nome` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`IdCategoria`, `Nome`) VALUES
(14, 'Direto'),
(17, 'Alimento');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nomeCliente` varchar(150) NOT NULL,
  `numeroCliente` varchar(150) NOT NULL,
  `emailCliente` varchar(150) NOT NULL,
  `cepCliente` varchar(15) NOT NULL,
  `cpfCliente` varchar(20) NOT NULL,
  `respCliente` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nomeCliente`, `numeroCliente`, `emailCliente`, `cepCliente`, `cpfCliente`, `respCliente`) VALUES
(21, 'João ', '+55 (35) 9967-7580', 'contat.joao10@gmail.com', '37504-500', '139.527.326-06', 'Jorge'),
(23, 'Consumidor Final', '', 'contato@gmail.com', '', '', '.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contas_pagar`
--

CREATE TABLE `contas_pagar` (
  `id_Contaspagar` int(36) NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `descricao_pagar` varchar(200) NOT NULL,
  `valor_parcela` decimal(10,2) NOT NULL,
  `valor_compra` decimal(10,2) NOT NULL,
  `valor_abatido` decimal(10,2) NOT NULL,
  `data_compra` date NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_vencimento` date NOT NULL,
  `data_pagamento` date NOT NULL,
  `status` char(1) NOT NULL,
  `cliente` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contas_pagar`
--

INSERT INTO `contas_pagar` (`id_Contaspagar`, `numero_documento`, `descricao_pagar`, `valor_parcela`, `valor_compra`, `valor_abatido`, `data_compra`, `data_cadastro`, `data_vencimento`, `data_pagamento`, `status`, `cliente`) VALUES
(2, '17', 'Pagamento do carro', 150.00, 300.00, 100.00, '2023-10-10', '2023-10-12 17:07:08', '2024-03-15', '2023-10-23', 'N', 'João'),
(45, '1', 'desp', 15.99, 35.99, 0.99, '2024-02-01', '2024-03-25 20:50:36', '2024-05-01', '2024-04-24', 'S', 'Consumidor Final');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contas_receber`
--

CREATE TABLE `contas_receber` (
  `id_Contasreceber` int(36) NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `descricao_venda` varchar(200) NOT NULL,
  `valor_parcela` decimal(10,2) NOT NULL,
  `valor_venda` decimal(10,2) NOT NULL,
  `valor_abatido` decimal(10,2) NOT NULL,
  `data_venda` date NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_vencimento` date NOT NULL,
  `data_recebimento` date NOT NULL,
  `status` char(1) NOT NULL,
  `cliente` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contas_receber`
--

INSERT INTO `contas_receber` (`id_Contasreceber`, `numero_documento`, `descricao_venda`, `valor_parcela`, `valor_venda`, `valor_abatido`, `data_venda`, `data_cadastro`, `data_vencimento`, `data_recebimento`, `status`, `cliente`) VALUES
(54, '15', 'teste', 121.99, 150.25, 19.00, '2024-02-01', '2024-03-25 12:56:23', '2024-02-01', '2024-03-27', 'N', 'Consumidor Final'),
(55, '1', 'Jogos', 159.20, 200.15, 0.00, '2024-02-01', '2024-03-25 20:20:28', '2024-05-01', '2024-03-27', 'S', 'João');

-- --------------------------------------------------------

--
-- Estrutura para tabela `duvida`
--

CREATE TABLE `duvida` (
  `idDuvida` int(5) NOT NULL,
  `descDuv` varchar(500) NOT NULL,
  `emailDuv` varchar(40) NOT NULL,
  `dataDuv` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `duvida`
--

INSERT INTO `duvida` (`idDuvida`, `descDuv`, `emailDuv`, `dataDuv`) VALUES
(1, 'O que é arroz', 'arroz é sla oq', '2023-09-15 14:29:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `entrada`
--

CREATE TABLE `entrada` (
  `id` int(15) NOT NULL,
  `quantos` varchar(150) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `fmpag` varchar(150) NOT NULL,
  `responsavel` varchar(150) NOT NULL,
  `data` date DEFAULT NULL,
  `datareg` datetime DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `nomeBanco` varchar(70) NOT NULL,
  `id_reg` int(5) NOT NULL,
  `id_reg_edit` int(5) DEFAULT NULL,
  `deletado` char(1) NOT NULL,
  `id_reg_delet` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `entrada`
--

INSERT INTO `entrada` (`id`, `quantos`, `descricao`, `fmpag`, `responsavel`, `data`, `datareg`, `nome`, `nomeBanco`, `id_reg`, `id_reg_edit`, `deletado`, `id_reg_delet`) VALUES
(14, '159.99', 'Concerto de CPU', 'Pix', 'João', '2024-01-30', '2024-01-28 01:42:10', 'João Pedro', 'Caixa', 2, 2, 'N', 2),
(15, '100.99', 'Venda', 'Dinheiro', 'João', '2024-01-15', '2024-02-04 17:14:37', 'João', 'Caixa', 2, 0, 'N', 2),
(16, '150', 'Teste', 'Teste', 'João', '2024-02-01', '2024-02-20 12:32:12', 'João', 'Caixa', 2, 0, 'N', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `IdProduto` int(11) NOT NULL,
  `Numero` varchar(50) NOT NULL,
  `Nome` varchar(200) NOT NULL,
  `precovenda` varchar(150) NOT NULL,
  `Quantidade` int(11) DEFAULT NULL,
  `Categoria` varchar(100) DEFAULT NULL,
  `Fornecedor` varchar(100) DEFAULT NULL,
  `descProd` varchar(500) DEFAULT NULL,
  `vencProd` varchar(150) DEFAULT NULL,
  `unidade_estoque` varchar(40) DEFAULT NULL,
  `peso` varchar(20) DEFAULT NULL,
  `precoPromocional` varchar(150) DEFAULT NULL,
  `status_prod` varchar(150) DEFAULT NULL,
  `preco_custo` varchar(150) DEFAULT NULL,
  `preco_bruto` varchar(150) DEFAULT NULL,
  `qntVendas` varchar(15) DEFAULT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `localEstoq` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`IdProduto`, `Numero`, `Nome`, `precovenda`, `Quantidade`, `Categoria`, `Fornecedor`, `descProd`, `vencProd`, `unidade_estoque`, `peso`, `precoPromocional`, `status_prod`, `preco_custo`, `preco_bruto`, `qntVendas`, `deletado`, `id_reg_delet`, `localEstoq`) VALUES
(57, '1642', 'Alicate', '19.99', 10, 'Ferramenta', 'ProControl', 'Alicate de bico', '2024-02-10', 'Unidade', '2', '150,99', 'Disponível', '300,50', '180,55', '9', 'N', 2, 'Local 3'),
(63, '133', 'Iphone XR 64GB', '2.000', 9, 'Direto', 'ProControl', 'Vermelho, 88% de Vida na bateria', '', 'UN', '0,194', '1,800', 'Disponível', '1,500', '1850', '2', 'N', NULL, 'Local 2'),
(62, '153', 'Capacitor', '140.50', 3, 'Ferramenta', 'ProControl', 'Capacitor de chuveiro', '2024-02-29', 'UN', '20', '15,99', 'Disponível', '109,50', '129,52', '7', 'N', NULL, '351'),
(64, '150', 'Monitor PCFORT', '453.99', 10, 'Direto', 'ProControl', 'Preto, HDMI e VGA, 1920x1080.', '', 'UN', '1', '', 'Disponivel', '', '', '3', 'N', 2, 'Local 1'),
(65, '157', 'Feijão Preto', '15.99', 10, 'Direto', 'ProControl', 'Feijão Preto', '2004-04-02', 'Pacote', '2', '15,99', 'Disponivel', '15,00', '19,00', '0', 'N', 2, 'Área G'),
(66, '150', 'Arroz', '15.99', 10, 'Direto', 'ProControl', 'Preto', '2024-04-08', 'UN', '', '', 'Disponivel', '', '', '2', 'N', NULL, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fm_pag`
--

CREATE TABLE `fm_pag` (
  `id_fmpag` int(5) NOT NULL,
  `nome_fmpag` varchar(100) DEFAULT NULL,
  `banco_vinculado` varchar(45) DEFAULT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `id_reg_edit` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fm_pag`
--

INSERT INTO `fm_pag` (`id_fmpag`, `nome_fmpag`, `banco_vinculado`, `deletado`, `id_reg_delet`, `id_reg_edit`) VALUES
(3, 'Pix ', 'Caixa', 'N', 2, 2),
(6, 'Teste', 'Caixa', 'S', 2, 2),
(7, 'teste', '', 'S', 2, 0),
(8, 'A prazo', 'Cofre', 'N', NULL, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `IdFornecedor` int(11) NOT NULL,
  `nomeForn` varchar(150) NOT NULL,
  `cnpjForn` varchar(20) NOT NULL,
  `telefoneForn` varchar(25) NOT NULL,
  `cepForn` varchar(15) NOT NULL,
  `emailForn` varchar(150) NOT NULL,
  `cod_Forn` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`IdFornecedor`, `nomeForn`, `cnpjForn`, `telefoneForn`, `cepForn`, `emailForn`, `cod_Forn`) VALUES
(14, 'ProControl', '21.221.312/0001-24', '+55 (35) 8468-7649', '37504-500', 'ProControl@gmail.com', '9073123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagens`
--

CREATE TABLE `imagens` (
  `id_imagem` int(5) NOT NULL,
  `nome` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `imagens`
--

INSERT INTO `imagens` (`id_imagem`, `nome`) VALUES
(26, 'IMG_3487.jpg'),
(27, 'fof.jpeg'),
(28, '8f2d4c23-75f7-4bbc-802c-65f2f08c2b7.jpeg'),
(29, 'e2bb3d37-37c6-4b66-8068-bb3547d08aea.jpeg'),
(30, 'procontrol.png'),
(31, 'ping.jpeg'),
(32, 'procontrol.png'),
(33, '8f2d4c23-75f7-4bbc-802c-65f2f08c2b78.jpeg'),
(34, 'ping.jpeg'),
(35, 'procontrol.png'),
(36, 'limpeza.png'),
(37, 'e2bb3d37-37c6-4b66-8068-bb3547d08aea.jpeg'),
(38, 'fof.jpeg'),
(39, 'gojo.jpg'),
(40, 'Chainsaw man (Denji) Ft_ The Weeknd [Starboy].jpg'),
(41, 'anime-girl-chilling-at-balcony-4k-de-1910x1075.jpg'),
(42, 'baixados.jpg'),
(43, 'gojo.jpg'),
(44, 'frieren-beyond-journey-s-end-oc-1910x1075.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `importaxml`
--

CREATE TABLE `importaxml` (
  `id` int(11) NOT NULL,
  `numeroNF` int(11) DEFAULT NULL,
  `chaveAcesso` varchar(255) DEFAULT NULL,
  `valorTotal` decimal(10,2) DEFAULT NULL,
  `valorICMS` decimal(10,2) DEFAULT NULL,
  `valorIPI` decimal(10,2) DEFAULT NULL,
  `valorPIS` decimal(10,2) DEFAULT NULL,
  `valorCOFINS` decimal(10,2) DEFAULT NULL,
  `cfop` varchar(10) DEFAULT NULL,
  `unidadeMedida` varchar(10) DEFAULT NULL,
  `xmlFilePath` varchar(255) DEFAULT NULL,
  `nomeFornecedor` varchar(255) DEFAULT NULL,
  `cnpjFornecedor` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `informacoes`
--

CREATE TABLE `informacoes` (
  `id_info` int(5) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(25) NOT NULL,
  `rua` varchar(150) NOT NULL,
  `cep` varchar(150) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `bairro` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `informacoes`
--

INSERT INTO `informacoes` (`id_info`, `nome`, `cnpj`, `email`, `telefone`, `rua`, `cep`, `cidade`, `bairro`) VALUES
(13, 'ProControl', '28.230.375/0001-67', 'Procontrol@gmail.com', '(35) 98468-7649', 'Rua Augusto de souza cardoso', '37504-500', 'Itajubá', 'Jardim das Palmeiras');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL,
  `codigo_pedido` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `nome_produto` varchar(200) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `codigo_pedido`, `produto_id`, `nome_produto`, `quantidade`, `valor_unitario`) VALUES
(30, 30, 57, 'Alicate', 10, 10.99),
(31, 31, 62, 'Capacitor', 10, 12.00),
(32, 31, 58, 'Caixa ferramenta', 2, 5.50),
(33, 31, 57, 'Alicate', 2, 10.00),
(34, 32, 57, 'Alicate', 10, 153.99),
(35, 32, 58, 'Caixa ferramenta', 10, 15.84),
(36, 33, 57, 'Alicate', 10, 15.99),
(37, 33, 58, 'Caixa ferramenta', 2, 20.99),
(38, 34, 57, 'Alicate', 10, 15.99),
(39, 35, 58, 'Caixa ferramenta', 1, 1.00),
(40, 35, 58, 'Caixa ferramenta', 2, 2.00),
(41, 36, 62, 'Capacitor', 10, 140.00),
(42, 36, 57, 'Alicate', 1, 15.99),
(43, 37, 57, 'Alicate', 1, 15.10),
(44, 37, 62, 'Capacitor', 12, 15.50),
(45, 37, 58, 'Caixa ferramenta', 12, 12.99),
(46, 38, 57, 'Alicate', 1, 1.00),
(47, 38, 58, 'Caixa ferramenta', 2, 2.00),
(48, 41, 57, 'Alicate', 9, 10.00),
(49, 42, 58, 'Caixa ferramenta', 9, 13.99),
(50, 42, 62, 'Capacitor', 15, 10.58),
(51, 43, 57, 'Alicate', 10, 100.00),
(52, 44, 58, 'Caixa ferramenta', 10, 199.90),
(53, 45, 57, 'Alicate', 1, 10.00),
(54, 45, 58, 'Caixa ferramenta', 1, 1.00),
(55, 46, 57, 'Alicate', 12, 15.99),
(56, 47, 57, 'Alicate', 77, 10.00),
(57, 49, 57, 'Alicate', 1, 10.00),
(58, 49, 62, 'Capacitor', 2, 20.00),
(59, 50, 57, 'Alicate', 10, 10.00),
(60, 50, 58, 'Caixa ferramenta', 10, 10.00),
(61, 51, 57, 'Alicate', 10, 15.00),
(62, 54, 57, 'Alicate', 10, 159.00),
(63, 54, 62, 'Capacitor', 15, 99.50),
(64, 57, 57, 'Alicate', 10, 115.00),
(65, 57, 62, 'Capacitor', 10, 15.00),
(66, 58, 58, 'Caixa ferramenta', 10, 15.99),
(67, 59, 57, 'Alicate', 1, 2.00),
(68, 60, 57, 'Alicate', 1, 1.00),
(69, 61, 57, 'Alicate', 2, 10.00),
(70, 61, 58, 'Caixa ferramenta', 69, 2.55),
(71, 62, 57, 'Alicate', 1, 1.00),
(72, 63, 62, 'Capacitor', 37, 15.00),
(73, 64, 62, 'Capacitor', 16, 1.00),
(74, 65, 57, 'Alicate', 10, 10.00),
(75, 66, 57, 'Alicate', 2, 2.00),
(76, 67, 57, 'Alicate', 1, 1.00),
(77, 68, 57, 'Alicate', 1, 1.00),
(78, 69, 57, 'Alicate', 1, 1.00),
(79, 70, 57, 'Alicate', 6, 1.00),
(80, 71, 63, 'Iphone XR 64GB', 2, 1800.00),
(81, 72, 62, 'Capacitor', 10, 15.00),
(82, 72, 57, 'Alicate', 20, 10.00),
(83, 73, 64, 'Monitor PCFORT', 10, 15.00),
(84, 73, 65, 'Feijão Preto', 10, 20.99),
(85, 74, 62, 'Capacitor', 10, 10.00),
(86, 77, 57, 'Alicate', 109, 10.00),
(87, 78, 57, 'Alicate', 109, 10.00),
(88, 80, 62, 'Capacitor', 10, 10.00),
(89, 81, 57, 'Alicate', 2, 1.00),
(90, 82, 57, 'Alicate', 8, 15.88),
(91, 82, 66, 'Arroz', 20, 15.99),
(92, 83, 57, 'Alicate', 10, 20.00),
(93, 83, 63, 'Iphone XR 64GB', 1, 500.00),
(94, 83, 66, 'Arroz', 10, 20.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido_compra`
--

CREATE TABLE `itens_pedido_compra` (
  `id` int(11) NOT NULL,
  `codigo_pedido` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `nome_produto` varchar(100) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_pedido_compra`
--

INSERT INTO `itens_pedido_compra` (`id`, `codigo_pedido`, `produto_id`, `nome_produto`, `quantidade`, `valor_unitario`) VALUES
(50, 36, 57, 'Alicate', 10, 100.00),
(51, 36, 66, 'Arroz', 10, 100.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `idMensagem` int(5) NOT NULL,
  `mensagem` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `mensagem`
--

INSERT INTO `mensagem` (`idMensagem`, `mensagem`) VALUES
(1, 'kjkkkkkkkkkkk'),
(2, 'mkkkkkkkkkkkkkkkkkkk'),
(3, 'teste'),
(4, 'oi'),
(5, 'Teste'),
(6, 'Teste'),
(7, 'João');

-- --------------------------------------------------------

--
-- Estrutura para tabela `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `timestamp`, `username`) VALUES
(58, 2, 49, 'Bom dia', '2024-06-17 14:10:16', 'João'),
(59, 49, 2, 'Bom dia', '2024-06-17 14:10:22', 'Admin'),
(60, 2, 49, 'teste', '2024-06-17 14:14:03', 'João'),
(61, 2, 49, 'Pica', '2024-06-17 16:11:53', 'João'),
(62, 49, 2, 'Oi', '2024-06-17 16:11:58', 'Admin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordem_servico`
--

CREATE TABLE `ordem_servico` (
  `idOs` int(5) NOT NULL,
  `responsavel` varchar(150) NOT NULL,
  `descricaoOs` varchar(500) NOT NULL,
  `data_cadastroOs` datetime NOT NULL,
  `data_inicioOs` varchar(35) NOT NULL,
  `data_terminoOs` varchar(35) DEFAULT NULL,
  `valorOs` varchar(15) DEFAULT NULL,
  `tipoOs` varchar(150) NOT NULL,
  `statusOs` varchar(150) NOT NULL,
  `status` char(1) NOT NULL,
  `clienteOs` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ordem_servico`
--

INSERT INTO `ordem_servico` (`idOs`, `responsavel`, `descricaoOs`, `data_cadastroOs`, `data_inicioOs`, `data_terminoOs`, `valorOs`, `tipoOs`, `statusOs`, `status`, `clienteOs`) VALUES
(11, 'João', 'Manutenção de equipamento', '2023-11-06 19:44:02', '2023-11-06', '2023-11-08', '160.00', 'Manutenção', 'Andamento', 'F', 'llll'),
(14, 'Jorge', 'o trem bala', '2024-03-19 20:41:38', '2024-04-02', '2024-03-19', '150.66', 'Instalação', 'Inicio', 'A', 'Consumidor Final'),
(16, 'Liss', 'Ajuste', '2024-06-04 10:19:53', '2025-01-01', NULL, '2000', 'João Pedro Gomes', 'Analise', 'A', 'Consumidor Final'),
(17, 'João', 'oi', '2024-06-04 10:34:52', '2024-05-30', NULL, '15', 'Instalação', 'Analise', 'A', 'Consumidor Final');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `codigo_pedido` int(11) NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `responsavel_pedido` varchar(150) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `data` date NOT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `pago` char(1) DEFAULT NULL,
  `banco_receb` varchar(45) DEFAULT NULL,
  `fm_pag` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`codigo_pedido`, `nome_cliente`, `responsavel_pedido`, `observacoes`, `valor_total`, `data`, `deletado`, `id_reg_delet`, `pago`, `banco_receb`, `fm_pag`) VALUES
(71, 'João', 'Jorge', 'Oi', 100.00, '2024-03-27', 'S', 2, 'S', 'Caixa', 'A prazo'),
(73, 'Consumidor Final', 'João', 'Feijão e Monitor kkkkkkkkk', 10.00, '2024-02-01', 'S', 2, 'N', 'Caixa', 'A prazo'),
(74, 'Consumidor Final', 'João', 'teste', 100.00, '2024-02-01', 'S', 2, 'N', 'Caixa', 'A prazo'),
(77, 'Consumidor Final', 'Teste', 'oi', 1090.00, '2024-02-01', 'S', 2, 'N', NULL, NULL),
(78, 'João', 'Jorge', 'teste', 1090.00, '2024-02-01', 'S', 2, 'N', NULL, NULL),
(80, 'João', 'Jorge', 'Jp', 100.00, '2025-02-01', 'N', 0, 'N', 'Cofre', 'A prazo'),
(81, 'Consumidor Final', 'João', 'das', 2.00, '2024-04-28', 'S', 2, 'N', NULL, NULL),
(82, 'João', 'NEY', 'Teste', 446.84, '2024-06-01', 'S', 2, 'S', 'Caixa', 'Pix'),
(83, 'João', 'Jorge', 'Foi pago nada nesse caralho puta que pariu\r\n', 900.00, '2024-06-10', 'N', 0, 'S', 'Caixa', 'A prazo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido_compra`
--

CREATE TABLE `pedido_compra` (
  `codigo_pedido` int(11) NOT NULL,
  `nome_fornecedor` varchar(100) DEFAULT NULL,
  `responsavel_pedido` varchar(100) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(11) DEFAULT NULL,
  `pago` char(1) DEFAULT NULL,
  `banco_receb` varchar(45) DEFAULT NULL,
  `fm_pag` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedido_compra`
--

INSERT INTO `pedido_compra` (`codigo_pedido`, `nome_fornecedor`, `responsavel_pedido`, `observacoes`, `valor_total`, `data`, `deletado`, `id_reg_delet`, `pago`, `banco_receb`, `fm_pag`) VALUES
(36, 'ProControl', 'João', 'Valor', 20.00, '2024-06-14', 'N', 0, 'S', 'Caixa', 'A prazo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `saida`
--

CREATE TABLE `saida` (
  `id` int(15) NOT NULL,
  `quantos` varchar(255) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `fmpag` varchar(150) NOT NULL,
  `responsavel` varchar(150) NOT NULL,
  `data` date DEFAULT NULL,
  `datareg` datetime DEFAULT NULL,
  `id_reg` int(5) NOT NULL,
  `nomeBanco` varchar(150) NOT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `deletado` char(1) NOT NULL,
  `id_reg_edit` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `saida`
--

INSERT INTO `saida` (`id`, `quantos`, `descricao`, `fmpag`, `responsavel`, `data`, `datareg`, `id_reg`, `nomeBanco`, `id_reg_delet`, `deletado`, `id_reg_edit`) VALUES
(24, '10.87', 'Frete', 'Pix', 'João', '2024-01-15', '2024-01-15 14:47:46', 1, 'Banco do Brasil', 2, 'S', 1),
(25, '135.25', 'Pagamento', 'Pix', 'João', '2024-01-15', '2024-01-18 00:32:13', 1, 'Banco do Brasil', 2, 'S', 1),
(26, '10.88', 'teste', 'teste', 'João', '2024-01-10', '2024-01-18 01:06:56', 1, 'Banco do Brasil', 2, 'S', 1),
(27, '150.25', 'Pagamento do Carro', 'Pix', 'João', '2024-02-01', '2024-01-26 15:19:12', 2, 'Caixa', 0, 'N', 2),
(28, '10', 'TesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTeste', 'Pix', 'João', '2025-04-02', '2024-06-06 00:46:21', 2, 'Caixa', 2, 'S', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `secao`
--

CREATE TABLE `secao` (
  `idSecao` int(5) NOT NULL,
  `nomeSecao` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `secao`
--

INSERT INTO `secao` (`idSecao`, `nomeSecao`) VALUES
(1, 'teste');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_preco`
--

CREATE TABLE `tbl_preco` (
  `id_tblpreco` int(5) NOT NULL,
  `nome_tbl` varchar(250) NOT NULL,
  `preco_tbl` varchar(100) NOT NULL,
  `descricao_tbl` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_preco`
--

INSERT INTO `tbl_preco` (`id_tblpreco`, `nome_tbl`, `preco_tbl`, `descricao_tbl`) VALUES
(4, 'Corte de Cabelo', '35,00', 'Corte de Cabelo Masculino Navalhado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_servico`
--

CREATE TABLE `tipo_servico` (
  `idServico` int(5) NOT NULL,
  `nomeServico` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipo_servico`
--

INSERT INTO `tipo_servico` (`idServico`, `nomeServico`) VALUES
(1, 'Manutenção');

-- --------------------------------------------------------

--
-- Estrutura para tabela `transportes`
--

CREATE TABLE `transportes` (
  `id` int(11) NOT NULL,
  `pedido_id` varchar(11) NOT NULL,
  `tipo_pedido` enum('Compra','Venda') NOT NULL,
  `valor_transporte` decimal(10,2) NOT NULL,
  `veiculo_placa` varchar(20) NOT NULL,
  `data_transporte` date DEFAULT NULL,
  `data_cadastro_transporte` timestamp NOT NULL DEFAULT current_timestamp(),
  `deletado` char(1) NOT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `Concluido` enum('Em rota','Concluido') NOT NULL DEFAULT 'Em rota'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `transportes`
--

INSERT INTO `transportes` (`id`, `pedido_id`, `tipo_pedido`, `valor_transporte`, `veiculo_placa`, `data_transporte`, `data_cadastro_transporte`, `deletado`, `id_reg_delet`, `Concluido`) VALUES
(2, '5', 'Compra', 16.00, 'ABC-1234', '2024-02-14', '2024-02-21 16:09:00', 'n', 2, 'Concluido'),
(5, '9', 'Venda', 9.00, 'ABC-1234', '2024-02-01', '2024-02-21 19:29:00', 'N', 0, 'Em rota'),
(6, '99', 'Venda', 159.99, 'ABC-1234', '2024-02-01', '2024-02-28 16:10:00', 'S', 2, 'Concluido'),
(7, '99', 'Venda', 159.99, 'ABC-1234', '0000-00-00', '2024-02-28 16:10:00', 'S', 2, 'Concluido');

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
  `cpfUsuario` varchar(15) NOT NULL,
  `Setor` varchar(70) DEFAULT NULL,
  `Online` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Nome`, `Sobrenome`, `Email`, `Senha`, `NivelUsuario`, `Status`, `telefoneUsuario`, `cpfUsuario`, `Setor`, `Online`) VALUES
(2, 'João', 'Pedro', 'joao@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 'Ativo', '+55 (35) 8468-7649', '139.527.326-06', NULL, 0),
(43, 'Jorge', 'Lenda', 'jorge@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 'Ativo', '+55 (35) 8468-7644', '121.354.645-42', NULL, 0),
(49, 'Admin', 'Pedro', 'joaop@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 'Ativo', '553584', '139527326', 'Admnistração', 0),
(50, 'dasd', 'asdasdsa', 'jao', '123', 1, 'Ativo', '11', '11', 'teste', 0),
(51, 'kjsdkjas', 'daskjd', 'kdjaks', '123', 1, 'Ativo', 'a', '1', 'dasd', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `id` int(11) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `chassi` varchar(100) DEFAULT NULL,
  `placa` varchar(20) DEFAULT NULL,
  `valor_aquisicao` varchar(35) DEFAULT NULL,
  `data_aquisicao` date DEFAULT NULL,
  `responsavel` varchar(100) DEFAULT NULL,
  `localizacao` varchar(100) DEFAULT NULL,
  `quilometragem` int(11) DEFAULT NULL,
  `condicao` enum('bom','regular','precisa de reparos') DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `veiculos`
--

INSERT INTO `veiculos` (`id`, `marca`, `modelo`, `ano`, `cor`, `chassi`, `placa`, `valor_aquisicao`, `data_aquisicao`, `responsavel`, `localizacao`, `quilometragem`, `condicao`, `data_criacao`, `data_atualizacao`) VALUES
(9, 'BMW', 'X6', 2022, 'Azul', '749 Y7maU0 99 Az3652', 'ABC-1234', '365.475,00', '2024-01-02', 'João', 'São Paulo', 15, 'bom', '2024-02-12 14:35:07', '2024-02-22 02:09:49');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`idAgenda`);

--
-- Índices de tabela `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`idBanco`);

--
-- Índices de tabela `boletos`
--
ALTER TABLE `boletos`
  ADD PRIMARY KEY (`id_boleto`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Índices de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD PRIMARY KEY (`id_Contaspagar`);

--
-- Índices de tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  ADD PRIMARY KEY (`id_Contasreceber`);

--
-- Índices de tabela `duvida`
--
ALTER TABLE `duvida`
  ADD PRIMARY KEY (`idDuvida`);

--
-- Índices de tabela `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`IdProduto`);

--
-- Índices de tabela `fm_pag`
--
ALTER TABLE `fm_pag`
  ADD PRIMARY KEY (`id_fmpag`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`IdFornecedor`);

--
-- Índices de tabela `imagens`
--
ALTER TABLE `imagens`
  ADD PRIMARY KEY (`id_imagem`);

--
-- Índices de tabela `importaxml`
--
ALTER TABLE `importaxml`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `informacoes`
--
ALTER TABLE `informacoes`
  ADD PRIMARY KEY (`id_info`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `itens_pedido_compra`
--
ALTER TABLE `itens_pedido_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codigo_pedido` (`codigo_pedido`);

--
-- Índices de tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`idMensagem`);

--
-- Índices de tabela `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ordem_servico`
--
ALTER TABLE `ordem_servico`
  ADD PRIMARY KEY (`idOs`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`codigo_pedido`);

--
-- Índices de tabela `pedido_compra`
--
ALTER TABLE `pedido_compra`
  ADD PRIMARY KEY (`codigo_pedido`);

--
-- Índices de tabela `saida`
--
ALTER TABLE `saida`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `secao`
--
ALTER TABLE `secao`
  ADD PRIMARY KEY (`idSecao`);

--
-- Índices de tabela `tbl_preco`
--
ALTER TABLE `tbl_preco`
  ADD PRIMARY KEY (`id_tblpreco`);

--
-- Índices de tabela `tipo_servico`
--
ALTER TABLE `tipo_servico`
  ADD PRIMARY KEY (`idServico`);

--
-- Índices de tabela `transportes`
--
ALTER TABLE `transportes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- Índices de tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chassi` (`chassi`),
  ADD UNIQUE KEY `placa` (`placa`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `idAgenda` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de tabela `banco`
--
ALTER TABLE `banco`
  MODIFY `idBanco` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `boletos`
--
ALTER TABLE `boletos`
  MODIFY `id_boleto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `IdCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  MODIFY `id_Contaspagar` int(36) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  MODIFY `id_Contasreceber` int(36) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `duvida`
--
ALTER TABLE `duvida`
  MODIFY `idDuvida` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `IdProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `fm_pag`
--
ALTER TABLE `fm_pag`
  MODIFY `id_fmpag` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `IdFornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id_imagem` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `importaxml`
--
ALTER TABLE `importaxml`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `informacoes`
--
ALTER TABLE `informacoes`
  MODIFY `id_info` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT de tabela `itens_pedido_compra`
--
ALTER TABLE `itens_pedido_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `idMensagem` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `ordem_servico`
--
ALTER TABLE `ordem_servico`
  MODIFY `idOs` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `codigo_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de tabela `pedido_compra`
--
ALTER TABLE `pedido_compra`
  MODIFY `codigo_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `saida`
--
ALTER TABLE `saida`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `secao`
--
ALTER TABLE `secao`
  MODIFY `idSecao` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbl_preco`
--
ALTER TABLE `tbl_preco`
  MODIFY `id_tblpreco` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tipo_servico`
--
ALTER TABLE `tipo_servico`
  MODIFY `idServico` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `transportes`
--
ALTER TABLE `transportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de tabela `veiculos`
--
ALTER TABLE `veiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `itens_pedido_compra`
--
ALTER TABLE `itens_pedido_compra`
  ADD CONSTRAINT `itens_pedido_compra_ibfk_1` FOREIGN KEY (`codigo_pedido`) REFERENCES `pedido_compra` (`codigo_pedido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
