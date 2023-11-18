-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Nov-2023 às 19:11
-- Versão do servidor: 8.0.12
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cadastro_cliente`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cartao`
--

CREATE TABLE `cartao` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `numero_cartao` varchar(16) DEFAULT NULL,
  `cvv` varchar(32) DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chatbot`
--

CREATE TABLE `chatbot` (
  `id` int(11) NOT NULL,
  `queries` varchar(300) NOT NULL,
  `replies` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `chatbot`
--

INSERT INTO `chatbot` (`id`, `queries`, `replies`) VALUES
(1, 'Oi!', 'Olá, aluno! Em que posso te ajudar? '),
(2, 'Oi, tudo bem?', 'Oi, tudo bem e com você? Em que posso te ajudar?'),
(3, 'Do que se trata esse trabalho?', 'Este é um trabalho da matéria do Projeto Integrador, fizemos um ecommerce de cosméticos usando PHP, html, css, javascript e bootstrap!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sobrenome` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `genero` varchar(10) NOT NULL,
  `data_nasc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `senha` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `sobrenome`, `genero`, `data_nasc`, `email`, `senha`) VALUES
(16, 'joao', 'pamplona', 'masc', '2001-05-18', 'joaovcanada@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(17, 'joao', 'pamplona', 'masc', '2001-05-18', 'jvc@gmail.com', '51f6f8fe03a390d3de50ad49913d4b66'),
(34, 'Ana Paula ', 'Ribeiro', 'feminino', '2002-03-16', 'anahoran.tommo@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(35, 'Joao ', 'Pamplona', 'masc', '2001-05-18', 'jj@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(36, 'Josezinho ', 'Vinicius', 'masc', '2002-05-23', 'emailaleatorio@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(37, 'jorginho', 'cruz', 'masc', '2004-04-06', 'anao@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`id`, `id_cliente`, `endereco`, `cidade`, `bairro`, `estado`, `cep`) VALUES
(18, 34, 'Rua Luiz Gonçalves de Camargo, n541', 'Sorocaba', 'Éden', 'SP', '18103020');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `url_absoluta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `quantidade`, `imagem`, `url_absoluta`) VALUES
(1, 'Serum', 'O sérum é a textura perfeita que combina com qualquer tipo de pele', '50.00', 80, 'https://i.imgur.com/h7osmiV.jpg', '../projetoquartosemestre/serumprod.php'),
(2, 'Batom', 'Um Batom é indispensável para uma make perfeita!', '30.00', 58, 'https://i.imgur.com/A9JLqMw.jpg', '../projetoquartosemestre/batom.php'),
(3, 'Mascara de Cilios', 'Cílios Volumosos e Marcantes com as Máscara de Cílios', '35.00', 30, 'https://i.imgur.com/skrIpL0.jpg', '../projetoquartosemestre/cilios.php'),
(4, 'Kit de maquiagem', 'Maquiagem simples e natural para o dia a dia', '70.00', 20, 'https://i.imgur.com/vIeWQg1.jpg', '../projetoquartosemestre/maquiagem.php');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_carrinho`
--

CREATE TABLE `tbl_carrinho` (
  `id` int(11) NOT NULL,
  `cod` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `preco` double(10,2) NOT NULL,
  `qtd` int(11) NOT NULL,
  `sessao` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cartao`
--
ALTER TABLE `cartao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices para tabela `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tbl_carrinho`
--
ALTER TABLE `tbl_carrinho`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cartao`
--
ALTER TABLE `cartao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tbl_carrinho`
--
ALTER TABLE `tbl_carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cartao`
--
ALTER TABLE `cartao`
  ADD CONSTRAINT `cartao_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`);

--
-- Limitadores para a tabela `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
