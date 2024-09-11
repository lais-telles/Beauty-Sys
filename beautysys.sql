-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Sep 10, 2024 at 09:29 PM
-- Server version: 10.6.12-MariaDB-1:10.6.12+maria~ubu2004-log
-- PHP Version: 8.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beautysys`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`%` PROCEDURE `adicionar_cliente` (IN `p_nome` VARCHAR(30), IN `p_data_nasc` DATE, IN `p_CPF` VARCHAR(14), IN `p_telefone` VARCHAR(15), IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(50))   BEGIN
INSERT INTO clientes (nome, data_nasc, CPF, telefone, email, senha) VALUES (p_nome, p_data_nasc, p_CPF, p_telefone, p_email, p_senha); 
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `adicionar_estabelecimento` (IN `p_razao_social` VARCHAR(30), IN `p_nome_fantasia` VARCHAR(30), IN `p_telefone` VARCHAR(15), IN `p_CNPJ` VARCHAR(18), IN `p_logradouro` VARCHAR(40), IN `p_numero` INT, IN `p_bairro` VARCHAR(15), IN `p_cidade` VARCHAR(30), IN `p_estado` VARCHAR(2), IN `p_cep` VARCHAR(9), IN `p_inicio_expediente` TIME, IN `p_termino_expediente` TIME, IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(60))   BEGIN 

INSERT INTO estabelecimentos (razao_social, nome_fantasia, telefone, CNPJ, numero, bairro, cidade, estado, cep, inicio_expediente, termino_expediente, email, senha) VALUES (p_razao_social, p_nome_fantasia, p_telefone, p_CNPJ, p_numero, p_bairro, p_cidade, p_estado, p_cep, p_inicio_expediente, p_termino_expediente, p_email, p_senha); 

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `adicionar_produto` (IN `p_nome` VARCHAR(30), IN `p_valor` FLOAT, IN `p_id_categoria` INT, IN `p_id_estabelecimento` INT)   BEGIN 
INSERT INTO produtos (nome, valor, id_categoria, id_estabelecimento) VALUES (p_nome, p_valor, p_id_categoria, p_id_estabelecimento);  
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `adicionar_profissional` (IN `p_nome` VARCHAR(30), IN `p_data_nasc` DATE, IN `p_CPF` VARCHAR(14), IN `p_telefone` VARCHAR(15), IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(50), IN `p_id_estab_vinculado` INT)   BEGIN
INSERT INTO profissionais (nome, data_nasc, CPF, telefone, email, senha, id_estab_vinculado) VALUES (p_nome, p_data_nasc, p_CPF, p_telefone, p_email, p_senha, p_id_estab_vinculado); 
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `adicionar_servico` (IN `p_nome` VARCHAR(30), IN `p_valor` FLOAT, IN `p_duracao` TIME, IN `p_id_categoria` INT, IN `p_id_estabelecimento` INT)   BEGIN 
INSERT INTO servicos (nome, valor, duracao, id_categoria, id_estabelecimento) VALUES (p_nome, p_valor, p_duracao, p_id_categoria, p_id_estabelecimento); 
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `atualizar_cliente` (IN `p_id_cliente` INT, IN `p_telefone` VARCHAR(15), IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(50))   BEGIN
UPDATE clientes SET telefone = p_telefone, email = p_email, senha = p_senha WHERE id_cliente = p_id_cliente; 
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `atualizar_estabelecimento` (IN `p_id_estabelecimento` INT, IN `p_razao_social` VARCHAR(40), IN `p_nome_fantasia` VARCHAR(40), IN `p_telefone` VARCHAR(15), IN `p_logradouro` VARCHAR(40), IN `p_numero` INT, IN `p_bairro` VARCHAR(40), IN `p_cidade` VARCHAR(40), IN `p_estado` VARCHAR(2), IN `p_cep` VARCHAR(9), IN `p_inicio_expediente` TIME, IN `p_termino_expediente` TIME, IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(255))   BEGIN  
UPDATE estabelecimentos SET razao_social = p_razao_social, nome_fantasia = p_nome_fantasia, telefone = p_telefone, logradouro = p_logradouro, numero = p_numero, bairro = p_bairro, cidade = p_cidade, estado = p_estado, cep = p_cep, inicio_expediente = p_inicio_expediente, termino_expediente = p_termino_expediente, email = p_email, senha = p_senha WHERE id_estabelecimento = p_id_estabelecimento;   
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `atualizar_profissional` (IN `p_id_profissional` INT, IN `p_telefone` VARCHAR(15), IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(50), IN `p_id_estab_vinculado` INT)   BEGIN 
UPDATE profissionais SET telefone = p_telefone, email = p_email, senha = p_senha , id_estab_vinculado = p_id_estab_vinculado WHERE id_profissional = p_id_profissional; 
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `exibir_agendamentos_cliente` (IN `p_id_cliente` INT)   BEGIN
SELECT a.id_agendamento, a.id_profissional, p.nome, a.id_opcaopag, a.data_agendamento, a.horario_inicio, a.horario_termino, a.valor_total
FROM agendamentos AS a
JOIN profissionais AS p ON a.id_profissional = p.id_profissional
WHERE id_cliente = p_id_cliente;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `exibir_agendamentos_estabelecimento` (IN `p_id_estabelecimento` INT)   BEGIN 

    SELECT a.id_agendamento, 
           c.nome AS nome_cliente, 
           a.data_realizacao, 
           a.valor_total, 
           a.horario_inicio, 
           a.horario_termino  
    FROM agendamentos AS a  
    JOIN clientes AS c ON a.id_cliente = c.id_cliente  
    JOIN profissionais AS p ON a.id_profissional = p.id_profissional  
    WHERE p.id_estab_vinculado = p_id_estabelecimento;  

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `exibir_agendamentos_profissional` (IN `p_id_profissional` INT)   BEGIN
SELECT a.id_agendamento, clientes.nome, a.data_realizacao, a.horario_inicio, a.horario_termino, a.valor_total, a.id_profissional
FROM agendamentos AS a
JOIN clientes ON a.id_cliente = clientes.id_cliente
WHERE a.id_profissional = p_id_profissional;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `exibir_pedidos_cliente` (IN `p_id_cliente` INT)   BEGIN
SELECT id_pedido, data_compra, id_status, valor_total  
FROM pedidos  
WHERE id_cliente = p_id_cliente; 
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `exibir_produtos_cat` (IN `p_id_categoria` INT)   BEGIN
SELECT nome, valor, id_estabelecimento
FROM produtos
WHERE id_categoria = p_id_categoria;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `exibir_produtos_mais_populares_por_estabelecimento` (IN `id_estabelecimento` INT)   BEGIN
  SELECT 
    p.nome AS produto,
    SUM(ip.qtd_item) AS total_vendas
  FROM 
    produtos p
  INNER JOIN itens_pedido ip ON p.id_produto = ip.id_produto
  INNER JOIN pedidos pe ON ip.id_pedido = pe.id_pedido
  WHERE p.id_estabelecimento = id_estabelecimento
  GROUP BY p.id_produto
  ORDER BY total_vendas DESC;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `exibir_profissionais_vinculados` (IN `p_id_estabelecimento` INT)   BEGIN
SELECT p.nome, p.data_nasc, p.CPF, p.telefone, p.email, p.id_estab_vinculado
FROM profissionais AS p 
WHERE id_estab_vinculado = p_id_estabelecimento; 
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `exibir_servicos_cat` (IN `p_id_categoria` INT)   BEGIN 
SELECT nome, valor, duracao, id_estabelecimento 
FROM servicos
WHERE id_categoria = p_id_categoria;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `exibir_servicos_mais_populares_por_estabelecimento` (IN `p_id_estabelecimento` INT)   BEGIN 
  SELECT  
    s.nome AS serviço, 
    COUNT(sa.id_servico) AS total_agendamentos 
  FROM  
    servicos s 
  INNER JOIN servicos_agendamentos sa ON s.id_servico = sa.id_servico 
  INNER JOIN agendamentos a ON sa.id_agendamento = a.id_agendamento 
  WHERE s.id_estabelecimento = p_id_estabelecimento 
  GROUP BY s.id_servico 
  ORDER BY total_agendamentos DESC; 
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `faturamento_estabelecimento` (IN `p_id_estabelecimento` INT)   BEGIN
    -- Faturamento por Agendamentos
    SELECT 
        YEAR(a.data_realizacao) AS ano,
        MONTH(a.data_realizacao) AS mes,
        'agendamentos' AS origem,
        SUM(a.valor_total) AS faturamento
    FROM 
        agendamentos a
    INNER JOIN 
        servicos_agendamentos sa ON a.id_agendamento = sa.id_agendamento
    INNER JOIN 
        servicos s ON sa.id_servico = s.id_servico
    WHERE 
        s.id_estabelecimento = p_id_estabelecimento
    GROUP BY 
        YEAR(a.data_realizacao), MONTH(a.data_realizacao)

    UNION ALL

    -- Faturamento por Pedidos
    SELECT 
        YEAR(p.data_compra) AS ano,
        MONTH(p.data_compra) AS mes,
        'pedidos' AS origem,
        SUM(p.valor_total) AS faturamento
    FROM 
        pedidos p
    WHERE 
        p.id_pedido IN (
            SELECT i.id_pedido
            FROM itens_pedido i
            INNER JOIN produtos pr ON i.id_produto = pr.id_produto
            WHERE pr.id_estabelecimento = p_id_estabelecimento
        )
    GROUP BY 
        YEAR(p.data_compra), MONTH(p.data_compra);

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `profissionais_agendamentos` (IN `p_id_estabelecimento` INT)   BEGIN
    SELECT 
        p.nome AS nome_profissional, 
        a.data_realizacao, 
        a.valor_total
    FROM 
        profissionais p
    JOIN 
        agendamentos a ON p.id_profissional = a.id_profissional
    WHERE 
        p.id_estab_vinculado = p_id_estabelecimento
    ORDER BY 
        p.nome, a.data_realizacao;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `profissionais_populares` (IN `p_id_estabelecimento` INT)   BEGIN
    SELECT 
        p.nome AS nome_profissional, 
        COUNT(a.id_profissional) AS total_agendamentos
    FROM 
        profissionais p
    JOIN 
        agendamentos a ON p.id_profissional = a.id_profissional
    WHERE 
        p.id_estab_vinculado = p_id_estabelecimento
    GROUP BY 
        p.nome
    ORDER BY 
        total_agendamentos DESC;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `realizarPesquisa` (IN `termo_pesquisa` VARCHAR(30))   BEGIN 

    -- Pesquisa na tabela produto
    SELECT id_produto AS id, nome AS descricao, valor 
    FROM produtos
    WHERE nome LIKE CONCAT('%', termo_pesquisa, '%')
    
    UNION
    
    -- Pesquisa na tabela estabelecimentos
    SELECT id_estabelecimento AS id, nome_fantasia AS descricao, NULL AS valor 
    FROM estabelecimentos 
    WHERE nome_fantasia LIKE CONCAT('%', termo_pesquisa, '%')
    OR razao_social LIKE CONCAT('%', termo_pesquisa, '%')
    
    UNION
    
    -- Pesquisa na tabela profissionais
    SELECT id_profissional AS id, nome AS descricao, NULL AS valor 
    FROM profissionais 
    WHERE nome LIKE CONCAT('%', termo_pesquisa, '%')
    
    UNION
    
    -- Pesquisa na tabela servicos
    SELECT id_servico AS id, nome AS descricao, valor 
    FROM servicos 
    WHERE nome LIKE CONCAT('%', termo_pesquisa, '%');

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id_agendamento` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_profissional` int(11) DEFAULT NULL,
  `id_opcaopag` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `data_realizacao` datetime DEFAULT NULL,
  `data_agendamento` date DEFAULT NULL,
  `horario_inicio` time DEFAULT NULL,
  `horario_termino` time DEFAULT NULL,
  `valor_total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agendamentos`
--

INSERT INTO `agendamentos` (`id_agendamento`, `id_cliente`, `id_profissional`, `id_opcaopag`, `id_status`, `data_realizacao`, `data_agendamento`, `horario_inicio`, `horario_termino`, `valor_total`) VALUES
(6, 1, 2, 1, 1, '2024-09-11 18:25:24', '2024-09-04', '18:20:24', '18:50:26', 50);

-- --------------------------------------------------------

--
-- Stand-in structure for view `agendamentos_status`
-- (See below for the actual view)
--
CREATE TABLE `agendamentos_status` (
`nome_servico` varchar(50)
,`data_agendamento` date
,`horario_inicio` time
,`horario_termino` time
,`status_descricao` varchar(20)
,`nome_profissional` varchar(50)
,`nome_estabelecimento` varchar(40)
);

-- --------------------------------------------------------

--
-- Table structure for table `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id_avaliacao` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `nota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorias_produto`
--

CREATE TABLE `categorias_produto` (
  `id_categoria` int(11) NOT NULL,
  `descricao` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias_produto`
--

INSERT INTO `categorias_produto` (`id_categoria`, `descricao`) VALUES
(1, 'beleza');

-- --------------------------------------------------------

--
-- Table structure for table `categorias_servico`
--

CREATE TABLE `categorias_servico` (
  `id_categoria` int(11) NOT NULL,
  `descricao` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias_servico`
--

INSERT INTO `categorias_servico` (`id_categoria`, `descricao`) VALUES
(1, 'cortes');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `CPF` varchar(14) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome`, `data_nasc`, `CPF`, `telefone`, `email`, `senha`) VALUES
(1, 'rodrigo', '2001-03-02', '123.568.789-51', '(11) 36589-1256', 'rodrigo_feitosa@gmail.com', '12646');

--
-- Triggers `clientes`
--
DELIMITER $$
CREATE TRIGGER `atualizacao_cliente` AFTER UPDATE ON `clientes` FOR EACH ROW BEGIN 
-- Verifica se o campo 'telefone' foi alterado 
    IF OLD.telefone != NEW.telefone THEN 
        INSERT INTO historico_clientes (id_cliente, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_cliente , 'telefone', OLD.telefone, NEW.telefone, NOW()); 
    END IF;
    -- Verifica se o campo 'email' foi alterado 
    IF OLD.email != NEW.email THEN 
        INSERT INTO historico_clientes (id_cliente,  campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_cliente , 'email', OLD.email, NEW.email, NOW()); 
    END IF; 
    -- Verifica se o campo 'senha' foi alterado 
    IF OLD.senha != NEW.senha THEN 
        INSERT INTO historico_clientes (id_cliente, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_cliente , 'senha', OLD.senha, NEW.senha, NOW()); 
    END IF; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `enderecos`
--

CREATE TABLE `enderecos` (
  `id_endereco` int(11) NOT NULL,
  `estado` varchar(40) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `bairro` varchar(40) DEFAULT NULL,
  `logradouro` varchar(40) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `CEP` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `estado`, `cidade`, `bairro`, `logradouro`, `numero`, `CEP`) VALUES
(1, 'SP', 'Campinas', 'São Gabriel', 'Rua 1', 168, '13183-271');

-- --------------------------------------------------------

--
-- Table structure for table `enderecos_clientes`
--

CREATE TABLE `enderecos_clientes` (
  `id_cliente` int(11) NOT NULL,
  `id_endereco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enderecos_clientes`
--

INSERT INTO `enderecos_clientes` (`id_cliente`, `id_endereco`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `estabelecimentos`
--

CREATE TABLE `estabelecimentos` (
  `id_estabelecimento` int(11) NOT NULL,
  `razao_social` varchar(40) DEFAULT NULL,
  `nome_fantasia` varchar(40) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `CNPJ` varchar(18) DEFAULT NULL,
  `logradouro` varchar(40) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `bairro` varchar(40) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `CEP` varchar(9) DEFAULT NULL,
  `inicio_expediente` time DEFAULT NULL,
  `termino_expediente` time DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estabelecimentos`
--

INSERT INTO `estabelecimentos` (`id_estabelecimento`, `razao_social`, `nome_fantasia`, `telefone`, `CNPJ`, `logradouro`, `numero`, `bairro`, `cidade`, `estado`, `CEP`, `inicio_expediente`, `termino_expediente`, `email`, `senha`) VALUES
(1, 'Empresa X', 'Estética teste', '999999999', '00.123.456/0001-00', 'Rua A', 100, 'Centro', 'Cidade A', 'SP', '12345-678', '08:00:00', '18:00:00', 'contato@esteticax.com', 'senha456'),
(3, 'Empresa Y', 'Estética teste2', '199999999', '00.123.456/0001-10', 'Rua C', 121, 'Centro', 'Cidade A', 'SP', '12345-678', '08:00:00', '18:00:00', 'contato@esteticax.com', 'senha456');

--
-- Triggers `estabelecimentos`
--
DELIMITER $$
CREATE TRIGGER `atualizacao_estabelecimento` AFTER UPDATE ON `estabelecimentos` FOR EACH ROW BEGIN 
    -- Verifica se o campo nome_fantasia foi alterado 
    IF OLD.nome_fantasia != NEW.nome_fantasia THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'nome_fantasia', OLD.nome_fantasia, NEW.nome_fantasia, NOW()); 
    END IF; 

    -- Verifica se o campo telefone foi alterado 
    IF OLD.telefone != NEW.telefone THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'telefone', OLD.telefone, NEW.telefone, NOW()); 
    END IF; 

    -- Verifica se o campo logradouro foi alterado 
    IF OLD.logradouro != NEW.logradouro THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'logradouro', OLD.logradouro, NEW.logradouro, NOW()); 
    END IF; 

    -- Verifica se o campo numero foi alterado 
    IF OLD.numero != NEW.numero THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'numero', OLD.numero, NEW.numero, NOW()); 
    END IF; 

    -- Verifica se o campo bairro foi alterado 
    IF OLD.bairro != NEW.bairro THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'bairro', OLD.bairro, NEW.bairro, NOW()); 
    END IF;
                
    -- Verifica se o campo cidade foi alterado 
    IF OLD.cidade != NEW.cidade THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'cidade', OLD.cidade, NEW.cidade, NOW()); 
    END IF;
                
    -- Verifica se o campo estado foi alterado 
    IF OLD.estado != NEW.estado THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'estado', OLD.estado, NEW.estado, NOW()); 
    END IF;
                
    -- Verifica se o campo cep foi alterado 
    IF OLD.cep != NEW.cep THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'cep', OLD.cep, NEW.cep, NOW()); 
    END IF; 

    -- Verifica se o campo inicio_expediente foi alterado 
    IF OLD.inicio_expediente != NEW.inicio_expediente THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'inicio_expediente', OLD.inicio_expediente, NEW.inicio_expediente, NOW()); 
    END IF;

    -- Verifica se o campo final_expediente foi alterado 
    IF OLD.termino_expediente != NEW.termino_expediente THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'final_expediente', OLD.termino_expediente, NEW.termino_expediente, NOW()); 
    END IF; 

    -- Verifica se o campo email foi alterado 
    IF OLD.email != NEW.email THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'email', OLD.email, NEW.email, NOW()); 
    END IF; 

    -- Verifica se o campo senha foi alterado 
    IF OLD.senha != NEW.senha THEN 
        INSERT INTO historico_estabelecimentos (id_estabelecimento, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_estabelecimento, 'senha', OLD.senha, NEW.senha, NOW()); 
    END IF; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `formas_pagamentos`
--

CREATE TABLE `formas_pagamentos` (
  `id_opcaopag` int(11) NOT NULL,
  `descricao` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `formas_pagamentos`
--

INSERT INTO `formas_pagamentos` (`id_opcaopag`, `descricao`) VALUES
(1, 'Pix');

-- --------------------------------------------------------

--
-- Table structure for table `grades_horario`
--

CREATE TABLE `grades_horario` (
  `id_grade` int(11) NOT NULL,
  `id_profissional` int(11) DEFAULT NULL,
  `dia_semana` int(11) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_termino` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historico_clientes`
--

CREATE TABLE `historico_clientes` (
  `id_alteracao` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `campo_alterado` varchar(25) DEFAULT NULL,
  `valor_antigo` varchar(30) DEFAULT NULL,
  `valor_novo` varchar(30) DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historico_clientes`
--

INSERT INTO `historico_clientes` (`id_alteracao`, `id_cliente`, `campo_alterado`, `valor_antigo`, `valor_novo`, `data_alteracao`) VALUES
(1, 1, 'email', 'rodrigo@gmail.com', 'rodrigo_feitosa@gmail.com', '2024-09-10 15:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `historico_estabelecimentos`
--

CREATE TABLE `historico_estabelecimentos` (
  `id_alteracao` int(11) NOT NULL,
  `id_estabelecimento` int(11) DEFAULT NULL,
  `campo_alterado` varchar(25) DEFAULT NULL,
  `valor_antigo` varchar(30) DEFAULT NULL,
  `valor_novo` varchar(30) DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historico_estabelecimentos`
--

INSERT INTO `historico_estabelecimentos` (`id_alteracao`, `id_estabelecimento`, `campo_alterado`, `valor_antigo`, `valor_novo`, `data_alteracao`) VALUES
(1, 1, 'nome_fantasia', 'Estética X', 'Estética teste', '2024-09-10 16:04:07'),
(2, 3, 'nome_fantasia', 'Estética Y', 'Estética teste2', '2024-09-10 16:09:14'),
(3, 3, 'logradouro', 'Rua B', 'Rua C', '2024-09-10 16:09:50'),
(4, 3, 'numero', '120', '121', '2024-09-10 16:09:50');

-- --------------------------------------------------------

--
-- Table structure for table `historico_profissionais`
--

CREATE TABLE `historico_profissionais` (
  `id_alteracao` int(11) NOT NULL,
  `id_profissional` int(11) DEFAULT NULL,
  `campo_alterado` varchar(25) DEFAULT NULL,
  `valor_antigo` varchar(30) DEFAULT NULL,
  `valor_novo` varchar(30) DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historico_profissionais`
--

INSERT INTO `historico_profissionais` (`id_alteracao`, `id_profissional`, `campo_alterado`, `valor_antigo`, `valor_novo`, `data_alteracao`) VALUES
(1, 1, 'email', 'joao@example.com', 'joao_teste@example.com', '2024-09-10 15:29:47');

-- --------------------------------------------------------

--
-- Table structure for table `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qtd_item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itens_pedido`
--

INSERT INTO `itens_pedido` (`id_pedido`, `id_produto`, `qtd_item`) VALUES
(1, 1, 1),
(2, 1, 2),
(4, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL,
  `id_opcaopag` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `data_compra` datetime DEFAULT NULL,
  `valor_total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_cliente`, `id_endereco`, `id_opcaopag`, `id_status`, `data_compra`, `valor_total`) VALUES
(1, 1, 1, 1, 1, '2024-09-04 13:33:55', 100),
(2, 1, 1, 1, 1, '2024-09-01 13:43:57', 500),
(4, 1, 1, 1, 2, '2024-08-01 16:40:46', 69);

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_estabelecimento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome`, `valor`, `id_categoria`, `id_estabelecimento`) VALUES
(1, 'loção', 12.5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profissionais`
--

CREATE TABLE `profissionais` (
  `id_profissional` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `CPF` varchar(14) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `id_estab_vinculado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profissionais`
--

INSERT INTO `profissionais` (`id_profissional`, `nome`, `data_nasc`, `CPF`, `telefone`, `email`, `senha`, `id_estab_vinculado`) VALUES
(1, 'João', '1985-02-15', '987.654.321-00', '987654321', 'joao_teste@example.com', 'senha789', 1),
(2, 'Jorge', '1985-02-15', '987.654.321-00', '987654321', 'joao@example.com', 'senha789', 3),
(3, 'Luis', '2006-09-08', '665646465', '6546546', 'luis@gmail.com', '1223542', 1);

--
-- Triggers `profissionais`
--
DELIMITER $$
CREATE TRIGGER `atualizacao_profissional` AFTER UPDATE ON `profissionais` FOR EACH ROW BEGIN 
    -- Verifica se o campo 'telefone' foi alterado 
    IF OLD.telefone != NEW.telefone THEN 
        INSERT INTO historico_profissionais (id_profissional, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_profissional, 'telefone', OLD.telefone, NEW.telefone, NOW()); 
    END IF; 

    -- Verifica se o campo 'email' foi alterado 
    IF OLD.email != NEW.email THEN 
        INSERT INTO historico_profissionais (id_profissional, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_profissional, 'email', OLD.email, NEW.email, NOW()); 
    END IF; 

    -- Verifica se o campo 'senha' foi alterado 
    IF OLD.senha != NEW.senha THEN 
        INSERT INTO historico_profissionais (id_profissional, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_profissional, 'senha', OLD.senha, NEW.senha, NOW()); 
    END IF; 

    -- Verifica se o campo 'id_estab_vinculado' foi alterado 
    IF OLD.id_estab_vinculado != NEW.id_estab_vinculado THEN 
        INSERT INTO historico_profissionais (id_profissional, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_profissional, 'id_estab_vinculado', OLD.id_estab_vinculado, NEW.id_estab_vinculado, NOW()); 
    END IF; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `profissionais_agendamentos`
-- (See below for the actual view)
--
CREATE TABLE `profissionais_agendamentos` (
`nome` varchar(50)
,`data_realizacao` datetime
,`valor_total` float
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `profissionais_populares`
-- (See below for the actual view)
--
CREATE TABLE `profissionais_populares` (
`nome` varchar(50)
,`total_agendamentos` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `servicos`
--

CREATE TABLE `servicos` (
  `id_servico` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `duracao` time DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_estabelecimento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servicos`
--

INSERT INTO `servicos` (`id_servico`, `nome`, `valor`, `duracao`, `id_categoria`, `id_estabelecimento`) VALUES
(2, 'Degradê', 50, '00:30:00', 1, 1),
(3, 'social', 56, '00:22:38', 1, 1),
(4, 'trança', 689, '08:07:03', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `servicos_agendamentos`
--

CREATE TABLE `servicos_agendamentos` (
  `id_agendamento` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servicos_agendamentos`
--

INSERT INTO `servicos_agendamentos` (`id_agendamento`, `id_servico`) VALUES
(6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `status_agendamentos`
--

CREATE TABLE `status_agendamentos` (
  `id_status` int(11) NOT NULL,
  `descricao` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_agendamentos`
--

INSERT INTO `status_agendamentos` (`id_status`, `descricao`) VALUES
(1, 'Aguardando aprovação');

-- --------------------------------------------------------

--
-- Table structure for table `status_pedidos`
--

CREATE TABLE `status_pedidos` (
  `id_status` int(11) NOT NULL,
  `descricao` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_pedidos`
--

INSERT INTO `status_pedidos` (`id_status`, `descricao`) VALUES
(1, 'Em processamento'),
(2, 'Em entrega');

-- --------------------------------------------------------

--
-- Structure for view `agendamentos_status`
--
DROP TABLE IF EXISTS `agendamentos_status`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `agendamentos_status`  AS SELECT `s`.`nome` AS `nome_servico`, `a`.`data_agendamento` AS `data_agendamento`, `a`.`horario_inicio` AS `horario_inicio`, `a`.`horario_termino` AS `horario_termino`, `sa`.`descricao` AS `status_descricao`, `p`.`nome` AS `nome_profissional`, `e`.`nome_fantasia` AS `nome_estabelecimento` FROM (((((`agendamentos` `a` join `status_agendamentos` `sa` on(`sa`.`id_status` = `a`.`id_status`)) join `servicos_agendamentos` `sa2` on(`sa2`.`id_agendamento` = `a`.`id_agendamento`)) join `servicos` `s` on(`sa2`.`id_servico` = `s`.`id_servico`)) join `profissionais` `p` on(`a`.`id_profissional` = `p`.`id_profissional`)) join `estabelecimentos` `e` on(`s`.`id_estabelecimento` = `e`.`id_estabelecimento`))  ;

-- --------------------------------------------------------

--
-- Structure for view `profissionais_agendamentos`
--
DROP TABLE IF EXISTS `profissionais_agendamentos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `profissionais_agendamentos`  AS SELECT `profissionais`.`nome` AS `nome`, `agendamentos`.`data_realizacao` AS `data_realizacao`, `agendamentos`.`valor_total` AS `valor_total` FROM (`profissionais` join `agendamentos` on(`profissionais`.`id_profissional` = `agendamentos`.`id_profissional`))  ;

-- --------------------------------------------------------

--
-- Structure for view `profissionais_populares`
--
DROP TABLE IF EXISTS `profissionais_populares`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `profissionais_populares`  AS SELECT `profissionais`.`nome` AS `nome`, count(`agendamentos`.`id_profissional`) AS `total_agendamentos` FROM (`profissionais` join `agendamentos` on(`profissionais`.`id_profissional` = `agendamentos`.`id_profissional`)) GROUP BY `profissionais`.`nome` ORDER BY count(`agendamentos`.`id_profissional`) AS `DESCdesc` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id_agendamento`),
  ADD KEY `fk_agendamentos01` (`id_cliente`),
  ADD KEY `fk_agendamentos02` (`id_profissional`),
  ADD KEY `fk_agendamentos03` (`id_opcaopag`),
  ADD KEY `fk_agendamentos04` (`id_status`);

--
-- Indexes for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id_avaliacao`),
  ADD KEY `fk_avaliacoes01` (`id_pedido`),
  ADD KEY `fk_avaliacoes02` (`id_cliente`);

--
-- Indexes for table `categorias_produto`
--
ALTER TABLE `categorias_produto`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `categorias_servico`
--
ALTER TABLE `categorias_servico`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id_endereco`);

--
-- Indexes for table `enderecos_clientes`
--
ALTER TABLE `enderecos_clientes`
  ADD PRIMARY KEY (`id_cliente`,`id_endereco`),
  ADD KEY `fk_endereco_cliente01` (`id_endereco`);

--
-- Indexes for table `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  ADD PRIMARY KEY (`id_estabelecimento`);

--
-- Indexes for table `formas_pagamentos`
--
ALTER TABLE `formas_pagamentos`
  ADD PRIMARY KEY (`id_opcaopag`);

--
-- Indexes for table `grades_horario`
--
ALTER TABLE `grades_horario`
  ADD PRIMARY KEY (`id_grade`),
  ADD KEY `fk_grades_horario` (`id_profissional`);

--
-- Indexes for table `historico_clientes`
--
ALTER TABLE `historico_clientes`
  ADD PRIMARY KEY (`id_alteracao`),
  ADD KEY `fk_historico_clientes01` (`id_cliente`);

--
-- Indexes for table `historico_estabelecimentos`
--
ALTER TABLE `historico_estabelecimentos`
  ADD PRIMARY KEY (`id_alteracao`),
  ADD KEY `fk_historico_estabelecimentos01` (`id_estabelecimento`);

--
-- Indexes for table `historico_profissionais`
--
ALTER TABLE `historico_profissionais`
  ADD PRIMARY KEY (`id_alteracao`),
  ADD KEY `fk_historico_profissionais01` (`id_profissional`);

--
-- Indexes for table `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id_pedido`,`id_produto`),
  ADD KEY `fk_itens_pedido02` (`id_produto`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedidos01` (`id_cliente`),
  ADD KEY `fk_pedidos02` (`id_endereco`),
  ADD KEY `fk_pedidos03` (`id_opcaopag`),
  ADD KEY `fk_pedidos04` (`id_status`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `fk_produtos01` (`id_categoria`),
  ADD KEY `fk_produtos02` (`id_estabelecimento`);

--
-- Indexes for table `profissionais`
--
ALTER TABLE `profissionais`
  ADD PRIMARY KEY (`id_profissional`);

--
-- Indexes for table `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `fk_servicos01` (`id_categoria`),
  ADD KEY `fk_servicos02` (`id_estabelecimento`);

--
-- Indexes for table `servicos_agendamentos`
--
ALTER TABLE `servicos_agendamentos`
  ADD PRIMARY KEY (`id_agendamento`,`id_servico`),
  ADD KEY `fk_servicos_agendamentos02` (`id_servico`);

--
-- Indexes for table `status_agendamentos`
--
ALTER TABLE `status_agendamentos`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `status_pedidos`
--
ALTER TABLE `status_pedidos`
  ADD PRIMARY KEY (`id_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id_agendamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias_produto`
--
ALTER TABLE `categorias_produto`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categorias_servico`
--
ALTER TABLE `categorias_servico`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  MODIFY `id_estabelecimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `formas_pagamentos`
--
ALTER TABLE `formas_pagamentos`
  MODIFY `id_opcaopag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grades_horario`
--
ALTER TABLE `grades_horario`
  MODIFY `id_grade` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historico_clientes`
--
ALTER TABLE `historico_clientes`
  MODIFY `id_alteracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `historico_estabelecimentos`
--
ALTER TABLE `historico_estabelecimentos`
  MODIFY `id_alteracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `historico_profissionais`
--
ALTER TABLE `historico_profissionais`
  MODIFY `id_alteracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profissionais`
--
ALTER TABLE `profissionais`
  MODIFY `id_profissional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `status_agendamentos`
--
ALTER TABLE `status_agendamentos`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status_pedidos`
--
ALTER TABLE `status_pedidos`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `fk_agendamentos01` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `fk_agendamentos02` FOREIGN KEY (`id_profissional`) REFERENCES `profissionais` (`id_profissional`),
  ADD CONSTRAINT `fk_agendamentos03` FOREIGN KEY (`id_opcaopag`) REFERENCES `formas_pagamentos` (`id_opcaopag`),
  ADD CONSTRAINT `fk_agendamentos04` FOREIGN KEY (`id_status`) REFERENCES `status_agendamentos` (`id_status`);

--
-- Constraints for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `fk_avaliacoes01` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `fk_avaliacoes02` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Constraints for table `enderecos_clientes`
--
ALTER TABLE `enderecos_clientes`
  ADD CONSTRAINT `fk_endereco_cliente01` FOREIGN KEY (`id_endereco`) REFERENCES `enderecos` (`id_endereco`),
  ADD CONSTRAINT `fk_endereco_cliente02` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Constraints for table `grades_horario`
--
ALTER TABLE `grades_horario`
  ADD CONSTRAINT `fk_grades_horario` FOREIGN KEY (`id_profissional`) REFERENCES `profissionais` (`id_profissional`);

--
-- Constraints for table `historico_clientes`
--
ALTER TABLE `historico_clientes`
  ADD CONSTRAINT `fk_historico_clientes01` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Constraints for table `historico_estabelecimentos`
--
ALTER TABLE `historico_estabelecimentos`
  ADD CONSTRAINT `fk_historico_estabelecimentos01` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimentos` (`id_estabelecimento`);

--
-- Constraints for table `historico_profissionais`
--
ALTER TABLE `historico_profissionais`
  ADD CONSTRAINT `fk_historico_profissionais01` FOREIGN KEY (`id_profissional`) REFERENCES `profissionais` (`id_profissional`);

--
-- Constraints for table `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `fk_itens_pedido01` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `fk_itens_pedido02` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`);

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos01` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `fk_pedidos02` FOREIGN KEY (`id_endereco`) REFERENCES `enderecos` (`id_endereco`),
  ADD CONSTRAINT `fk_pedidos03` FOREIGN KEY (`id_opcaopag`) REFERENCES `formas_pagamentos` (`id_opcaopag`),
  ADD CONSTRAINT `fk_pedidos04` FOREIGN KEY (`id_status`) REFERENCES `status_pedidos` (`id_status`);

--
-- Constraints for table `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos01` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_produto` (`id_categoria`),
  ADD CONSTRAINT `fk_produtos02` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimentos` (`id_estabelecimento`);

--
-- Constraints for table `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `fk_servicos01` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_servico` (`id_categoria`),
  ADD CONSTRAINT `fk_servicos02` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimentos` (`id_estabelecimento`);

--
-- Constraints for table `servicos_agendamentos`
--
ALTER TABLE `servicos_agendamentos`
  ADD CONSTRAINT `fk_servicos_agendamentos01` FOREIGN KEY (`id_agendamento`) REFERENCES `agendamentos` (`id_agendamento`),
  ADD CONSTRAINT `fk_servicos_agendamentos02` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;