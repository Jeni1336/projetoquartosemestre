-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Out-2023 às 02:17
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
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `nome` text NOT NULL,
  `sobrenome` text NOT NULL,
  `genero` varchar(10) NOT NULL,
  `data_nasc` text NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`nome`, `sobrenome`, `genero`, `data_nasc`, `email`, `senha`) VALUES
('a', 'a', '', '2002-03-16', 'a', 'a'),
('a', 'a', '', '', '2002-03-16', 'a'),
('a', 'a', '', '', '2002-03-16', 'a'),
('a', 'a', '', '', '2002-03-16', 'a'),
('a', 'a', '', '', '2002-03-16', 'a'),
('a', 'a', '', '2002-03-16', 'a', 'a'),
('ana', 'pen', '', '2002-03-16', 'ana.paula8@live.com', 'a23'),
('anap', 'oi', '', '2000-03-16', 'ana.paula8@live.com', '56'),
('anap', 'oi', '', '2000-03-16', 'ana.paula8@live.com', '56'),
('oenis ', 'oi', 'masc', '2023-10-05', 'fudedorprofissional@anal.com', '123456'),
('', '', '', '', '', ''),
('JJUUJ', 'pen', 'naob', '2303-03-16', 'cu.assado@gae.com', '123456');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
