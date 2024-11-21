-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 21-Out-2024 às 17:28
-- Versão do servidor: 8.0.27
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `barbeariaricardo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id_horario` int NOT NULL,
  `dt_corte` date NOT NULL,
  `hr_corte` time NOT NULL,
  `nm_corte` varchar(100) NOT NULL,
  `vl_corte` decimal(10,2) NOT NULL,
  `nm_funcionario` varchar(25) NOT NULL,
  `nm_forma_pagamento` varchar(50) NOT NULL,
  `fg_id_cortes` int DEFAULT NULL,
  `fg_id_funcionario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id_horario`, `dt_corte`, `hr_corte`, `nm_corte`, `vl_corte`, `nm_funcionario`, `nm_forma_pagamento`, `fg_id_cortes`, `fg_id_funcionario`) VALUES
(1, '2024-10-24', '09:40:00', 'Clássico com Sombrancelha', '45.00', 'Rubens', 'Cartão', 1, 1),
(2, '2024-10-25', '10:00:00', 'Clássico com Sombrancelha', '45.00', 'Rubens', 'Cartão', 1, 1),
(3, '2024-10-25', '09:40:00', 'Corte Clássico', '35.00', 'Matheus', 'Cartão', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id_funcionario` int NOT NULL,
  `nm_funcionario` varchar(100) NOT NULL,
  `cd_login` varchar(50) NOT NULL,
  `id_nivel` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_corte`
--

CREATE TABLE `tipos_corte` (
  `id_corte` int NOT NULL,
  `nm_corte` varchar(100) NOT NULL,
  `nr_preco` decimal(10,2) NOT NULL,
  `ds_corte` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `nm_usuario` varchar(100) NOT NULL,
  `nr_telefone` varchar(15) DEFAULT NULL,
  `nm_senha` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nm_usuario`, `nr_telefone`, `nm_senha`) VALUES
(1, 'kaua', '13991726451', '2502'),
(2, 'kaua', '13991726451', '22');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id_horario`);

--
-- Índices para tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD UNIQUE KEY `cd_login` (`cd_login`);

--
-- Índices para tabela `tipos_corte`
--
ALTER TABLE `tipos_corte`
  ADD PRIMARY KEY (`id_corte`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id_horario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id_funcionario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipos_corte`
--
ALTER TABLE `tipos_corte`
  MODIFY `id_corte` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
