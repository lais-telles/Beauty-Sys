-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 17, 2024 at 02:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizar_cliente` (IN `p_id_cliente` INT, IN `p_telefone` VARCHAR(15), IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(50))   BEGIN
UPDATE clientes SET telefone = p_telefone, email = p_email, senha = p_senha WHERE id_cliente = p_id_cliente; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizar_estabelecimento` (IN `p_id_estabelecimento` INT, IN `p_nome_fantasia` VARCHAR(40), IN `p_telefone` VARCHAR(15), IN `p_logradouro` VARCHAR(40), IN `p_numero` INT, IN `p_bairro` VARCHAR(40), IN `p_cidade` VARCHAR(40), IN `p_estado` VARCHAR(2), IN `p_cep` VARCHAR(9), IN `p_inicio_expediente` TIME, IN `p_termino_expediente` TIME, IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(255))   BEGIN  
UPDATE estabelecimentos SET nome_fantasia = p_nome_fantasia, telefone = p_telefone, logradouro = p_logradouro, numero = p_numero, bairro = p_bairro, cidade = p_cidade, estado = p_estado, cep = p_cep, inicio_expediente = p_inicio_expediente, termino_expediente = p_termino_expediente, email = p_email, senha = p_senha WHERE id_estabelecimento = p_id_estabelecimento;   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizar_profissional` (IN `p_id_profissional` INT, IN `p_telefone` VARCHAR(15), IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(50))   BEGIN 
UPDATE profissionais SET telefone = p_telefone, email = p_email, senha = p_senha WHERE id_profissional = p_id_profissional; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadastrar_cliente` (IN `p_nome` VARCHAR(30), IN `p_data_nasc` DATE, IN `p_CPF` VARCHAR(14), IN `p_telefone` VARCHAR(15), IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(50))   BEGIN
INSERT INTO clientes (nome, data_nasc, CPF, telefone, email, senha) VALUES (p_nome, p_data_nasc, p_CPF, p_telefone, p_email, p_senha); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadastrar_endereco` (IN `p_id_cliente` INT, IN `p_logradouro` VARCHAR(40), IN `p_numero` INT, IN `p_bairro` VARCHAR(40), IN `p_cidade` VARCHAR(40), IN `p_estado` VARCHAR(40), IN `p_CEP` VARCHAR(9))   BEGIN
    DECLARE p_id_endereco INT;

    -- Inserir o endereço
    INSERT INTO enderecos (logradouro, numero, bairro, cidade, estado, CEP) 
    VALUES (p_logradouro, p_numero, p_bairro, p_cidade, p_estado, p_CEP);

    -- Capturar o ID do endereço inserido
    SET p_id_endereco = LAST_INSERT_ID();

    -- Relacionar o endereço com o cliente
    INSERT INTO enderecos_clientes (id_cliente, id_endereco) 
    VALUES (p_id_cliente, p_id_endereco);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadastrar_estabelecimento` (IN `p_razao_social` VARCHAR(40), IN `p_nome_fantasia` VARCHAR(40), IN `p_telefone` VARCHAR(15), IN `p_CNPJ` VARCHAR(18), IN `p_logradouro` VARCHAR(40), IN `p_numero` INT, IN `p_bairro` VARCHAR(40), IN `p_cidade` VARCHAR(40), IN `p_estado` VARCHAR(2), IN `p_cep` VARCHAR(9), IN `p_inicio_expediente` TIME, IN `p_termino_expediente` TIME, IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(60))   BEGIN 

INSERT INTO estabelecimentos (razao_social, nome_fantasia, telefone, CNPJ, logradouro, numero, bairro, cidade, estado, cep, inicio_expediente, termino_expediente, email, senha) VALUES (p_razao_social, p_nome_fantasia, p_telefone, p_CNPJ, p_logradouro, p_numero, p_bairro, p_cidade, p_estado, p_cep, p_inicio_expediente, p_termino_expediente, p_email, p_senha); 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadastrar_produto` (IN `p_nome` VARCHAR(30), IN `p_valor` FLOAT, IN `p_id_categoria` INT, IN `p_id_estabelecimento` INT)   BEGIN 
INSERT INTO produtos (nome, valor, id_categoria, id_estabelecimento) VALUES (p_nome, p_valor, p_id_categoria, p_id_estabelecimento);  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadastrar_profissional` (IN `p_nome` VARCHAR(30), IN `p_data_nasc` DATE, IN `p_CPF` VARCHAR(14), IN `p_telefone` VARCHAR(15), IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(50), IN `p_id_estab_vinculado` INT)   BEGIN
INSERT INTO profissionais (nome, data_nasc, CPF, telefone, email, senha, estabel_vinculado) VALUES (p_nome, p_data_nasc, p_CPF, p_telefone, p_email, p_senha, p_id_estab_vinculado); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cadastrar_servico` (IN `p_nome` VARCHAR(30), IN `p_valor` FLOAT, IN `p_duracao` TIME, IN `p_id_categoria` INT, IN `p_id_estabelecimento` INT)   BEGIN 
INSERT INTO servicos (nome, valor, duracao, id_categoria, id_estabelecimento) VALUES (p_nome, p_valor, p_duracao, p_id_categoria, p_id_estabelecimento); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clientes_por_estabelecimento` (IN `p_id_estabelecimento` INT)   BEGIN
    SELECT COUNT(DISTINCT a.id_cliente) AS total_clientes
    FROM agendamentos AS a
    INNER JOIN profissionais AS p ON a.id_profissional = p.id_profissional
    INNER JOIN estabelecimentos AS e ON p.estabel_vinculado = e.id_estabelecimento
    WHERE e.id_estabelecimento = p_id_estabelecimento;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `consulta_grade_horaria` (IN `id_profissional_param` INT)   BEGIN
    SELECT 
    	id_grade,
        dia_semana,
        hora_inicio,
        hora_termino
    FROM 
        grades_horario
    WHERE 
        id_profissional = id_profissional_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `consulta_vinculo` (IN `id_profissional_param` INT)   BEGIN
    SELECT 
        v.id_vinculo,
        v.id_profissional,
        v.id_estabelecimento,
        e.nome_fantasia AS nome_estabelecimento,
        v.status_vinculo
    FROM 
        vinculos v
    INNER JOIN 
        estabelecimentos e ON v.id_estabelecimento = e.id_estabelecimento
    WHERE
        v.id_profissional = id_profissional_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `contagem_agendamentos` (IN `p_id_estabelecimento` INT)   BEGIN
    -- Exibe a contagem de agendamentos por mês
    SELECT 
        MONTH(a.data_realizacao) AS mes, 
        COUNT(*) AS total_agendamentos
    FROM agendamentos a
    WHERE a.id_profissional IN (
        SELECT p.id_profissional
        FROM profissionais p
        WHERE p.estabel_vinculado = p_id_estabelecimento
    )
    GROUP BY MONTH(a.data_realizacao)
    ORDER BY mes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_agendamentos_cliente` (IN `p_id_cliente` INT)   BEGIN
SELECT a.id_agendamento, a.id_profissional, p.nome AS 'profissional', fp.descricao AS 'forma_pagamento', a.data_realizacao, a.horario_inicio, a.horario_termino, a.valor_total, s.nome AS 'servico',
sa.descricao AS status
FROM agendamentos AS a
JOIN profissionais AS p ON a.id_profissional = p.id_profissional
JOIN servicos AS s ON a.id_servico = s.id_servico
JOIN formas_pagamentos AS fp ON a.id_opcaopag = fp.id_opcaopag
JOIN status_agendamentos AS sa ON a.id_status = sa.id_status
WHERE id_cliente = p_id_cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_agendamentos_estabelecimento` (IN `p_id_estabelecimento` INT)   BEGIN 

    SELECT a.id_agendamento, 
           c.nome AS nome_cliente, 
           p.nome AS nome_profissional,
           s.nome AS servico,
           a.data_realizacao,  
           a.horario_inicio, 
           a.horario_termino,
           a.valor_total,
           fp.descricao AS forma_pagamento,
           sa.descricao AS status,
           (SELECT COUNT(*) 
            FROM agendamentos 
            WHERE id_profissional IN (
                SELECT id_profissional 
                FROM profissionais 
                WHERE estabel_vinculado = p_id_estabelecimento)) AS total_agendamentos
    FROM agendamentos AS a  
    JOIN clientes AS c ON a.id_cliente = c.id_cliente  
    JOIN profissionais AS p ON a.id_profissional = p.id_profissional  
    JOIN servicos AS s ON a.id_servico = s.id_servico
    JOIN formas_pagamentos AS fp ON a.id_opcaopag = fp.id_opcaopag
    JOIN status_agendamentos AS sa ON a.id_status = sa.id_status
    WHERE p.estabel_vinculado = p_id_estabelecimento;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_agendamentos_profissional` (IN `p_id_profissional` INT)   BEGIN
SELECT a.id_agendamento, c.nome AS nome_cliente, s.nome AS servico, a.data_realizacao, a.horario_inicio, a.horario_termino, a.valor_total, fp.descricao AS formas_pagamento, a.id_profissional, sa.descricao AS status
FROM agendamentos AS a
JOIN clientes AS c ON a.id_cliente = c.id_cliente
JOIN servicos AS s ON a.id_servico = s.id_servico
JOIN formas_pagamentos AS fp ON a.id_opcaopag = fp.id_opcaopag
JOIN status_agendamentos AS sa ON a.id_status = sa.id_status
WHERE a.id_profissional = p_id_profissional;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_pedidos_cliente` (IN `p_id_cliente` INT)   BEGIN
SELECT id_pedido, data_compra, id_status, valor_total  
FROM pedidos  
WHERE id_cliente = p_id_cliente; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_produtos_cat` (IN `p_id_categoria` INT)   BEGIN
SELECT nome, valor, id_estabelecimento
FROM produtos
WHERE id_categoria = p_id_categoria;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_produtos_mais_populares_por_estabelecimento` (IN `p_id_estabelecimento` INT)   BEGIN
  SELECT 
    p.nome AS produto,
    SUM(ip.qtd_item) AS total_vendas
  FROM 
    produtos p
  INNER JOIN itens_pedido ip ON p.id_produto = ip.id_produto
  INNER JOIN pedidos pe ON ip.id_pedido = pe.id_pedido
  WHERE p.id_estabelecimento = p_id_estabelecimento
  GROUP BY p.id_produto
  ORDER BY total_vendas DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_profissionais_vinculados` (IN `p_id_estabelecimento` INT)   BEGIN
    SELECT 
        v.id_vinculo, 
        v.id_profissional, 
        p.nome, 
        p.CPF, 
        p.telefone, 
        p.email, 
        v.status_vinculo, 
        v.data_vinculo
    FROM vinculos AS v
    JOIN profissionais AS p ON p.id_profissional = v.id_profissional
    WHERE v.id_estabelecimento = p_id_estabelecimento;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_servicos_cat` (IN `p_id_categoria` INT)   BEGIN 
SELECT nome, valor, duracao, id_estabelecimento 
FROM servicos
WHERE id_categoria = p_id_categoria;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_servicos_estabelecimento` (IN `p_id_estabelecimento` INT)   BEGIN
    SELECT 
        s.id_servico,
        s.nome,
        s.valor,
        s.duracao,
        c.descricao AS categoria,
        (SELECT COUNT(*) 
         FROM servicos 
         WHERE id_estabelecimento = p_id_estabelecimento) AS total_servicos
    FROM 
        servicos s
    LEFT JOIN 
        categorias_servico c ON s.id_categoria = c.id_categoria
    WHERE 
        s.id_estabelecimento = p_id_estabelecimento;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_servicos_mais_populares_por_estabelecimento` (IN `p_id_estabelecimento` INT)   BEGIN 
  SELECT  
    s.nome AS serviço, 
    COUNT(a.id_servico) AS total_agendamentos 
  FROM  
    servicos s 
  INNER JOIN agendamentos a ON a.id_servico = s.id_servico
  WHERE s.id_estabelecimento = p_id_estabelecimento 
  GROUP BY s.id_servico 
  ORDER BY total_agendamentos DESC; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_servicos_profissional` (IN `p_id_profissional` INT)   BEGIN
    SELECT 
        s.id_servico,
        s.nome,
        s.valor,
        s.duracao,
        c.descricao AS categoria
    FROM 
        servicos s
    INNER JOIN 
        profissionais_servicos ps ON s.id_servico = ps.id_servico
    INNER JOIN 
        profissionais p ON ps.id_profissional = p.id_profissional
    LEFT JOIN 
        categorias_servico c ON s.id_categoria = c.id_categoria
    WHERE 
        p.id_profissional = p_id_profissional
        AND s.id_estabelecimento = p.estabel_vinculado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `faturamento_estabelecimento` (IN `p_id_estabelecimento` INT)   BEGIN
    -- Faturamento por Agendamentos
    SELECT 
        YEAR(a.data_realizacao) AS ano,
        MONTH(a.data_realizacao) AS mes,
        'agendamentos' AS origem,
        SUM(a.valor_total) AS faturamento
    FROM 
        agendamentos a
    INNER JOIN 
        servicos s ON a.id_servico = s.id_servico
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `gerar_horarios` (IN `p_id_profissional` INT, IN `p_data_realizacao` DATE)   BEGIN
    DECLARE v_dia_semana INT;
    
    -- Verificar se a data de realização é uma data futura
    IF p_data_realizacao < CURDATE() THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'A data de realização deve ser uma data futura.';
    END IF;

    -- Verificar o dia da semana da data de realização
    SET v_dia_semana = CASE 
        WHEN DAYOFWEEK(p_data_realizacao) = 1 THEN 7
        ELSE DAYOFWEEK(p_data_realizacao) - 1
    END;

    -- Gerar intervalos de 30 minutos entre hora_inicio e hora_termino
    WITH RECURSIVE time_intervals AS (
        -- Iniciar com o valor de hora_inicio
        SELECT 
            gh.id_profissional,
            gh.hora_inicio AS intervalo_hora,
            gh.hora_termino
        FROM grades_horario gh
        WHERE gh.id_profissional = p_id_profissional
          AND gh.dia_semana = v_dia_semana

        UNION ALL

        -- Adicionar 30 minutos a cada iteração
        SELECT 
            t.id_profissional,
            TIMESTAMPADD(MINUTE, 30, t.intervalo_hora) AS intervalo_hora,
            t.hora_termino
        FROM time_intervals t
        WHERE TIMESTAMPADD(MINUTE, 30, t.intervalo_hora) <= t.hora_termino
    )

    -- Selecionar todos os intervalos de 30 minutos gerados que não estão ocupados por agendamentos
    SELECT ti.intervalo_hora
    FROM time_intervals ti
    WHERE NOT EXISTS (
        SELECT 1
        FROM agendamentos a
        WHERE a.id_profissional = p_id_profissional
          AND a.data_realizacao = p_data_realizacao
          AND (
              (ti.intervalo_hora >= a.horario_inicio AND ti.intervalo_hora < a.horario_termino) OR
              (TIMESTAMPADD(MINUTE, 30, ti.intervalo_hora) > a.horario_inicio AND TIMESTAMPADD(MINUTE, 30, ti.intervalo_hora) <= a.horario_termino)
          )
    )
    ORDER BY ti.intervalo_hora;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inserir_vinculo` (IN `p_estabelecimento_id` INT, IN `p_profissional_id` INT)   BEGIN
    -- Verificar se já existe um vínculo ativo entre o profissional e o estabelecimento
    DECLARE v_count INT;
    
    SELECT COUNT(*) INTO v_count
    FROM vinculos
    WHERE id_estabelecimento = p_estabelecimento_id
    AND id_profissional = p_profissional_id;

    -- Se não existir um vínculo, criar um novo com status 'pendente'
    IF v_count = 0 THEN
        INSERT INTO vinculos (id_estabelecimento, id_profissional, status_vinculo, data_vinculo)
        VALUES (p_estabelecimento_id, p_profissional_id, 'pendente', NOW());
    ELSE
        -- Se já houver um vínculo ativo, retornar uma mensagem de erro.
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Já existe um vínculo ativo entre este profissional e o estabelecimento.';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `profissionais_agendamentos` (IN `p_id_estabelecimento` INT)   BEGIN
    SELECT 
        p.nome AS nome_profissional,
        s.nome AS servico,
        a.data_realizacao, 
        a.valor_total,
        fp.descricao AS forma_pagamento
    FROM 
        profissionais p
    JOIN 
        agendamentos a ON p.id_profissional = a.id_profissional
    JOIN 
    	servicos AS s ON a.id_servico = s.id_servico
    JOIN
    	formas_pagamentos AS fp ON a.id_opcaopag = fp.id_opcaopag
    WHERE 
        p.estabel_vinculado = p_id_estabelecimento
    ORDER BY 
        p.nome, a.data_realizacao;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `profissionais_populares` (IN `p_id_estabelecimento` INT)   BEGIN
    SELECT 
        p.nome AS nome_profissional, 
        COUNT(a.id_profissional) AS total_agendamentos
    FROM 
        profissionais p
    JOIN 
        agendamentos a ON p.id_profissional = a.id_profissional
    WHERE 
        p.estabel_vinculado = p_id_estabelecimento
    GROUP BY 
        p.nome
    ORDER BY 
        total_agendamentos DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `realizarPesquisa` (IN `termo_pesquisa` VARCHAR(30))   BEGIN 

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `realizar_agendamento` (IN `p_id_cliente` INT, IN `p_id_profissional` INT, IN `p_id_opcaopag` INT, IN `p_data_realizacao` DATE, IN `p_horario_inicio` TIME, IN `p_id_servico` INT)   BEGIN
    DECLARE p_id_agendamento INT;
    DECLARE p_valor_total DECIMAL(10,2);
    DECLARE p_horario_termino TIME;

    -- Inserir o agendamento na tabela agendamentos
    INSERT INTO agendamentos (
        id_cliente, id_profissional, id_opcaopag, id_status, id_servico, data_realizacao, data_agendamento, horario_inicio
    )
    VALUES (
        p_id_cliente, p_id_profissional, p_id_opcaopag, 1, p_id_servico, p_data_realizacao, CURDATE(), p_horario_inicio
    );

    SET p_id_agendamento = LAST_INSERT_ID();

    -- Calcular o valor total
    SELECT s.valor
    INTO p_valor_total
    FROM servicos s
    JOIN agendamentos a ON s.id_servico = a.id_servico
    WHERE a.id_agendamento = p_id_agendamento;

    UPDATE agendamentos
    SET valor_total = p_valor_total
    WHERE id_agendamento = p_id_agendamento;

    -- Calcular o horário de término (assumindo que a duração do serviço está em segundos)
    SELECT ADDTIME(p_horario_inicio, s.duracao)
    INTO p_horario_termino
    FROM servicos s
    JOIn agendamentos a ON s.id_servico = a.id_servico
    WHERE a.id_agendamento = p_id_agendamento;

    UPDATE agendamentos
    SET horario_termino = p_horario_termino
    WHERE id_agendamento = p_id_agendamento;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `realizar_pedido` (IN `p_id_cliente` INT, IN `p_id_produto` INT, IN `p_id_endereco` INT, IN `p_id_opcaopag` INT, IN `p_qtd_item` INT)   BEGIN
    -- Declara a variável para armazenar o id_pedido gerado automaticamente
    DECLARE p_id_pedido INT;
    DECLARE p_valor_total DECIMAL(10,2);

    -- Inserir o pedido na tabela pedidos (id_pedido é auto_increment e id_status será sempre 1)
    INSERT INTO pedidos (
        id_cliente, id_endereco, id_opcaopag, id_status, data_compra, valor_total
    )
    VALUES (
        p_id_cliente, p_id_endereco, p_id_opcaopag, 1, NOW(), 0
    );

    -- Recupera o último id_pedido gerado automaticamente
    SET p_id_pedido = LAST_INSERT_ID();

    -- Inserir o item no pedido
    INSERT INTO itens_pedido (id_pedido, id_produto, qtd_item) 
    VALUES (p_id_pedido, p_id_produto, p_qtd_item);
    
    -- Calcular o valor total baseado na soma do preço dos produtos e quantidades
    SELECT SUM(ip.qtd_item * p.valor) 
    INTO p_valor_total
    FROM itens_pedido ip
    JOIN produtos p ON ip.id_produto = p.id_produto
    WHERE ip.id_pedido = p_id_pedido;
    
    -- Atualizar o valor total do pedido na tabela pedidos
    UPDATE pedidos
    SET valor_total = p_valor_total
    WHERE id_pedido = p_id_pedido;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vincular_servico_profissional` (IN `p_id_profissional` INT, IN `p_id_servico` INT)   BEGIN 
INSERT INTO profissionais_servicos (id_profissional, id_servico) VALUES (p_id_profissional, p_id_servico);
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
  `id_servico` int(11) DEFAULT NULL,
  `data_realizacao` date DEFAULT NULL,
  `data_agendamento` date DEFAULT NULL,
  `horario_inicio` time DEFAULT NULL,
  `horario_termino` time DEFAULT NULL,
  `valor_total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agendamentos`
--

INSERT INTO `agendamentos` (`id_agendamento`, `id_cliente`, `id_profissional`, `id_opcaopag`, `id_status`, `id_servico`, `data_realizacao`, `data_agendamento`, `horario_inicio`, `horario_termino`, `valor_total`) VALUES
(1, 1, 1, 2, 2, 1, '2024-09-16', '2024-09-13', '09:00:00', '09:30:00', 40),
(2, 2, 4, 1, 1, 2, '2024-09-18', '2024-09-13', '14:30:00', '15:00:00', 50),
(3, 3, 2, 3, 1, 3, '2024-09-18', '2024-09-13', '10:00:00', '11:00:00', 35),
(4, 3, 2, 3, 1, 3, '2024-10-24', '2024-09-13', '10:00:00', '11:00:00', 35),
(5, 1, 5, 1, 1, 5, '2024-10-28', '2024-09-26', '08:00:00', '08:40:00', 30),
(6, 2, 6, 1, 1, 4, '2024-09-30', '2024-09-26', '08:00:00', '11:00:00', 120),
(7, 3, 5, 1, 1, 7, '2024-09-30', '2024-09-26', '08:00:00', '09:00:00', 65),
(9, 1, 1, 1, 2, 1, '2024-11-02', '2024-10-13', '10:00:00', '10:30:00', 40),
(10, 1, 4, 1, 1, 2, '2024-11-03', '2024-10-13', '16:00:00', '16:30:00', 50),
(11, 1, 5, 1, 1, 7, '2024-11-04', '2024-10-13', '15:00:00', '16:00:00', 65),
(12, 1, 2, 1, 1, 3, '2024-11-05', '2024-10-13', '13:00:00', '14:00:00', 35),
(13, 1, 5, 1, 1, 5, '2024-11-04', '2024-10-14', '16:00:00', '16:40:00', 30);

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

--
-- Dumping data for table `avaliacoes`
--

INSERT INTO `avaliacoes` (`id_avaliacao`, `id_pedido`, `id_cliente`, `nota`) VALUES
(1, 1, 1, 4),
(2, 2, 2, 5),
(3, 3, 3, 3);

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
(1, 'Cabelo'),
(2, 'Limpeza Facial'),
(3, 'Unhas');

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
(1, 'Cabelo'),
(2, 'Estética Facial'),
(3, 'Unhas'),
(4, 'Combo');

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
(1, 'João Almeida da Silva', '1990-01-01', '123.456.789-00', '(19) 98908-3696', 'Luis@gmail.com', '$2y$12$VgKck1ety.bfzhajJ0XwNuMCCPfRHVWc5Nx0S0DFlssqcLPo9qZOC'),
(2, 'Amanda Cruz da Silva', '1991-01-01', '123.456.789-01', '(11) 98908-3691', 'amanda_silva@gmail.com', 'senha456'),
(3, 'Luis Carlos da Silva', '1992-01-01', '123.456.789-02', '(11) 98908-3692', 'Luis@teste.com', 'senha789'),
(4, 'Teste01', '2001-01-01', '49333379851', '19989085358', 'teste01@gmail.com', '$2y$12$v/7IJoM3Zlf1OMu6YXl6yuN98Sh61gA9TB4T4cR/ZAwarZvc4S13y');

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
(1, 'SP', 'Hortolândia', 'Vila Real', 'Rua Irmãos Freire', 156, '18796-856'),
(2, 'SP', 'Paulínia', 'Vila Justina', 'Rua Irmãos Vieira', 157, '18736-858'),
(3, 'SP', 'Campinas', 'Campo Belo', 'Rua Irmãos Santos', 156, '18716-855');

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
(1, 1),
(2, 2),
(3, 3);

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
(1, 'Barbearia Auxiliadora ltda.', 'Barbearia ML', '(11) 97836-0100', '12.345.678/0001-00', 'Rua Odete Santos', 1780, 'Centro', 'Paulínia', 'SP', '09700-000', '08:00:00', '18:00:00', 'ml@gmail.com', '$2y$12$VgKck1ety.bfzhajJ0XwNuMCCPfRHVWc5Nx0S0DFlssqcLPo9qZOC'),
(2, 'Salão de beleza Gilberto e Cia.', 'Espaço do Gigi', '(11) 97836-0101', '12.345.678/0001-01', 'Rua Alberto de Nóbrega', 100, 'Centro', 'Hortolândia', 'SP', '02000-000', '08:00:00', '17:00:00', 'gigi@teste.com', '$2y$12$VgKck1ety.bfzhajJ0XwNuMCCPfRHVWc5Nx0S0DFlssqcLPo9qZOC'),
(3, 'Espaço da beleza ltda.', 'Beleza e Cia.', '(11) 97836-0109', '12.345.678/0001-0', 'Avenida Drummond', 1850, 'Centro', 'Campinas', 'SP', '03700-000', '08:00:00', '17:30:00', 'beleza@exemplo.com', 'senha789'),
(4, 'Teste01 ltda.', 'Teste Fantasia', '(19) 96325-7896', '12.345.678/0001-08', 'Rua teste 01', 1, 'Bairro 01', 'Cidade 01', 'ET', '12589-426', '08:00:00', '18:00:00', 'teste_email@gmail.com', '$2y$12$cxoOV/XKGAn3FjEurMJKh.N3sjcCBAX5rwkTnHS0krmyQ4ovuJKY.'),
(5, 'Teste02 ltda.', 'Teste Fantasia2', '19989085358', '12.345.678/0001-08', 'Rua teste 01', 120, 'Bairro 01', 'Cidade 01', 'ET', '12589-426', '07:00:00', '17:00:00', 'teste_email02@gmail.com', ''),
(6, 'Teste03 ltda.', 'Teste Fantasia3', '19333333333', '12.345.678/0001-10', 'Rua teste 03', 123, 'Bairro 03', 'Cidade 03', 'EP', '12589-427', '07:30:00', '17:00:00', 'teste_email03@gmail.com', '$2y$12$VgKck1ety.bfzhajJ0XwNuMCCPfRHVWc5Nx0S0DFlssqcLPo9qZOC');

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
(1, 'Pix'),
(2, 'Cartão de Crédito'),
(3, 'Cartão de Débito');

-- --------------------------------------------------------

--
-- Table structure for table `grades_horario`
--

CREATE TABLE `grades_horario` (
  `id_grade` int(11) NOT NULL,
  `id_profissional` int(11) DEFAULT NULL,
  `dia_semana` enum('1','2','3','4','5','6','7') DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_termino` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades_horario`
--

INSERT INTO `grades_horario` (`id_grade`, `id_profissional`, `dia_semana`, `hora_inicio`, `hora_termino`) VALUES
(1, 1, '1', '08:00:00', '18:00:00'),
(2, 1, '2', '08:00:00', '18:00:00'),
(3, 1, '3', '08:00:00', '18:00:00'),
(4, 1, '4', '08:00:00', '18:00:00'),
(5, 1, '5', '08:00:00', '18:00:00'),
(6, 2, '2', '08:00:00', '17:30:00'),
(7, 2, '3', '08:00:00', '17:30:00'),
(8, 2, '4', '08:00:00', '17:30:00'),
(9, 2, '5', '08:00:00', '17:30:00'),
(10, 4, '1', '08:00:00', '18:00:00'),
(11, 4, '2', '08:00:00', '18:00:00'),
(12, 4, '3', '08:00:00', '18:00:00'),
(13, 4, '4', '08:00:00', '18:00:00'),
(14, 4, '5', '08:00:00', '18:00:00'),
(15, 5, '1', '08:00:00', '17:00:00'),
(16, 5, '2', '08:00:00', '17:00:00'),
(17, 6, '2', '08:00:00', '16:30:00'),
(18, 6, '4', '08:00:00', '16:30:00'),
(19, 7, '5', '08:00:00', '16:00:00'),
(20, 8, '1', '08:00:00', '17:00:00'),
(21, 8, '4', '13:00:00', '17:00:00'),
(22, 8, '3', '10:00:00', '18:00:00');

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
(1, 1, 'email', 'João@teste.com', 'joao_al@gmail.com', '2024-09-13 16:51:42'),
(2, 2, 'email', 'Jorge@teste.com', 'jorge_silva@gmail.com', '2024-09-13 16:51:43'),
(3, 1, 'telefone', '(11) 98908-3690', '(19) 98908-3696', '2024-09-13 16:51:43'),
(4, 1, 'email', 'joao_al@gmail.com', 'Luis@gmail.com', '2024-09-13 16:51:43'),
(5, 1, 'senha', 'senha123', 'senha@123', '2024-09-13 16:51:43'),
(6, 2, 'email', 'jorge_silva@gmail.com', 'amanda_silva@gmail.com', '2024-09-13 15:15:10'),
(7, 1, 'senha', 'senha@123', '$2y$12$VgKck1ety.bfzhajJ0XwNuM', '2024-10-11 19:57:36');

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
(1, 1, 'logradouro', 'Rua Simplicio Almeida', 'Rua Odete Santos', '2024-09-13 16:59:00'),
(2, 1, 'numero', '100', '1780', '2024-09-13 16:59:00'),
(3, 1, 'bairro', 'Jardim Auxiliadora', 'Centro', '2024-09-13 16:59:00'),
(4, 1, 'cidade', 'Hortolândia', 'Paulínia', '2024-09-13 16:59:00'),
(5, 1, 'cep', '01000-000', '09700-000', '2024-09-13 16:59:00'),
(6, 1, 'email', 'ml@teste.com', 'ml@exemplo.com', '2024-09-13 16:59:00'),
(7, 3, 'telefone', '(11) 97836-010', '(11) 97836-0109', '2024-09-13 16:59:00'),
(8, 3, 'logradouro', 'Rua Luis Camilo', 'Avenida Drummond', '2024-09-13 16:59:00'),
(9, 3, 'numero', '100', '1850', '2024-09-13 16:59:00'),
(10, 3, 'cidade', 'Hortolândia', 'Campinas', '2024-09-13 16:59:00'),
(11, 3, 'cep', '03000-000', '03700-000', '2024-09-13 16:59:00'),
(12, 3, 'email', 'beleza@teste.com', 'beleza@exemplo.com', '2024-09-13 16:59:00'),
(13, 5, 'numero', '111', '120', '2024-10-09 14:51:40'),
(14, 5, 'senha', '$2y$12$FZBt4P3Vs7bidOaWbYSwVO8', '', '2024-10-09 14:51:40'),
(15, 6, 'numero', '120', '123', '2024-10-09 15:02:17'),
(16, 6, 'telefone', '19985085358', '19933333333', '2024-10-09 15:26:11'),
(17, 6, 'inicio_expediente', '07:00:00', '07:30:00', '2024-10-09 15:26:11'),
(18, 6, 'telefone', '19933333333', '19333333333', '2024-10-09 15:55:38'),
(19, 1, 'senha', 'senha123', '$2y$12$VgKck1ety.bfzhajJ0XwNuM', '2024-10-11 19:45:29'),
(20, 1, 'email', 'ml@exemplo.com', 'ml@gmail.com', '2024-10-11 19:46:02'),
(21, 2, 'senha', 'senha456', '$2y$12$VgKck1ety.bfzhajJ0XwNuM', '2024-10-16 20:00:27');

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
(1, 1, 'telefone', '(11) 90981-0540', '(19) 98987-0540', '2024-09-13 17:03:02'),
(2, 1, 'senha', 'senha987', 'senha@melhor', '2024-09-13 17:03:02'),
(3, 2, 'telefone', '(11) 90981-0541', '(19) 90981-0541', '2024-09-13 17:03:02'),
(4, 2, 'senha', 'senha654', 'senha@melhorainda', '2024-09-13 17:03:02'),
(5, 1, 'senha', 'senha@melhor', '$2y$12$VgKck1ety.bfzhajJ0XwNuM', '2024-10-11 19:33:16'),
(6, 3, 'senha', 'senha321', '$2y$12$VgKck1ety.bfzhajJ0XwNuM', '2024-10-16 19:59:09');

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
(1, 1, 2),
(2, 3, 1),
(3, 5, 1);

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
(1, 1, 1, 2, 1, '2024-09-13 15:22:39', 157.96),
(2, 2, 2, 1, 1, '2024-09-13 15:23:04', 49.9),
(3, 3, 3, 2, 1, '2024-09-13 15:23:23', 67.99);

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
(1, 'Shampoo', 78.98, 1, 1),
(2, 'Condicionador', 78.98, 1, 1),
(3, 'Sabonete facial', 49.9, 2, 3),
(4, 'Esmalte secante', 12.4, 3, 2),
(5, 'Mascara Hidratação', 67.99, 1, 2);

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
  `estabel_vinculado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profissionais`
--

INSERT INTO `profissionais` (`id_profissional`, `nome`, `data_nasc`, `CPF`, `telefone`, `email`, `senha`, `estabel_vinculado`) VALUES
(1, 'Jeremias de Arruda Silva', '1990-01-01', '987.654.321-00', '(19) 98987-0540', 'jeremias@teste.com', '$2y$12$VgKck1ety.bfzhajJ0XwNuMCCPfRHVWc5Nx0S0DFlssqcLPo9qZOC', 1),
(2, 'Juliana da Silva Costa', '1991-01-01', '987.654.321-01', '(19) 90981-0541', 'juliana@teste.com', 'senha@melhorainda', 3),
(3, 'Aline Costa Albuquerque', '1992-01-01', '987.654.321-02', '(11) 90981-0542', 'aline@teste.com', '$2y$12$VgKck1ety.bfzhajJ0XwNuMCCPfRHVWc5Nx0S0DFlssqcLPo9qZOC', NULL),
(4, 'Sheila Almeida', '1998-11-23', '987.654.321-02', '(11) 90981-054', 'sheila@teste.com', 'senha123', 2),
(5, 'Juriscleison da Costa', '1993-04-01', '132.256.456-02', '1908007070', 'jusriscleison@gmail.com', 'senha123', 1),
(6, 'Otávio Ferreira', '1975-12-31', '256.145.486-01', '199995452', 'tavinho@outlook.com', 'senha123', 2),
(7, 'Bruce Lee', '1968-05-06', '456.256.324-15', '1965165655', 'kungfu@yahoo.com', 'senha123', 1),
(8, 'Ronaldo Silveira', '1999-03-12', '65561561', '195226512', 'ronaldo@teste.com', '$2y$12$o/SwkMeE3/Kp4HSOL2gnIucs35o1TvFQFkgi.aMLCfwrEW7sjuVsu', 1);

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
    IF OLD.estabel_vinculado != NEW.estabel_vinculado THEN 
        INSERT INTO historico_profissionais (id_profissional, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
        VALUES (NEW.id_profissional, 'estabel_vinculado', OLD.estabel_vinculado, NEW.estabel_vinculado, NOW()); 
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
,`data_realizacao` date
,`valor_total` float
);

-- --------------------------------------------------------

--
-- Table structure for table `profissionais_servicos`
--

CREATE TABLE `profissionais_servicos` (
  `id_profissional` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profissionais_servicos`
--

INSERT INTO `profissionais_servicos` (`id_profissional`, `id_servico`) VALUES
(1, 1),
(1, 5),
(1, 7),
(2, 3),
(4, 2),
(4, 4),
(5, 5),
(5, 7),
(6, 4),
(7, 1),
(8, 1);

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
(1, 'Corte masculino', 40, '00:30:00', 1, 1),
(2, 'Corte feminino', 50, '00:30:00', 1, 2),
(3, 'Esmaltação', 35, '01:00:00', 3, 3),
(4, 'Coloração', 120, '03:00:00', 1, 2),
(5, 'Corte de sobrancelha', 30, '00:40:00', 2, 1),
(6, 'Progressiva', 110, '04:00:00', 1, 3),
(7, 'Combo (corte + barba)', 65, '01:00:00', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `status_agendamentos`
--

CREATE TABLE `status_agendamentos` (
  `id_status` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_agendamentos`
--

INSERT INTO `status_agendamentos` (`id_status`, `descricao`) VALUES
(1, 'Aguardando aprovação'),
(2, 'Agendado'),
(3, 'Concluído'),
(4, 'Ausência');

-- --------------------------------------------------------

--
-- Table structure for table `status_pedidos`
--

CREATE TABLE `status_pedidos` (
  `id_status` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_pedidos`
--

INSERT INTO `status_pedidos` (`id_status`, `descricao`) VALUES
(1, 'Aguardando pagamento'),
(2, 'Pagamento confirmado'),
(3, 'Em preparação'),
(4, 'Em Trânsito'),
(5, 'Entregue'),
(6, 'Concluído'),
(7, 'Cancelado'),
(8, 'Reembolsado');

-- --------------------------------------------------------

--
-- Table structure for table `vinculos`
--

CREATE TABLE `vinculos` (
  `id_vinculo` int(11) NOT NULL,
  `id_profissional` int(11) DEFAULT NULL,
  `id_estabelecimento` int(11) DEFAULT NULL,
  `status_vinculo` enum('pendente','aprovado','rejeitado','cancelado') DEFAULT NULL,
  `data_vinculo` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vinculos`
--

INSERT INTO `vinculos` (`id_vinculo`, `id_profissional`, `id_estabelecimento`, `status_vinculo`, `data_vinculo`) VALUES
(2, 7, 1, 'pendente', NULL),
(3, 4, 2, 'pendente', '2024-10-14 10:28:07'),
(4, 5, 4, 'pendente', '2024-10-14 10:56:53'),
(5, 8, 1, 'pendente', '2024-10-14 10:58:14'),
(6, 3, 2, 'rejeitado', '2024-10-16 19:59:39');

--
-- Triggers `vinculos`
--
DELIMITER $$
CREATE TRIGGER `remove_estabel_vinculado` AFTER UPDATE ON `vinculos` FOR EACH ROW BEGIN
  IF NEW.status_vinculo IN ('rejeitado', 'cancelado') THEN
    UPDATE profissionais
    SET estabel_vinculado = NULL
    WHERE id_profissional = NEW.id_profissional;
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_estabel_vinculado` AFTER UPDATE ON `vinculos` FOR EACH ROW BEGIN
  IF NEW.status_vinculo = 'aprovado' THEN
    UPDATE profissionais
    SET estabel_vinculado = NEW.id_estabelecimento
    WHERE id_profissional = NEW.id_profissional;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `profissionais_agendamentos`
--
DROP TABLE IF EXISTS `profissionais_agendamentos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `profissionais_agendamentos`  AS SELECT `profissionais`.`nome` AS `nome`, `agendamentos`.`data_realizacao` AS `data_realizacao`, `agendamentos`.`valor_total` AS `valor_total` FROM (`profissionais` join `agendamentos` on(`profissionais`.`id_profissional` = `agendamentos`.`id_profissional`)) ;

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
  ADD KEY `fk_agendamentos04` (`id_status`),
  ADD KEY `fk_agendamentos05` (`id_servico`);

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
  ADD PRIMARY KEY (`id_profissional`),
  ADD KEY `fk_profissionais01` (`estabel_vinculado`);

--
-- Indexes for table `profissionais_servicos`
--
ALTER TABLE `profissionais_servicos`
  ADD PRIMARY KEY (`id_profissional`,`id_servico`),
  ADD KEY `id_servico` (`id_servico`);

--
-- Indexes for table `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `fk_servicos01` (`id_categoria`),
  ADD KEY `fk_servicos02` (`id_estabelecimento`);

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
-- Indexes for table `vinculos`
--
ALTER TABLE `vinculos`
  ADD PRIMARY KEY (`id_vinculo`),
  ADD KEY `vinculo_fk01` (`id_estabelecimento`),
  ADD KEY `vinculo_fk02` (`id_profissional`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id_agendamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categorias_produto`
--
ALTER TABLE `categorias_produto`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categorias_servico`
--
ALTER TABLE `categorias_servico`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  MODIFY `id_estabelecimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `formas_pagamentos`
--
ALTER TABLE `formas_pagamentos`
  MODIFY `id_opcaopag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grades_horario`
--
ALTER TABLE `grades_horario`
  MODIFY `id_grade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `historico_clientes`
--
ALTER TABLE `historico_clientes`
  MODIFY `id_alteracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `historico_estabelecimentos`
--
ALTER TABLE `historico_estabelecimentos`
  MODIFY `id_alteracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `historico_profissionais`
--
ALTER TABLE `historico_profissionais`
  MODIFY `id_alteracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profissionais`
--
ALTER TABLE `profissionais`
  MODIFY `id_profissional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `status_agendamentos`
--
ALTER TABLE `status_agendamentos`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `status_pedidos`
--
ALTER TABLE `status_pedidos`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vinculos`
--
ALTER TABLE `vinculos`
  MODIFY `id_vinculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `fk_agendamentos04` FOREIGN KEY (`id_status`) REFERENCES `status_agendamentos` (`id_status`),
  ADD CONSTRAINT `fk_agendamentos05` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`);

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
-- Constraints for table `profissionais`
--
ALTER TABLE `profissionais`
  ADD CONSTRAINT `fk_profissionais01` FOREIGN KEY (`estabel_vinculado`) REFERENCES `estabelecimentos` (`id_estabelecimento`);

--
-- Constraints for table `profissionais_servicos`
--
ALTER TABLE `profissionais_servicos`
  ADD CONSTRAINT `profissionais_servicos_ibfk_1` FOREIGN KEY (`id_profissional`) REFERENCES `profissionais` (`id_profissional`),
  ADD CONSTRAINT `profissionais_servicos_ibfk_2` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`);

--
-- Constraints for table `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `fk_servicos01` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_servico` (`id_categoria`),
  ADD CONSTRAINT `fk_servicos02` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimentos` (`id_estabelecimento`);

--
-- Constraints for table `vinculos`
--
ALTER TABLE `vinculos`
  ADD CONSTRAINT `vinculo_fk01` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimentos` (`id_estabelecimento`),
  ADD CONSTRAINT `vinculo_fk02` FOREIGN KEY (`id_profissional`) REFERENCES `profissionais` (`id_profissional`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;