-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/09/2023 às 12:18
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ban2`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidade`
--

CREATE TABLE `cidade` (
  `cidade_id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cidade`
--

INSERT INTO `cidade` (`cidade_id`, `nome`) VALUES
(1, 'Joinville'),
(2, 'Curitiba'),
(3, 'Cascavel'),
(4, 'Jaraguá'),
(5, 'Araquari'),
(6, 'Toledo'),
(7, 'Florianopolis'),
(8, 'Porto Alegre'),
(9, 'Curitibanos'),
(10, 'Maçaranduba');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cidade_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`cliente_id`, `nome`, `cidade_id`) VALUES
(1, 'Cliente 1', 1),
(2, 'Cliente 2', 2),
(3, 'Cliente 3', 3),
(4, 'Cliente 4', 4),
(5, 'Cliente 5', 5),
(6, 'Cliente 6', 6),
(7, 'Cliente 7', 7),
(8, 'Cliente 8', 8),
(9, 'Cliente 9', 9),
(10, 'Cliente 10', 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `compra`
--

CREATE TABLE `compra` (
  `compra_id` int(11) NOT NULL,
  `fornecedor_id` int(11) DEFAULT NULL,
  `funcionario_id` int(11) DEFAULT NULL,
  `loja_id` int(11) DEFAULT NULL,
  `data_compra` date DEFAULT NULL,
  `valor_total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `compra`
--

INSERT INTO `compra` (`compra_id`, `fornecedor_id`, `funcionario_id`, `loja_id`, `data_compra`, `valor_total`) VALUES
(1, 1, 1, 1, '2023-09-06', 120),
(2, 2, 2, 2, '2023-09-05', 80),
(3, 3, 3, 3, '2023-09-04', 60),
(4, 4, 4, 4, '2023-09-03', 95),
(5, 5, 5, 5, '2023-09-02', 72),
(6, 6, 6, 6, '2023-09-01', 110),
(7, 7, 7, 7, '2023-08-31', 45),
(8, 8, 8, 8, '2023-08-30', 38),
(9, 9, 9, 9, '2023-08-29', 65),
(10, 10, 10, 10, '2023-08-28', 88);

-- --------------------------------------------------------

--
-- Estrutura para tabela `compra_produto`
--

CREATE TABLE `compra_produto` (
  `prod_compra_id` int(11) NOT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `custo` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `compra_produto`
--

INSERT INTO `compra_produto` (`prod_compra_id`, `compra_id`, `produto_id`, `quantidade`, `custo`) VALUES
(1, 1, 1, 10, 100),
(2, 1, 2, 8, 120),
(3, 2, 2, 6, 80),
(4, 2, 3, 4, 60),
(5, 3, 3, 5, 75),
(6, 3, 1, 3, 30),
(7, 4, 4, 12, 150),
(8, 4, 5, 8, 96),
(9, 5, 5, 7, 84),
(10, 5, 4, 6, 72);

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `estoque_id` int(11) NOT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`estoque_id`, `produto_id`, `quantidade`) VALUES
(1, 1, 23),
(2, 2, 18),
(3, 3, 15),
(4, 4, 28),
(5, 5, 22),
(6, 6, 33),
(7, 7, 11),
(8, 8, 9),
(9, 9, 20),
(10, 10, 27);

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `fornecedor_id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cnpj` bigint(14) DEFAULT NULL,
  `cidade_id` int(11) DEFAULT NULL,
  `rua` varchar(200) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`fornecedor_id`, `nome`, `cnpj`, `cidade_id`, `rua`, `numero`, `bairro`) VALUES
(1, 'Fornecedor A', 12345678901234, 1, 'Av. X', 789, 'Centro'),
(2, 'Fornecedor B', 98765432109876, 2, 'Av. Y', 456, 'Guanabara'),
(3, 'Fornecedor C', 45678901234567, 3, 'Av. Z', 123, 'Jardim Iririu'),
(4, 'Fornecedor D', 11111111111111, 4, 'Av. W', 321, 'Jardim Sofia'),
(5, 'Fornecedor E', 22222222222222, 5, 'Av. V', 444, 'Comasa'),
(6, 'Fornecedor F', 33333333333333, 6, 'Av. U', 555, 'Bom Retiro'),
(7, 'Fornecedor G', 44444444444444, 7, 'Av. T', 666, 'Zona Industrial'),
(8, 'Fornecedor H', 55555555555555, 8, 'Av. S', 777, 'Pirabeiraba'),
(9, 'Fornecedor I', 66666666666666, 9, 'Av. R', 888, 'Espinheiros'),
(10, 'Fornecedor J', 77777777777777, 10, 'Av. Q', 999, 'Ulises Guimarães');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `funcionario_id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cidade_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`funcionario_id`, `nome`, `cidade_id`, `email`, `senha`) VALUES
(1, 'Funcionario 1', 1, 'funcionario1@example.com', 'senha123'),
(2, 'Funcionario 2', 2, 'funcionario2@example.com', 'senha123'),
(3, 'Funcionario 3', 3, 'funcionario3@example.com', 'senha123'),
(4, 'Funcionario 4', 4, 'funcionario4@example.com', 'senha123'),
(5, 'Funcionario 5', 5, 'funcionario5@example.com', 'senha123'),
(6, 'Funcionario 6', 6, 'funcionario6@example.com', 'senha123'),
(7, 'Funcionario 7', 7, 'funcionario7@example.com', 'senha123'),
(8, 'Funcionario 8', 8, 'funcionario8@example.com', 'senha123'),
(9, 'Funcionario 9', 9, 'funcionario9@example.com', 'senha123'),
(10, 'Funcionario 10', 10, 'funcionario10@example.com', 'senha123'),
(11, 'Funcionario1', 1, 'funcionario1@example.com', 'senha123'),
(12, 'Funcionario2', 2, 'funcionario2@example.com', 'senha123'),
(13, 'Funcionario3', 3, 'funcionario3@example.com', 'senha123'),
(14, 'Funcionario4', 4, 'funcionario4@example.com', 'senha123'),
(15, 'Funcionario5', 5, 'funcionario5@example.com', 'senha123'),
(16, 'Funcionario6', 6, 'funcionario6@example.com', 'senha123'),
(17, 'Funcionario7', 7, 'funcionario7@example.com', 'senha123'),
(18, 'Funcionario8', 8, 'funcionario8@example.com', 'senha123'),
(19, 'Funcionario9', 9, 'funcionario9@example.com', 'senha123'),
(20, 'Funcionario10', 10, 'funcionario10@example.com', 'senha123'),
(22, 'PEDRO', 1, 'funcionario1@example.com', 'PEDRO123'),
(23, 'GUSTAVO', 2, 'funcionario2@example.com', 'GUSTAVO123'),
(24, 'ANA', 3, 'funcionario3@example.com', 'ANA123'),
(25, 'BAN', 4, 'funcionario4@example.com', 'BAN123'),
(26, 'SOP', 5, 'funcionario5@example.com', 'SOP123'),
(27, 'Funcionario6', 6, 'funcionario6@example.com', 'senha123'),
(28, 'Funcionario7', 7, 'funcionario7@example.com', 'senha123'),
(29, 'Funcionario8', 8, 'funcionario8@example.com', 'senha123'),
(30, 'Funcionario9', 9, 'funcionario9@example.com', 'senha123'),
(31, 'Funcionario10', 10, 'funcionario10@example.com', 'senha123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `loja`
--

CREATE TABLE `loja` (
  `loja_id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cidade_id` int(11) DEFAULT NULL,
  `rua` varchar(200) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `loja`
--

INSERT INTO `loja` (`loja_id`, `nome`, `cidade_id`, `rua`, `numero`, `bairro`) VALUES
(1, 'Loja 1', 1, 'Rua A', 123, 'Centro'),
(2, 'Loja 2', 2, 'Rua B', 456, 'Iririu'),
(3, 'Loja 3', 3, 'Rua C', 789, 'Nova Brasília'),
(4, 'Loja 4', 4, 'Rua D', 101, 'Bom Retiro'),
(5, 'Loja 5', 5, 'Rua E', 55, 'Aventireiro'),
(6, 'Loja 6', 6, 'Rua F', 333, 'São Marcos'),
(7, 'Loja 7', 7, 'Rua G', 777, 'Vila Nova'),
(8, 'Loja 8', 8, 'Rua H', 888, 'Vila Cubatão'),
(9, 'Loja 9', 9, 'Rua I', 222, 'Jardim Paraíso'),
(10, 'Loja 10', 10, 'Rua J', 777, 'Boa Vista');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `produto_id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `fornecedor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`produto_id`, `nome`, `preco`, `fornecedor_id`) VALUES
(1, 'Roda', 10.99, 1),
(2, 'Limpador de parabrisa', 15.99, 2),
(3, 'Escapamento', 20.49, 3),
(4, 'Radiador', 8.75, 4),
(5, 'Banco', 12.50, 5),
(6, 'Capô', 18.99, 6),
(7, 'Porta', 7.25, 7),
(8, 'Filtro', 9.99, 8),
(9, 'Fluido de radiador', 14.50, 9),
(10, 'Oleo', 22.99, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `venda_id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `funcionario_id` int(11) DEFAULT NULL,
  `loja_id` int(11) DEFAULT NULL,
  `data_venda` date DEFAULT NULL,
  `valor_total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `venda`
--

INSERT INTO `venda` (`venda_id`, `cliente_id`, `funcionario_id`, `loja_id`, `data_venda`, `valor_total`) VALUES
(1, 1, 1, 1, '2023-09-16', 35),
(2, 2, 2, 2, '2023-09-15', 45),
(3, 3, 3, 3, '2023-09-14', 55),
(4, 4, 4, 4, '2023-09-13', 28),
(5, 5, 5, 5, '2023-09-12', 40),
(6, 6, 6, 6, '2023-09-11', 60),
(7, 7, 7, 7, '2023-09-10', 22),
(8, 8, 8, 8, '2023-09-09', 18),
(9, 9, 9, 9, '2023-09-08', 33),
(10, 10, 10, 10, '2023-09-07', 72);

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda_produto`
--

CREATE TABLE `venda_produto` (
  `prod_venda_id` int(11) NOT NULL,
  `venda_id` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `venda_produto`
--

INSERT INTO `venda_produto` (`prod_venda_id`, `venda_id`, `produto_id`, `quantidade`) VALUES
(1, 1, 1, 3),
(2, 1, 2, 2),
(3, 2, 2, 4),
(4, 2, 3, 1),
(5, 3, 3, 2),
(6, 3, 1, 1),
(7, 4, 4, 5),
(8, 4, 5, 3),
(9, 5, 5, 2),
(10, 5, 4, 4);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cidade`
--
ALTER TABLE `cidade`
  ADD PRIMARY KEY (`cidade_id`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`),
  ADD KEY `cidade_id` (`cidade_id`);

--
-- Índices de tabela `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`compra_id`),
  ADD KEY `fornecedor_id` (`fornecedor_id`),
  ADD KEY `funcionario_id` (`funcionario_id`),
  ADD KEY `loja_id` (`loja_id`);

--
-- Índices de tabela `compra_produto`
--
ALTER TABLE `compra_produto`
  ADD PRIMARY KEY (`prod_compra_id`),
  ADD KEY `compra_id` (`compra_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`estoque_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`fornecedor_id`),
  ADD KEY `cidade_id` (`cidade_id`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`funcionario_id`),
  ADD KEY `cidade_id` (`cidade_id`);

--
-- Índices de tabela `loja`
--
ALTER TABLE `loja`
  ADD PRIMARY KEY (`loja_id`),
  ADD KEY `cidade_id` (`cidade_id`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`produto_id`),
  ADD KEY `fornecedor_id` (`fornecedor_id`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`venda_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `funcionario_id` (`funcionario_id`),
  ADD KEY `loja_id` (`loja_id`);

--
-- Índices de tabela `venda_produto`
--
ALTER TABLE `venda_produto`
  ADD PRIMARY KEY (`prod_venda_id`),
  ADD KEY `venda_id` (`venda_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cidade`
--
ALTER TABLE `cidade`
  MODIFY `cidade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `compra`
--
ALTER TABLE `compra`
  MODIFY `compra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `compra_produto`
--
ALTER TABLE `compra_produto`
  MODIFY `prod_compra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `estoque_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `fornecedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `funcionario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `loja`
--
ALTER TABLE `loja`
  MODIFY `loja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `produto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `venda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `venda_produto`
--
ALTER TABLE `venda_produto`
  MODIFY `prod_venda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`cidade_id`) REFERENCES `cidade` (`cidade_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`fornecedor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionario` (`funcionario_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compra_ibfk_3` FOREIGN KEY (`loja_id`) REFERENCES `loja` (`loja_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `compra_produto`
--
ALTER TABLE `compra_produto`
  ADD CONSTRAINT `compra_produto_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`compra_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compra_produto_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD CONSTRAINT `fornecedor_ibfk_1` FOREIGN KEY (`cidade_id`) REFERENCES `cidade` (`cidade_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`cidade_id`) REFERENCES `cidade` (`cidade_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `loja`
--
ALTER TABLE `loja`
  ADD CONSTRAINT `loja_ibfk_1` FOREIGN KEY (`cidade_id`) REFERENCES `cidade` (`cidade_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`fornecedor_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `venda_ibfk_2` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionario` (`funcionario_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `venda_ibfk_3` FOREIGN KEY (`loja_id`) REFERENCES `loja` (`loja_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `venda_produto`
--
ALTER TABLE `venda_produto`
  ADD CONSTRAINT `venda_produto_ibfk_1` FOREIGN KEY (`venda_id`) REFERENCES `venda` (`venda_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `venda_produto_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
