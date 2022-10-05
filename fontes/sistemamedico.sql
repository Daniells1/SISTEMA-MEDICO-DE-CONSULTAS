-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Out-2022 às 06:37
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistemamedico`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbconsulta`
--

CREATE TABLE `tbconsulta` (
  `id` int(11) NOT NULL,
  `dt_consulta` date DEFAULT NULL,
  `hr_consulta` time DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `consulta` text DEFAULT NULL,
  `medico_id` int(11) DEFAULT NULL,
  `especialidade_id` int(11) DEFAULT NULL,
  `paciente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbconsulta`
--

INSERT INTO `tbconsulta` (`id`, `dt_consulta`, `hr_consulta`, `status`, `consulta`, `medico_id`, `especialidade_id`, `paciente_id`) VALUES
(1, '2022-04-30', '12:30:00', 'FIN', '<p><span style=\"color: royalblue;\">Paciente chegou </span>com <strong>muita dor.</strong></p>', 9, 2, 9),
(2, '2022-04-30', '12:30:00', 'ATV', NULL, 9, 2, 9),
(3, '2022-04-30', '12:30:00', 'CAN', NULL, 9, 2, 9),
(11, '2022-04-30', '12:30:00', 'CAN', '', 1, 1, 9),
(12, '2022-04-30', '21:00:00', 'ATV', NULL, 1, 1, 9),
(13, '2022-04-30', '18:00:00', 'ATV', NULL, 1, 1, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbespecialidade`
--

CREATE TABLE `tbespecialidade` (
  `id` int(11) NOT NULL,
  `especialidade` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbespecialidade`
--

INSERT INTO `tbespecialidade` (`id`, `especialidade`) VALUES
(1, 'Clínico Geral'),
(2, 'Pediatra'),
(3, 'Ortopedista'),
(4, 'Psiquiatra'),
(5, 'Neurocirurgião'),
(6, 'Cardiologista'),
(7, 'Otorrinolaringologista'),
(8, 'Urologista'),
(9, 'Oftalmologista'),
(11, 'Radiologia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbespecialidademedico`
--

CREATE TABLE `tbespecialidademedico` (
  `especialidade_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbespecialidademedico`
--

INSERT INTO `tbespecialidademedico` (`especialidade_id`, `medico_id`) VALUES
(1, 1),
(2, 9),
(2, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbmedico`
--

CREATE TABLE `tbmedico` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `crm` varchar(45) DEFAULT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbmedico`
--

INSERT INTO `tbmedico` (`id`, `nome`, `crm`, `foto`) VALUES
(1, 'José da Silva Santos', '123456', '202208211729166440.jpg'),
(2, 'Diego', '111222', '202208210342287829.jpg'),
(3, 'Roberto', '222111', '202208210057132212.jpg'),
(9, 'MARIANA BATISTA DE SOUZA SANTOS', '147147', '202208211729458576.jpg'),
(10, 'Douglas', '425244', '202208280001264055.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbpaciente`
--

CREATE TABLE `tbpaciente` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbpaciente`
--

INSERT INTO `tbpaciente` (`id`, `nome`, `cpf`, `foto`) VALUES
(9, 'Luiz', '12345678909', '202208230308274239.jpeg');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tbconsulta`
--
ALTER TABLE `tbconsulta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medico_consulta` (`medico_id`),
  ADD KEY `paciente_consulta` (`paciente_id`),
  ADD KEY `especialidade_consulta` (`especialidade_id`);

--
-- Índices para tabela `tbespecialidade`
--
ALTER TABLE `tbespecialidade`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tbespecialidademedico`
--
ALTER TABLE `tbespecialidademedico`
  ADD PRIMARY KEY (`especialidade_id`,`medico_id`),
  ADD KEY `medico_especialidademedico` (`medico_id`,`especialidade_id`) USING BTREE;

--
-- Índices para tabela `tbmedico`
--
ALTER TABLE `tbmedico`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crm` (`crm`);

--
-- Índices para tabela `tbpaciente`
--
ALTER TABLE `tbpaciente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbconsulta`
--
ALTER TABLE `tbconsulta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `tbespecialidade`
--
ALTER TABLE `tbespecialidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tbmedico`
--
ALTER TABLE `tbmedico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tbpaciente`
--
ALTER TABLE `tbpaciente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tbconsulta`
--
ALTER TABLE `tbconsulta`
  ADD CONSTRAINT `especialidade_consulta` FOREIGN KEY (`especialidade_id`) REFERENCES `tbespecialidade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `medico_consulta` FOREIGN KEY (`medico_id`) REFERENCES `tbmedico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `paciente_consulta` FOREIGN KEY (`paciente_id`) REFERENCES `tbpaciente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tbespecialidademedico`
--
ALTER TABLE `tbespecialidademedico`
  ADD CONSTRAINT `especialidade_especialidademedico` FOREIGN KEY (`especialidade_id`) REFERENCES `tbespecialidade` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medico_especialidademedico` FOREIGN KEY (`medico_id`) REFERENCES `tbmedico` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
