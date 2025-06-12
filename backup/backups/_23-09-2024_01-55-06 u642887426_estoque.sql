CREATE DATABASE `u642887426_estoque` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

CREATE TABLE `agenda` (
  `idAgenda` int(5) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `data` date NOT NULL,
  `descricao` varchar(1500) NOT NULL,
  `nivelAprov` varchar(15) NOT NULL,
  `telAgenda` varchar(25) NOT NULL,
  `resp` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idAgenda`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO agenda (idAgenda, titulo, data, descricao, nivelAprov, telAgenda, resp) VALUES ('135', 'ajuste de equipamento', '2024-09-01', 'agendamento', '1', '+55 (35) 8468-7649', '2'), ('136', 'teste', '2024-05-01', 'teste', '1', '+55 (11) 1111-1111', '2'), ('137', 'teste', '2025-01-01', 'teste', '1', '+55 (11) 1111-1111', '2');

CREATE TABLE `banco` (
  `idBanco` int(5) NOT NULL AUTO_INCREMENT,
  `nomeBanco` varchar(150) NOT NULL,
  `agencia` varchar(20) NOT NULL,
  `cc` varchar(50) NOT NULL,
  `valor_banco` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idBanco`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO banco (idBanco, nomeBanco, agencia, cc, valor_banco) VALUES ('1', 'Cofre', '2322', '12121-5', '100.00'), ('2', 'Caixa', '1212', '12121-2', '186.84');

CREATE TABLE `boletos` (
  `id_boleto` int(11) NOT NULL AUTO_INCREMENT,
  `numero_boleto` varchar(20) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_emissao` date NOT NULL,
  `data_vencimento` date NOT NULL,
  `beneficiario` varchar(100) NOT NULL,
  `pagador_nome` varchar(100) NOT NULL,
  `pagador_cpf` varchar(25) NOT NULL,
  `status_pagamento` varchar(20) DEFAULT NULL,
  `deletado` char(1) NOT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `arquivo_boleto` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_boleto`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO boletos (id_boleto, numero_boleto, valor, data_emissao, data_vencimento, beneficiario, pagador_nome, pagador_cpf, status_pagamento, deletado, id_reg_delet, arquivo_boleto) VALUES ('9', '350705993', '185.91', '2024-08-08', '2024-08-15', 'UNOPAR', 'João Pedro', '139.527.326-05', 'Pago', 'N', '', '66b6223c84f65.pdf');

CREATE TABLE `categoria` (
  `IdCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  PRIMARY KEY (`IdCategoria`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO categoria (IdCategoria, Nome) VALUES ('14', 'Direto'), ('17', 'Alimento'), ('25', 'Roupas de Frio'), ('24', 'Roupas'), ('26', 'Ferramenta'), ('27', 'Informática');

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nomeCliente` varchar(150) NOT NULL,
  `numeroCliente` varchar(150) NOT NULL,
  `emailCliente` varchar(150) NOT NULL,
  `cepCliente` varchar(15) NOT NULL,
  `cpfCliente` varchar(20) NOT NULL,
  `respCliente` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO cliente (idCliente, nomeCliente, numeroCliente, emailCliente, cepCliente, cpfCliente, respCliente) VALUES ('21', 'João ', '+55 (35) 9967-7580', 'contat.joao10@gmail.com', '37504-500', '139.527.326-06', 'Jorge'), ('23', 'Consumidor Final', '', 'null', '', '', '.');

CREATE TABLE `contas_pagar` (
  `id_Contaspagar` int(36) NOT NULL AUTO_INCREMENT,
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
  `cliente` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_Contaspagar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `contas_receber` (
  `id_Contasreceber` int(36) NOT NULL AUTO_INCREMENT,
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
  `cliente` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_Contasreceber`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `duvida` (
  `idDuvida` int(5) NOT NULL AUTO_INCREMENT,
  `descDuv` varchar(500) NOT NULL,
  `emailDuv` varchar(40) NOT NULL,
  `dataDuv` varchar(20) NOT NULL,
  PRIMARY KEY (`idDuvida`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO duvida (idDuvida, descDuv, emailDuv, dataDuv) VALUES ('1', 'O que é arroz', 'arroz é sla oq', '2023-09-15 14:29:10');

CREATE TABLE `emails_enviados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `destinatario` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `anexo_nome` varchar(255) DEFAULT NULL,
  `anexo_tipo` varchar(255) DEFAULT NULL,
  `anexo_conteudo` longblob DEFAULT NULL,
  `data_envio` datetime NOT NULL,
  `anexo_caminho` varchar(255) DEFAULT NULL,
  `visualizar` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO emails_enviados (id, nome, email, destinatario, mensagem, anexo_nome, anexo_tipo, anexo_conteudo, data_envio, anexo_caminho, visualizar) VALUES ('17', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'test', 'e8cf79ea617df106_pedido_compra.pdf', 'application/pdf', '', '2024-07-22 14:07:27', 'anexo_email/e8cf79ea617df106_pedido_compra.pdf', 'n'), ('18', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'opa', '0de1d2244b0727f2_IMG_7980.jpeg', 'image/jpeg', '', '2024-07-22 14:14:05', 'anexo_email/0de1d2244b0727f2_IMG_7980.jpeg', 'n'), ('19', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste', '1e64d3e878e73cc5_jess i eu.mp4', 'video/mp4', '', '2024-07-24 11:58:05', 'anexo_email/1e64d3e878e73cc5_jess i eu.mp4', 'n'), ('20', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste', '31722f97609f8766_default.jpg', 'image/jpeg', '', '2024-07-29 15:34:54', 'anexo_email/31722f97609f8766_default.jpg', 'n'), ('21', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste2', 'fc61a3e2b8e4ff8b_669fad8d56dec.jpg', 'image/jpeg', '', '2024-07-29 15:35:57', 'anexo_email/fc61a3e2b8e4ff8b_669fad8d56dec.jpg', 'n'), ('22', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'nao sei o que é', 'c110a43be5ee7165_14-13_BR1-2960795262_02.mp4', 'video/mp4', '', '2024-07-30 17:12:11', 'anexo_email/c110a43be5ee7165_14-13_BR1-2960795262_02.mp4', 'n'), ('23', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste hoje', '9a2700768262ffc4_boleto unopar.pdf', 'application/pdf', '', '2024-08-09 00:15:51', 'anexo_email/9a2700768262ffc4_boleto unopar.pdf', 'n'), ('24', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste jp', 'ec2de4651af541e3_pedido_compra.pdf', 'application/pdf', '', '2024-08-14 00:22:36', 'anexo_email/ec2de4651af541e3_pedido_compra.pdf', 'n'), ('25', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste 2 min', '3421dc53e1e71be9_boleto unopar.pdf', 'application/pdf', '', '2024-08-09 00:27:48', 'anexo_email/3421dc53e1e71be9_boleto unopar.pdf', 'n'), ('26', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', '12', 'd1ccfbe93ed2e8c1_Suporte Universal Notebook Regulável Ergonômico Reliza Nr17.pdf', 'application/pdf', '', '2024-08-09 00:30:34', 'anexo_email/d1ccfbe93ed2e8c1_Suporte Universal Notebook Regulável Ergonômico Reliza Nr17.pdf', 'n'), ('27', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste111111', 'bcb06bb38857dfd1_Suporte Universal Notebook Regulável Ergonômico Reliza Nr17.pdf', 'application/pdf', '', '2024-08-09 00:32:49', 'anexo_email/bcb06bb38857dfd1_Suporte Universal Notebook Regulável Ergonômico Reliza Nr17.pdf', 'n'), ('28', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste123', 'b6ada7793266205b_boleto unopar.pdf', 'application/pdf', '', '2024-08-07 00:39:23', 'anexo_email/b6ada7793266205b_boleto unopar.pdf', 'n'), ('29', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste12', '0f8069f4fb83890e_produtos.pdf', 'application/pdf', '', '2024-08-09 09:55:18', 'anexo_email/0f8069f4fb83890e_produtos.pdf', 'n'), ('30', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', '123456', '3f6aad7f6711ab44_109672.jpg', 'image/jpeg', '', '2024-08-19 12:08:50', 'anexo_email/3f6aad7f6711ab44_109672.jpg', 'n'), ('31', 'João Pedro', 'procontrol.contat@gmail.com', 'joape@tecard.net.br', '123teste', '3b950eacba5eb295_GUIA ENTRADA FISCAL.pdf', 'application/pdf', '', '2024-08-22 15:54:44', 'anexo_email/3b950eacba5eb295_GUIA ENTRADA FISCAL.pdf', 'n'), ('32', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'Curriculo sidney', 'c005938023b8670e_CVSIDNEY.pdf', 'application/pdf', '', '2024-09-17 19:52:20', 'anexo_email/c005938023b8670e_CVSIDNEY.pdf', 'n'), ('33', 'João Pedro', 'procontrol.contat@gmail.com', 'contat.joao10@gmail.com', 'teste email', 'fa193c88dfcac6bc_usuario.sql', 'application/octet-stream', '', '2024-09-23 01:52:54', 'anexo_email/fa193c88dfcac6bc_usuario.sql', 's');

CREATE TABLE `entrada` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
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
  `id_reg_delet` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO entrada (id, quantos, descricao, fmpag, responsavel, data, datareg, nome, nomeBanco, id_reg, id_reg_edit, deletado, id_reg_delet) VALUES ('1', '1100', 'entrada', 'Pix', 'João Pedro', '2024-08-06', '2024-08-09 03:57:12', 'João', 'Caixa', '2', '2', 'N', '');

CREATE TABLE `estoque` (
  `IdProduto` int(11) NOT NULL AUTO_INCREMENT,
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
  `localEstoq` varchar(150) DEFAULT NULL,
  `img_prod` varchar(150) DEFAULT NULL,
  `catalogo` enum('s','n') NOT NULL DEFAULT 'n',
  `promocao` char(1) DEFAULT 'N',
  PRIMARY KEY (`IdProduto`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO estoque (IdProduto, Numero, Nome, precovenda, Quantidade, Categoria, Fornecedor, descProd, vencProd, unidade_estoque, peso, precoPromocional, status_prod, preco_custo, preco_bruto, qntVendas, deletado, id_reg_delet, localEstoq, img_prod, catalogo, promocao) VALUES ('57', '1642', 'Alicate', '200', '30', 'Ferramenta', 'Fornecedor', 'Alicate de bico', '2024-02-10', 'Unidade', '2', '150.99', 'Disponível', '15', '180,55', '16', 'n', '2', 'Local 3', 'upload-prod/669fad8d56dec.jpg', 's', 's'), ('63', '133', 'Iphone XR 64GB', '1200', '10', 'Informática', 'ProControl', 'Vermelho, 88% de Vida na bateria', '', 'UN', '0,194', '1000', 'Disponível', '1000', '1850', '3', 'N', '', 'Local 2', 'upload-prod/669fad9b3aa39.jpg', 's', 'n'), ('62', '153', 'Resistência', '29.99', '10', 'Ferramenta', 'ProControl', 'Resistência de chuveiro', '2024-02-29', 'UN', '20', '15.99', 'Disponível', '109,50', '129,52', '8', 'N', '', '351', 'upload-prod/669fada1ebe58.jpg', 's', 'n'), ('64', '150', 'Monitor PCFORT', '880.99', '20', 'Informática', 'ProControl', 'Preto, HDMI e VGA, 1920x1080.', '', 'UN', '1', '590', 'Disponivel', '10', '', '5', 'N', '2', 'Local 1', 'upload-prod/669fadc0bb223.jpg', 's', 's'), ('65', '157', 'Feijão Preto', '1.00', '10', 'Direto', 'ProControl', 'Feijão Preto', '2004-04-02', 'Pacote', '2', '15,99', 'Disponivel', '15,00', '19,00', '0', 'S', '2', 'Área G', '', 's', 'N'), ('66', '150', 'Arroz', '1.00', '10', 'Direto', 'ProControl', 'Preto', '2024-04-08', 'UN', '', '', 'Disponivel', '', '', '2', 'S', '2', '', 'upload-prod/baixados (2).jpg', 's', 'N'), ('68', '600', 'Camiseta preta ', '29.00', '20', 'Roupas', 'ProControl', 'Camisa preta básica ', '', 'CX', '', '20,00', 'OK', '15', '', '5', 'N', '', '', 'upload-prod/66a7c7b48951b.jpg', 's', 's'), ('69', 'teste', 'Casa', '1.00', '10', 'Alimento', 'ProControl', 'frio', '', 'UN', '', '', 'OK', '', '', '', 'S', '2', '', 'upload-prod/669fac2b9be87.jpg', 's', 'N'), ('70', '3598', 'Neosoro', '5.99', '20', 'Direto', 'ProControl', 'Cloridrato de nafazolina 0,5mg/mL Uso nasal Conteúdo 30mL', '2026-08-02', 'UN', '10G ', '3.99', 'Em Uso', '15', '4.99', '1', 'N', '', 'Área 51', 'upload-prod/66b98622db975_neosoro.jpg', 's', 's');

CREATE TABLE `fm_pag` (
  `id_fmpag` int(5) NOT NULL AUTO_INCREMENT,
  `nome_fmpag` varchar(100) DEFAULT NULL,
  `banco_vinculado` varchar(45) DEFAULT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `id_reg_edit` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_fmpag`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO fm_pag (id_fmpag, nome_fmpag, banco_vinculado, deletado, id_reg_delet, id_reg_edit) VALUES ('3', 'Pix ', 'Caixa', 'N', '2', '2'), ('6', 'Teste', 'Caixa', 'S', '2', '2'), ('7', 'teste', '', 'S', '2', '0'), ('8', 'A prazo', 'Cofre', 'N', '', '2'), ('9', 'Cartão crédito', '', 'N', '', '');

CREATE TABLE `fornecedor` (
  `IdFornecedor` int(11) NOT NULL AUTO_INCREMENT,
  `nomeForn` varchar(150) NOT NULL,
  `cnpjForn` varchar(20) NOT NULL,
  `telefoneForn` varchar(25) NOT NULL,
  `cepForn` varchar(15) NOT NULL,
  `emailForn` varchar(150) NOT NULL,
  `cod_Forn` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`IdFornecedor`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO fornecedor (IdFornecedor, nomeForn, cnpjForn, telefoneForn, cepForn, emailForn, cod_Forn) VALUES ('14', 'ProControl', '21.221.312/0001-24', '+55 (35) 8468-7649', '37504-500', 'contat.joao10@gmail.com', '9073123'), ('17', 'Fornecedor', '00.000.000/0000-00', '+55 (35) 8888-8888', '', 'fornecedor@email.com', '');

CREATE TABLE `imagens` (
  `id_imagem` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`id_imagem`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO imagens (id_imagem, nome) VALUES ('26', 'IMG_3487.jpg'), ('27', 'fof.jpeg'), ('28', '8f2d4c23-75f7-4bbc-802c-65f2f08c2b7.jpeg'), ('29', 'e2bb3d37-37c6-4b66-8068-bb3547d08aea.jpeg'), ('30', 'procontrol.png'), ('31', 'ping.jpeg'), ('32', 'procontrol.png'), ('33', '8f2d4c23-75f7-4bbc-802c-65f2f08c2b78.jpeg'), ('34', 'ping.jpeg'), ('35', 'procontrol.png'), ('36', 'limpeza.png'), ('37', 'e2bb3d37-37c6-4b66-8068-bb3547d08aea.jpeg'), ('38', 'fof.jpeg'), ('39', 'gojo.jpg'), ('40', 'Chainsaw man (Denji) Ft_ The Weeknd [Starboy].jpg'), ('41', 'anime-girl-chilling-at-balcony-4k-de-1910x1075.jpg'), ('42', 'baixados.jpg'), ('43', 'gojo.jpg'), ('44', 'frieren-beyond-journey-s-end-oc-1910x1075.jpg'), ('45', 'fund.jpg'), ('46', '2638464.jpg'), ('47', 'IMG_5288.jpeg'), ('48', 'Procontrol.png');

CREATE TABLE `importaxml` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `cnpjFornecedor` varchar(20) DEFAULT NULL,
  `nomeDestinatario` varchar(255) DEFAULT NULL,
  `cnpjDestinatario` varchar(20) DEFAULT NULL,
  `modalidadeFrete` varchar(1) DEFAULT NULL,
  `placaVeiculo` varchar(10) DEFAULT NULL,
  `nomeTransportadora` varchar(255) DEFAULT NULL,
  `pesoBruto` decimal(10,3) DEFAULT NULL,
  `pesoLiquido` decimal(10,3) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT NULL,
  `valorFrete` decimal(10,2) DEFAULT NULL,
  `naturezaOperacao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO importaxml (id, numeroNF, chaveAcesso, valorTotal, valorICMS, valorIPI, valorPIS, valorCOFINS, cfop, unidadeMedida, xmlFilePath, nomeFornecedor, cnpjFornecedor, nomeDestinatario, cnpjDestinatario, modalidadeFrete, placaVeiculo, nomeTransportadora, pesoBruto, pesoLiquido, desconto, valorFrete, naturezaOperacao) VALUES ('13', '83', '31240754243122000138650010000000831000053839', '526.40', '0.00', '0.00', '0.00', '0.00', '1556', 'UN', 'xml/nf_83.xml', 'PRIME MODA FITNESS LTDA', '54243122000138', '', '', '9', '', '', '', '', '0.00', '0.00', 'VENDA'), ('15', '6997', '31230804641376000489550010000069971000069984', '29.49', '2.44', '0.00', '0.00', '0.00', '1556', 'PT', 'xml/nf_6997.xml', 'SUPERMERCADOS BH COMERCIO DE ALIMENTOS S/A', '04641376000489', 'ASSOCIACAO DE ARTIGOS CAES E GATOS LTDA', '07804633000100', '1', '', '', '8.700', '8.600', '0.00', '0.00', 'DEVOLUCAO MERCADORIA');

CREATE TABLE `informacoes` (
  `id_info` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(25) NOT NULL,
  `rua` varchar(150) NOT NULL,
  `cep` varchar(150) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `bairro` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_info`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO informacoes (id_info, nome, cnpj, email, telefone, rua, cep, cidade, bairro) VALUES ('13', 'ProControl', '28.230.375/0001-67', 'procontrol.contat@gmail.com', '(35) 98468-7649', 'Rua Augusto de souza cardoso', '37504-500', 'Itajubá', 'Jardim das Palmeiras');

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_pedido` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `nome_produto` varchar(200) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO itens_pedido (id, codigo_pedido, produto_id, nome_produto, quantidade, valor_unitario) VALUES ('1', '1', '57', 'Alicate', '1', '150.00'), ('2', '2', '57', 'Alicate', '1', '15.99'), ('3', '3', '68', 'Camiseta preta ', '20', '10.50'), ('4', '3', '63', 'Iphone XR 64GB', '10', '1000.00'), ('5', '4', '64', 'Monitor PCFORT', '10', '880.00'), ('6', '5', '70', 'Neosoro', '5', '3.99'), ('7', '6', '57', 'Alicate', '10', '20.00'), ('8', '7', '68', 'Camiseta preta ', '20', '40.00'), ('9', '8', '64', 'Monitor PCFORT', '5', '10.00'), ('10', '9', '57', 'Alicate', '10', '15.00'), ('11', '10', '62', 'Resistência', '90', '15.00'), ('12', '11', '57', 'Alicate', '5', '1.00'), ('13', '12', '57', 'Alicate', '5', '10.00'), ('14', '13', '68', 'Camiseta preta ', '1', '1.00'), ('15', '14', '57', 'Alicate', '10', '10.00'), ('16', '14', '68', 'Camiseta preta ', '1', '10.00'), ('17', '15', '68', 'Camiseta preta ', '1', '10.00');

CREATE TABLE `itens_pedido_compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_pedido` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `nome_produto` varchar(100) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `codigo_pedido` (`codigo_pedido`),
  CONSTRAINT `itens_pedido_compra_ibfk_1` FOREIGN KEY (`codigo_pedido`) REFERENCES `pedido_compra` (`codigo_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO itens_pedido_compra (id, codigo_pedido, produto_id, nome_produto, quantidade, valor_unitario) VALUES ('1', '38', '57', 'Alicate', '1', '10.00'), ('2', '38', '63', 'Iphone XR 64GB', '1', '10.00'), ('3', '39', '57', 'Alicate', '15', '10.00'), ('4', '39', '63', 'Iphone XR 64GB', '15', '10.00'), ('5', '40', '57', 'Alicate', '1', '10.00'), ('6', '40', '63', 'Iphone XR 64GB', '1', '10.00'), ('7', '41', '57', 'Alicate', '10', '10.00'), ('8', '42', '57', 'Alicate', '10', '250.33'), ('9', '42', '63', 'Iphone XR 64GB', '8', '2000.00'), ('10', '43', '68', 'Camiseta preta ', '10', '20.00'), ('11', '44', '57', 'Alicate', '1', '10.00'), ('12', '45', '57', 'Alicate', '1', '10.00'), ('13', '46', '57', 'Alicate', '10', '15.00'), ('14', '46', '63', 'Iphone XR 64GB', '5', '1500.00'), ('15', '46', '68', 'Camiseta preta ', '30', '20.00'), ('16', '47', '64', 'Monitor PCFORT', '5', '250.00'), ('17', '47', '70', 'Neosoro', '5', '5.25'), ('18', '48', '57', 'Alicate', '10', '5.00'), ('19', '49', '57', 'Alicate', '5', '10.00'), ('20', '50', '57', 'Alicate', '5', '100.00'), ('21', '51', '63', 'Iphone XR 64GB', '5', '1000.00'), ('22', '52', '70', 'Neosoro', '5', '10.00'), ('23', '53', '57', 'Alicate', '3', '20.50'), ('24', '54', '57', 'Alicate', '10', '10.00'), ('25', '55', '64', 'Monitor PCFORT', '1', '10.00'), ('26', '56', '64', 'Monitor PCFORT', '10', '700.00'), ('27', '57', '70', 'Neosoro', '10', '15.00'), ('28', '57', '57', 'Alicate', '10', '12.99'), ('29', '58', '57', 'Alicate', '10', '2.00'), ('30', '58', '68', 'Camiseta preta ', '2', '1.50'), ('31', '59', '64', 'Monitor PCFORT', '10', '10.00'), ('32', '59', '68', 'Camiseta preta ', '10', '15.00'), ('33', '60', '57', 'Alicate', '1', '10.00'), ('34', '61', '57', 'Alicate', '1', '10.00'), ('35', '62', '57', 'Alicate', '10', '15.00');

CREATE TABLE `mensagem` (
  `idMensagem` int(5) NOT NULL AUTO_INCREMENT,
  `mensagem` varchar(1000) NOT NULL,
  PRIMARY KEY (`idMensagem`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO mensagem (idMensagem, mensagem) VALUES ('1', 'kjkkkkkkkkkkk'), ('2', 'mkkkkkkkkkkkkkkkkkkk'), ('3', 'teste'), ('4', 'oi'), ('5', 'Teste'), ('6', 'Teste'), ('7', 'João'), ('8', 'teste'), ('9', 'João Pedro'), ('10', 'teste');

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(150) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO messages (id, sender_id, receiver_id, message, timestamp, username, file_path, created_at) VALUES ('142', '2', '62', 'Alô', '2024-07-06 03:13:43', 'João', '', '2024-07-06 00:13:43'), ('143', '2', '62', '', '2024-07-06 03:15:25', 'João', 'uploads/pedido_compra.pdf', '2024-07-06 00:15:25'), ('144', '2', '2', 'teste', '2024-07-07 03:31:36', 'João', '', '2024-07-07 00:31:36'), ('145', '2', '62', 'teste', '2024-07-07 23:59:47', 'João', '', '2024-07-07 20:59:47'), ('146', '62', '2', 'oii', '2024-07-08 00:00:13', 'Admin', '', '2024-07-07 21:00:13'), ('147', '2', '62', 'esse trem', '2024-07-08 00:00:51', 'João', '', '2024-07-07 21:00:51'), ('148', '2', '62', 'ainda vai me fazer tacar a cabeça na parede', '2024-07-08 00:01:03', 'João', '', '2024-07-07 21:01:03'), ('149', '62', '2', 'vc não é maluco ', '2024-07-08 00:01:13', 'Admin', '', '2024-07-07 21:01:13'), ('150', '2', '62', '', '2024-07-08 00:01:20', 'João', 'uploads/IMG_7757.png', '2024-07-07 21:01:20'), ('151', '2', '62', 'abre isso', '2024-07-08 00:01:53', 'João', '', '2024-07-07 21:01:53'), ('152', '2', '62', 'a tela fico pica', '2024-07-08 00:03:31', 'João', '', '2024-07-07 21:03:31'), ('153', '2', '2', 'teste', '2024-07-24 14:59:03', 'João Pedro', '', '2024-07-24 11:59:03'), ('154', '2', '2', '', '2024-07-24 14:59:11', 'João Pedro', 'uploads/pedido_compra.pdf', '2024-07-24 11:59:11'), ('155', '2', '49', 'teste', '2024-08-09 12:50:52', 'João Pedro', '', '2024-08-09 09:50:52'), ('156', '49', '2', 'opa jao', '2024-08-09 12:51:03', 'Jorge', '', '2024-08-09 09:51:03'), ('157', '49', '2', 'tudo joia', '2024-08-09 12:51:06', 'Jorge', '', '2024-08-09 09:51:06'), ('158', '49', '2', 'como tá as coisas por ai?', '2024-08-09 12:51:12', 'Jorge', '', '2024-08-09 09:51:12'), ('159', '2', '49', 'tá indo', '2024-08-09 12:51:19', 'João Pedro', '', '2024-08-09 09:51:19'), ('160', '2', '49', 'e ai?', '2024-08-09 12:51:40', 'João Pedro', '', '2024-08-09 09:51:40'), ('161', '49', '2', 'dboassa', '2024-08-09 12:51:46', 'Jorge', '', '2024-08-09 09:51:46'), ('162', '2', '49', 'preciso daquele pedido de compra em pdf', '2024-08-09 12:52:07', 'João Pedro', '', '2024-08-09 09:52:07'), ('163', '2', '49', 'você tem?', '2024-08-09 12:52:11', 'João Pedro', '', '2024-08-09 09:52:11'), ('164', '49', '2', 'ta na mão', '2024-08-09 12:52:35', 'Jorge', '', '2024-08-09 09:52:35'), ('165', '49', '2', '', '2024-08-09 12:52:45', 'Jorge', 'uploads/pedido_compra.pdf', '2024-08-09 09:52:45'), ('166', '2', '64', 'Boa tarde', '2024-08-19 16:01:21', 'João Pedro', '', '2024-08-19 13:01:21'), ('167', '64', '2', 'Oi', '2024-08-19 16:10:11', 'Jessica', '', '2024-08-19 13:10:11'), ('168', '64', '2', 'eu aqui', '2024-08-19 16:10:13', 'Jessica', '', '2024-08-19 13:10:13'), ('169', '64', '2', 'estressado', '2024-08-19 16:10:17', 'Jessica', '', '2024-08-19 13:10:17'), ('170', '2', '64', 'Ufa', '2024-08-19 16:10:20', 'João Pedro', '', '2024-08-19 13:10:20'), ('171', '2', '64', 'fez uma p Deus ver', '2024-08-19 16:10:25', 'João Pedro', '', '2024-08-19 13:10:25'), ('172', '64', '2', 'tava atendendo :c', '2024-08-19 16:10:45', 'Jessica', '', '2024-08-19 13:10:45'), ('173', '2', '64', 'vo brokia oce', '2024-08-19 16:12:44', 'João Pedro', '', '2024-08-19 13:12:44'), ('174', '2', '64', '><', '2024-08-19 16:12:47', 'João Pedro', '', '2024-08-19 13:12:47'), ('175', '2', '61', 'oi', '2024-09-17 22:42:41', 'João Pedro', '', '2024-09-17 19:42:41'), ('176', '61', '2', 'boa noite ', '2024-09-17 22:42:55', 'admin', '', '2024-09-17 19:42:55'), ('177', '61', '2', 'tudo bem?', '2024-09-17 22:44:52', 'admin', '', '2024-09-17 19:44:52'), ('178', '2', '61', 'great and you?', '2024-09-17 22:45:33', 'João Pedro', '', '2024-09-17 19:45:33'), ('179', '61', '2', 'i am fine ', '2024-09-17 22:46:10', 'admin', '', '2024-09-17 19:46:10'), ('180', '2', '61', 'Curriculo sidney', '2024-09-17 22:50:37', 'João Pedro', 'uploads/CVSIDNEY.pdf', '2024-09-17 19:50:37');

CREATE TABLE `ordem_servico` (
  `idOs` int(5) NOT NULL AUTO_INCREMENT,
  `responsavel` varchar(150) NOT NULL,
  `descricaoOs` varchar(500) NOT NULL,
  `data_cadastroOs` datetime NOT NULL,
  `data_inicioOs` varchar(35) NOT NULL,
  `data_terminoOs` varchar(35) DEFAULT NULL,
  `valorOs` varchar(15) DEFAULT NULL,
  `tipoOs` varchar(150) NOT NULL,
  `statusOs` varchar(150) NOT NULL,
  `status` char(1) NOT NULL,
  `clienteOs` varchar(150) NOT NULL,
  PRIMARY KEY (`idOs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedido_compra` (
  `codigo_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `nome_fornecedor` varchar(100) DEFAULT NULL,
  `responsavel_pedido` varchar(100) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(11) DEFAULT NULL,
  `pago` char(1) DEFAULT NULL,
  `banco_receb` varchar(45) DEFAULT NULL,
  `fm_pag` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO pedido_compra (codigo_pedido, nome_fornecedor, responsavel_pedido, observacoes, valor_total, data, deletado, id_reg_delet, pago, banco_receb, fm_pag) VALUES ('36', 'ProControl', 'João', 'Valor', '20.00', '2024-06-14', 'S', '2', 'N', 'Caixa', 'A prazo'), ('37', 'ProControl', 'João', 'Teste Celular', '323.85', '2024-07-12', 'S', '2', 'N', '', ''), ('38', 'Fornecedor', 'João Pedro', 'OBS', '1.00', '2024-08-12', 'S', '61', 'N', 'Caixa', 'A prazo'), ('39', 'Fornecedor', 'João Pedro', 'Obs do ped', '1.00', '2024-08-13', 'S', '61', 'N', 'Caixa', 'A prazo'), ('40', 'Fornecedor', 'João Pedro', 'Observações do pedido', '1.00', '2024-08-16', 'S', '2', 'N', '', ''), ('41', 'Fornecedor', 'Jessica', 'Teste', '1.00', '2024-08-16', 'S', '2', 'N', 'Caixa', 'A prazo'), ('42', 'ProControl', 'Jessica', 'teste', '18503.30', '2024-08-12', 'S', '2', 'N', '', ''), ('43', 'Fornecedor', 'Igor', 'ajuste de preço de custo', '200.00', '2024-08-19', 'S', '61', 'N', '', ''), ('44', 'Fornecedor', 'João Pedro', 'Observações do pedido', '1.00', '2024-08-26', 'S', '61', 'N', '', ''), ('45', 'Fornecedor', 'João Pedro', 'Observações do pedido', '1.00', '2024-09-01', 'S', '61', 'N', '', ''), ('46', 'ProControl', 'João Pedro', 'Teste email', '8250.00', '2024-09-16', 'S', '2', 'N', '', ''), ('47', 'Fornecedor', 'João Pedro', 'teste pedido', '1276.25', '2024-09-02', 'S', '2', 'N', '', ''), ('48', 'ProControl', 'João Pedro', 'teste', '50.00', '2024-10-01', 'S', '2', 'N', '', ''), ('49', 'Fornecedor', 'João Pedro', 'testre ', '50.00', '2024-09-02', 'S', '2', 'N', '', ''), ('50', 'ProControl', 'João Pedro', 'testeeeee', '500.00', '2024-09-01', 'S', '2', 'S', '', ''), ('51', 'ProControl', 'João Pedro', 'Email', '5000.00', '2024-09-01', 'S', '2', 'N', 'Caixa', 'A prazo'), ('52', 'ProControl', 'João Pedro', 'teste', '50.00', '2024-09-29', 'S', '2', 'N', '', ''), ('53', 'Fornecedor', 'João Pedro', 'Vazia', '61.50', '2024-09-24', 'S', '2', 'N', '', ''), ('54', 'Fornecedor', 'João Pedro', 'pedido email teste', '100.00', '2024-09-04', 'S', '2', 'N', '', ''), ('55', 'Fornecedor', 'João Pedro', 'Observações do pedido', '1.00', '2024-09-05', 'S', '2', 'N', '', ''), ('56', 'Fornecedor', 'João Pedro', 'Reposição de Monitor', '7000.00', '2024-09-02', 'S', '2', 'N', 'Caixa', 'A prazo'), ('57', 'ProControl', 'João Pedro', 'Cartão de Crédito', '279.90', '2024-09-03', 'S', '2', 'S', 'Caixa', 'A prazo'), ('58', 'Fornecedor', 'João Pedro', 'teste', '23.00', '2024-09-03', 'S', '2', 'N', '', 'A prazo'), ('59', 'ProControl', 'João Pedro', 'Teste', '250.00', '2024-09-25', 'S', '2', 'N', 'Cofre', 'Pix'), ('60', 'Fornecedor', 'admin', '90 reais e SIM no pago', '10.00', '2024-09-04', 'S', '2', 'S', 'Caixa', 'A prazo'), ('61', 'Fornecedor', 'João Pedro', 'caixa 90 e sim no pago', '10.00', '2024-09-05', 'S', '2', 'S', 'Cofre', 'A prazo'), ('62', 'ProControl', 'João Pedro', 'teste', '150.00', '2024-09-02', 'N', '0', 'S', 'Caixa', 'A prazo');

CREATE TABLE `pedidos` (
  `codigo_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(100) NOT NULL,
  `responsavel_pedido` varchar(150) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `data` date NOT NULL,
  `deletado` char(1) DEFAULT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `pago` char(1) DEFAULT NULL,
  `banco_receb` varchar(45) DEFAULT NULL,
  `fm_pag` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO pedidos (codigo_pedido, nome_cliente, responsavel_pedido, observacoes, valor_total, data, deletado, id_reg_delet, pago, banco_receb, fm_pag) VALUES ('1', 'Consumidor Final', 'Jessica', 'teste obs', '150.00', '2024-08-13', 'S', '2', 'S', 'Caixa', 'A prazo'), ('2', 'João', 'João Pedro', 'teste', '15.99', '2024-09-02', 'S', '2', 'N', '', ''), ('3', 'João', 'João Pedro', 'dance', '10210.00', '2024-09-02', 'S', '2', 'N', '', ''), ('4', 'João', 'João Pedro', 'teste', '8800.00', '2024-09-24', 'S', '2', 'N', '', ''), ('5', 'João', 'João Pedro', 'teste', '19.95', '2024-10-01', 'S', '2', 'N', '', ''), ('6', 'Consumidor Final', 'João Pedro', 'teste', '200.00', '2024-09-09', 'S', '2', 'N', '', ''), ('7', 'João', 'João Pedro', 'Email', '800.00', '2024-09-02', 'S', '2', 'S', '', ''), ('8', 'Consumidor Final', 'João Pedro', '13:14', '50.00', '2024-09-02', 'S', '2', 'N', '', ''), ('9', 'Consumidor Final', 'João Pedro', 'Teste', '150.00', '2024-09-02', 'S', '2', 'N', '', ''), ('10', 'João', 'João Pedro', '', '1350.00', '2024-09-15', 'N', '0', 'S', '', ''), ('11', 'Consumidor Final', 'João Pedro', 'aqui mesmo na rua', '5.00', '2024-10-07', 'S', '2', 'N', '', ''), ('12', 'Consumidor Final', 'João Pedro', 'penes', '50.00', '2024-09-30', 'S', '2', 'N', '', ''), ('13', 'Consumidor Final', 'João Pedro', 'pix', '1.00', '2024-09-05', 'N', '0', 'N', '', 'Cartão crédito'), ('14', 'Consumidor Final', 'João Pedro', 'cartao', '110.00', '2024-09-10', 'N', '0', 'N', '', 'Cartão crédito'), ('15', 'Consumidor Final', 'João Pedro', '100zao e sim', '10.00', '2024-09-10', 'N', '0', 'S', 'Cofre', 'A prazo');

CREATE TABLE `saida` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
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
  `id_reg_edit` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO saida (id, quantos, descricao, fmpag, responsavel, data, datareg, id_reg, nomeBanco, id_reg_delet, deletado, id_reg_edit) VALUES ('1', '1080', 'Gastos do mês', 'Pix', 'João Pedro', '2024-08-13', '2024-08-13 03:16:04', '64', 'Caixa', '', 'N', '');

CREATE TABLE `secao` (
  `idSecao` int(5) NOT NULL AUTO_INCREMENT,
  `nomeSecao` varchar(150) NOT NULL,
  PRIMARY KEY (`idSecao`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO secao (idSecao, nomeSecao) VALUES ('1', 'teste');

CREATE TABLE `setor` (
  `idSetor` int(5) NOT NULL AUTO_INCREMENT,
  `NomeSetor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idSetor`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO setor (idSetor, NomeSetor) VALUES ('4', 'Administração'), ('5', 'Financeiro'), ('6', 'Desenvolvimento');

CREATE TABLE `tbl_preco` (
  `id_tblpreco` int(5) NOT NULL AUTO_INCREMENT,
  `nome_tbl` varchar(250) NOT NULL,
  `preco_tbl` varchar(100) NOT NULL,
  `descricao_tbl` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_tblpreco`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_preco (id_tblpreco, nome_tbl, preco_tbl, descricao_tbl) VALUES ('4', 'Corte de Cabelo', '35,00', 'Corte de Cabelo Masculino Navalhado');

CREATE TABLE `tipo_servico` (
  `idServico` int(5) NOT NULL AUTO_INCREMENT,
  `nomeServico` varchar(150) NOT NULL,
  PRIMARY KEY (`idServico`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tipo_servico (idServico, nomeServico) VALUES ('1', 'Manutenção');

CREATE TABLE `transportes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` varchar(11) NOT NULL,
  `tipo_pedido` enum('Compra','Venda') NOT NULL,
  `valor_transporte` decimal(10,2) NOT NULL,
  `veiculo_placa` varchar(20) NOT NULL,
  `data_transporte` date DEFAULT NULL,
  `data_cadastro_transporte` timestamp NOT NULL DEFAULT current_timestamp(),
  `deletado` char(1) NOT NULL,
  `id_reg_delet` int(5) DEFAULT NULL,
  `Concluido` enum('Em rota','Concluido') NOT NULL DEFAULT 'Em rota',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO transportes (id, pedido_id, tipo_pedido, valor_transporte, veiculo_placa, data_transporte, data_cadastro_transporte, deletado, id_reg_delet, Concluido) VALUES ('2', '5', 'Venda', '16.00', 'ABC-1234', '2024-02-14', '2024-02-21 16:09:00', 'n', '2', 'Em rota'), ('5', '9', 'Venda', '9.00', 'ABC-1234', '2024-02-01', '2024-02-21 19:29:00', 'N', '0', 'Em rota'), ('6', '99', 'Venda', '159.99', 'ABC-1234', '2024-02-01', '2024-02-28 16:10:00', 'S', '2', 'Concluido'), ('7', '99', 'Venda', '159.99', 'ABC-1234', '0000-00-00', '2024-02-28 16:10:00', 'S', '2', 'Concluido');

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(80) NOT NULL,
  `Sobrenome` varchar(90) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Senha` varchar(256) NOT NULL,
  `NivelUsuario` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `telefoneUsuario` varchar(20) NOT NULL,
  `cpfUsuario` varchar(15) NOT NULL,
  `Setor` varchar(70) DEFAULT NULL,
  `Online` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`IdUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO usuario (IdUsuario, Nome, Sobrenome, Email, Senha, NivelUsuario, Status, telefoneUsuario, cpfUsuario, Setor, Online) VALUES ('2', 'João Pedro', 'Gomes', 'procontrol.contat@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1', 'Ativo', '+55 (35) 8468-7649', '139.527.326-06', 'Desenvolvimento', '1'), ('61', 'Admin', 'admin', 'admin@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1', 'Ativo', '+55 (35) 8888-8888', '000.000.000-00', 'Administração', '0');

CREATE TABLE `veiculos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `chassi` (`chassi`),
  UNIQUE KEY `placa` (`placa`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO veiculos (id, marca, modelo, ano, cor, chassi, placa, valor_aquisicao, data_aquisicao, responsavel, localizacao, quilometragem, condicao, data_criacao, data_atualizacao) VALUES ('9', 'BMW', 'X6', '2022', 'Azul', '749 Y7maU0 99 Az3652', 'ABC-1234', '365.475,00', '2024-01-02', 'João', 'São Paulo', '15', 'bom', '2024-02-12 14:35:07', '2024-02-22 02:09:49');

