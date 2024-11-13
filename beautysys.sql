-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 09:31 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizar_cliente` (IN `p_id_cliente` INT, IN `p_telefone` VARCHAR(15), IN `p_email` VARCHAR(30))   BEGIN
UPDATE clientes SET telefone = p_telefone, email = p_email WHERE id_cliente = p_id_cliente; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizar_estabelecimento` (IN `p_id_estabelecimento` INT, IN `p_nome_fantasia` VARCHAR(40), IN `p_telefone` VARCHAR(15), IN `p_logradouro` VARCHAR(40), IN `p_numero` INT, IN `p_bairro` VARCHAR(40), IN `p_cidade` VARCHAR(40), IN `p_estado` VARCHAR(2), IN `p_cep` VARCHAR(9), IN `p_inicio_expediente` TIME, IN `p_termino_expediente` TIME, IN `p_email` VARCHAR(30), IN `p_senha` VARCHAR(255))   BEGIN  
UPDATE estabelecimentos SET nome_fantasia = p_nome_fantasia, telefone = p_telefone, logradouro = p_logradouro, numero = p_numero, bairro = p_bairro, cidade = p_cidade, estado = p_estado, cep = p_cep, inicio_expediente = p_inicio_expediente, termino_expediente = p_termino_expediente, email = p_email, senha = p_senha WHERE id_estabelecimento = p_id_estabelecimento;   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizar_profissional` (IN `p_id_profissional` INT, IN `p_telefone` VARCHAR(15), IN `p_email` VARCHAR(30))   BEGIN 
UPDATE profissionais SET telefone = p_telefone, email = p_email WHERE id_profissional = p_id_profissional; 
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
        id_profissional = id_profissional_param
    ORDER BY dia_semana ASC;  
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
WHERE id_cliente = p_id_cliente
ORDER BY a.id_agendamento DESC;
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
SELECT a.id_agendamento, 
       c.nome AS nome_cliente, 
       s.nome AS servico, 
       a.data_realizacao, 
       a.horario_inicio, 
       a.horario_termino, 
       a.valor_total, 
       fp.descricao AS formas_pagamento, 
       a.id_profissional, 
       sa.descricao AS status,
       (SELECT COUNT(*) 
         FROM agendamentos 
         WHERE id_profissional = p_id_profissional) AS total_agendamentos
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
        v.data_vinculo,
        (SELECT COUNT(*) 
         FROM vinculos 
         WHERE id_estabelecimento = p_id_estabelecimento) AS total_profissionais
    FROM vinculos AS v
    JOIN profissionais AS p ON p.id_profissional = v.id_profissional
    WHERE v.id_estabelecimento = p_id_estabelecimento;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `exibir_prof_vinculados_ativ` (IN `p_id_estabelecimento` INT)   BEGIN
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
    WHERE v.id_estabelecimento = p_id_estabelecimento
      AND v.status_vinculo = 'aprovado';
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

    -- Faturamento por Pedidos (será utilizado quando o módulo de marketplace for implementado)
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `horarios_pico` (IN `p_id_estabelecimento` INT)   BEGIN
    SELECT a.horario_inicio, COUNT(a.horario_inicio) AS quantidade
    FROM agendamentos AS a
    JOIN profissionais AS p ON a.id_profissional = p.id_profissional
    JOIN estabelecimentos AS e ON p.estabel_vinculado = e.id_estabelecimento
    WHERE e.id_estabelecimento = p_id_estabelecimento
    GROUP BY a.horario_inicio;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_estab` ()   SELECT e.id_estabelecimento, e.nome_fantasia, e.telefone, e.logradouro, e.email,
e.numero, e.bairro, e.cidade, e.estado, e.inicio_expediente, e.termino_expediente
FROM estabelecimentos as e 
ORDER BY e.nome_fantasia$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `realizar_pesquisa` (IN `termo_pesquisa` VARCHAR(30))   BEGIN 
    -- Pesquisa na tabela servicos
    SELECT 
        s.id_servico AS id, 
        s.nome AS descricao, 
        s.valor, 
        e.nome_fantasia AS nome_fantasia, 
        e.id_estabelecimento AS id_estabelecimento
    FROM 
        servicos AS s
    JOIN 
        estabelecimentos AS e ON e.id_estabelecimento = s.id_estabelecimento
    WHERE 
        s.nome LIKE CONCAT('%', termo_pesquisa, '%')

    UNION

    -- Pesquisa na tabela produtos
    SELECT 
        id_produto AS id, 
        nome AS descricao, 
        valor, 
        NULL AS nome_fantasia, 
        NULL AS id_estabelecimento
    FROM 
        produtos
    WHERE 
        nome LIKE CONCAT('%', termo_pesquisa, '%')
    
    UNION
    
    -- Pesquisa na tabela estabelecimentos
    SELECT 
        id_estabelecimento AS id, 
        nome_fantasia AS descricao, 
        NULL AS valor, 
        nome_fantasia AS nome_fantasia, 
        id_estabelecimento AS id_estabelecimento
    FROM 
        estabelecimentos 
    WHERE 
        nome_fantasia LIKE CONCAT('%', termo_pesquisa, '%')
        OR razao_social LIKE CONCAT('%', termo_pesquisa, '%')
    
    UNION
    
    -- Pesquisa na tabela profissionais
    SELECT 
        id_profissional AS id, 
        nome AS descricao, 
        NULL AS valor, 
        NULL AS nome_fantasia, 
        NULL AS id_estabelecimento
    FROM 
        profissionais 
    WHERE 
        nome LIKE CONCAT('%', termo_pesquisa, '%');
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

-- --------------------------------------------------------

--
-- Table structure for table `categorias_servico`
--

CREATE TABLE `categorias_servico` (
  `id_categoria` int(11) NOT NULL,
  `descricao` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `email_verificado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome`, `data_nasc`, `CPF`, `telefone`, `email`, `senha`, `email_verificado`) VALUES
(1, 'Rodrigo Oliveira Feitosa', '2001-03-02', '886.378.820-05', '(19) 98908-5358', 'rodrigooliveirafeitosa@gmail.com', '$2y$12$sxZZPwskwqdJ0aE2L2KZ7uuaGYPBSKn6eaOju9mdIDpaQvkkXM6Oy', 1),
(2, 'Luísa Ferreira Martins', '1993-01-01', '353.615.474-33', '(99) 98041-7101', 'luisa@exemplo.com', '$2y$12$/NSzvSiPrV4yb0che/aolOerGZhIvYnfgJqslMj94eYnnEZYKZy9O', 1),
(3, 'Rafael Costa Almeida', '2000-05-06', '720.974.120-84', '(16) 97458-2913', 'rafael@exemplo.com', '$2y$12$.bgUxMcJ3eBg9xCt51aUpOEPlrGxyh4Jy.DlEftFwiORoQtUaoQe.', 1),
(4, 'Trophozilda Alves de Assis', '1966-06-06', '675.092.432-89', '(87) 98406-0022', 'tropho.zilda@exemplo.com', '$2y$12$9SpZbJG7kLv5eZIAljmBqOvDtyn7uz9lJcVI6JIt6L30BNavWv70y', 1),
(5, 'Mariana Carvalho Ribeiro', '2003-03-03', '447.426.135-62', '(48) 98990-5957', 'mari@exemplo.com', '$2y$12$8ucJRIc8e1fM9eQmWiWp/e0IN21DiVAKBtvtGgEbftIm3wiuDCWlW', 1);

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
-- Table structure for table `confirmacoes_emails`
--

CREATE TABLE `confirmacoes_emails` (
  `token` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` enum('cliente','profissional','estabelecimento','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `confirmacoes_emails`
--

INSERT INTO `confirmacoes_emails` (`token`, `email`, `created_at`, `id_usuario`, `tipo_usuario`) VALUES
('Nshw5waCprAtRBRmEew2wt5hviYTt9zBBqHdDxEGrOROZd441k3TCEbMav43', 'Luisa@gmail.com', '2024-11-13 16:26:15', 2, 'cliente'),
('HEstXepmWK8R0f2jwPCA6tkjLWTqGNgXBWJ99TATuWzNvbVdjOdAQYxkho0E', 'rafael@gmail.com', '2024-11-13 16:27:04', 3, 'cliente'),
('5VJO3JgY6cJ8EbXu4OkGZz48Spj5HvnFHIJRPv7NsI4k7QHKm7NsanngUO8d', 'tropho.zilda@gmail.com', '2024-11-13 18:47:29', 4, 'cliente'),
('ZGw9BJdoKdrUKTqsWwqz7wfzoz3SUomNQBpoRwFGhEIOHIqYrtut6WBjFraY', 'mari@gmail.com', '2024-11-13 18:48:35', 5, 'cliente'),
('lhCk9l2pDfKaHRl6SHiL9FpgMGECSpXLBT4OguvXLKGLIk9HDq8sZxbbTseS', 'fefe@gmail.com', '2024-11-13 18:50:45', 1, 'profissional'),
('gYf0s1LLRgLBbKsMW2jhghnZOszlZP3mZnnmy4shv55Q61JOkodQdvgHxkUs', 'amandinha@gmail.com', '2024-11-13 18:52:00', 2, 'profissional'),
('ncVtLQNePbyCf4YvOoq76AF8wlzI31gRgvKkGLnTPZYglio5eQS4zQB123k1', 'carol@gmail.com', '2024-11-13 18:53:12', 3, 'profissional'),
('h1WLkUr6IuQ7vgomf8z0CZkjpnKZCpc3iBWrdEHWtZ4AOP13gRTF0M6bKh0C', 'lari@gmail.com', '2024-11-13 18:54:52', 4, 'profissional'),
('io8zL2n004UcphQtb3awxYpXfHYmRM2echwc7bs71SnHTg12P4TWiqSEHdRb', 'glamour@gmail.com', '2024-11-13 19:06:04', 1, 'estabelecimento'),
('WgkXVHEYbpkS4jFCr6MyZzsXoVExnIuULEEiiSGlkOEqTwos1Lx0tCt3XvWO', 'kings@exemplo.com', '2024-11-13 19:08:35', 2, 'estabelecimento'),
('PwOzovs67pEsh1NEEgmF970nCYMc0wAXUUzEMtq3oJfyfIUIDW8vYuGIbm22', 'urb@exemplo.com', '2024-11-13 19:11:20', 3, 'estabelecimento'),
('jtQeYso2rDdjNv9MgQar98jj2w4qI5XdjQySsuk5Cu8jTvrhLaNDLMqzhca9', 'arte@exemplo.com', '2024-11-13 19:13:18', 4, 'estabelecimento'),
('J1GAYzc3smk7DKyjxdTB5HeOB3h4iBtt4uhVC3rYYzkNHzHylX9eNepVFXKH', 'barberf@exemplo.com', '2024-11-13 19:17:25', 5, 'estabelecimento');

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

-- --------------------------------------------------------

--
-- Table structure for table `enderecos_clientes`
--

CREATE TABLE `enderecos_clientes` (
  `id_cliente` int(11) NOT NULL,
  `id_endereco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `email_verificado` tinyint(1) NOT NULL,
  `imagem_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estabelecimentos`
--

INSERT INTO `estabelecimentos` (`id_estabelecimento`, `razao_social`, `nome_fantasia`, `telefone`, `CNPJ`, `logradouro`, `numero`, `bairro`, `cidade`, `estado`, `CEP`, `inicio_expediente`, `termino_expediente`, `email`, `senha`, `email_verificado`, `imagem_perfil`) VALUES
(1, 'Estética & Beleza Fernandes Ltda.', 'Espaço Glamour', '(19) 3909-7016', '83.311.776/0001-50', 'Rua das Flores', 234, 'Jardim das Rosas', 'São Paulo', 'SP', '01234-567', '08:00:00', '17:00:00', 'glamour@exemplo.com', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2fC0VygV8JqWtyQVs1cY8ByTQhw8qWe', 1, '1731529275_images.png'),
(2, 'Barbearia Silva & Costa ME', 'Barber Kings', '(44) 3304-7794', '50.569.114/0001-25', 'Av. dos Pioneiros', 379, 'Centro', 'Belo Horizonte', 'MG', '30123-456', '09:30:00', '19:30:00', 'kings@exemplo.com', '$2y$12$/WCzSRQf04g0eNGuv/MhjeUk6Af8GNy4rsWJClVsWpRfPNS4b6zO2', 1, 'fgdgete.jpeg'),
(3, 'Beleza Urbana Estética ltda.', 'Studio Urbana', '(44) 2312-7234', '09.598.280/0001-56', 'Rua da Harmonia', 785, 'Vila Nova', 'Curitiba', 'PR', '80567-890', '08:00:00', '16:00:00', 'urb@exemplo.com', '$2y$12$1qrU6m1NFNtlz.YE3DpvWOz.mvUbVajWSHF/8x1DAfdfXs5Fdi3km', 1, '1731529381_images (1).png'),
(4, 'Salão Cabelo & Arte S.A.', 'Arte dos Fios', '(38) 2851-7307', '27.444.476/0001-78', 'Alameda das Palmeiras', 569, 'Bosque Verde', 'Rio de Janeiro', 'RJ', '22345-678', '09:30:00', '14:30:00', 'arte@exemplo.com', '$2y$12$qAhpeyqIMCLwLiMM1q3I4O6XkoZ7mmDVh8MiQzXmoVCMTH7UyLzHe', 1, 'gtyertgdg.jpg'),
(5, 'Barbearia RF ltda.', 'BarberShop', '(19) 98908-5358', '52.601.774/0001-71', '(63) 3257-6896', 698, 'Nossa Sra. Auxiliadora', 'Hortolândia', 'SP', '13183-287', '10:30:00', '22:30:00', 'barberf@exemplo.com', '$2y$12$f4/1NHE56t/Kr54SsQDSv.ny2GGWr5cKJ/JcyHQJYSIy0E7V0hO3G', 1, '1731529642_images (2).png'),
(6, 'Barber Oficial ltda.', 'A Barbearia', '(19) 98908-5358', '28.283.482/0001-53', 'Alameda de Assis', 752, 'Remanso Campineiro', 'Hortolândia', 'SP', '85236-954', '07:30:00', '22:00:00', 'rodrigooliveirafeitosa@gmail.com', '$2y$12$Ilfwg57bS4NWFU4DskzDw.mGm3BYjKunPQ.2c1oMWBZzXf2P7pSPq', 1, NULL);

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
-- Stand-in structure for view `estabelecimentos_populares`
-- (See below for the actual view)
--
CREATE TABLE `estabelecimentos_populares` (
`id` int(11)
,`nome_fantasia` varchar(40)
,`total_agendamentos` bigint(21)
,`imagem` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `formas_pagamentos`
--

CREATE TABLE `formas_pagamentos` (
  `id_opcaopag` int(11) NOT NULL,
  `descricao` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 'senha', '$2y$12$uSbuuDWjDAoaXk8HQ9EY1u5', '$2y$12$sxZZPwskwqdJ0aE2L2KZ7uu', '2024-11-13 13:17:50'),
(2, 2, 'email', 'Luisa@gmail.com', 'luisa@exemplo.com', '2024-11-13 16:44:08'),
(3, 3, 'email', 'rafael@gmail.com', 'rafael@exemplo.com', '2024-11-13 16:44:53'),
(4, 4, 'email', 'tropho.zilda@gmail.com', 'tropho.zilda@exemplo.com', '2024-11-13 16:45:27'),
(5, 5, 'email', 'mari@gmail.com', 'mari@exemplo.com', '2024-11-13 16:45:58');

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
(1, 6, 'senha', '$2y$12$eoWpPEX5ZBwd7pTlAoM/E.i', '$2y$12$Ilfwg57bS4NWFU4DskzDw.m', '2024-11-13 16:21:15'),
(2, 5, 'nome_fantasia', 'Barber Feitosa', 'BarberShop', '2024-11-13 16:22:03'),
(3, 1, 'email', 'glamour@gmail.com', 'glamour@exemplo.com', '2024-11-13 17:12:44');

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
(1, 5, 'senha', '$2y$12$VQZxMRJ6K56vFqIg8c/NZeB', '$2y$12$7XIGkGN8S76gL2ojnFofZuy', '2024-11-13 15:58:48'),
(2, 4, 'senha', '$2y$12$L1EruuYAT9v2t5VGxsoooej', '$2y$12$7XIGkGN8S76gL2ojnFofZuy', '2024-11-13 17:00:43'),
(3, 3, 'senha', '$2y$12$WxPD14RALFwZVCWt2sWqEuw', '$2y$12$7XIGkGN8S76gL2ojnFofZuy', '2024-11-13 17:00:47'),
(4, 2, 'senha', '$2y$12$c91Kykq.2RS.r.IjQMuHVeJ', '$2y$12$7XIGkGN8S76gL2ojnFofZuy', '2024-11-13 17:00:49'),
(5, 1, 'senha', '$2y$12$BxJxGslsbuO91Nyl1ApCJe0', '$2y$12$7XIGkGN8S76gL2ojnFofZuy', '2024-11-13 17:00:53'),
(6, 1, 'email', 'fefe@gmail.com', 'fefe@exemplo.com', '2024-11-13 17:03:36'),
(7, 2, 'email', 'amandinha@gmail.com', 'amandinha@exemplo.com', '2024-11-13 17:04:03'),
(8, 3, 'email', 'carol@gmail.com', 'carol@exemplo.com', '2024-11-13 17:06:18'),
(9, 4, 'email', 'lari@gmail.com', 'lari@exemplo.com', '2024-11-13 17:07:50'),
(10, 1, 'senha', '$2y$12$7XIGkGN8S76gL2ojnFofZuy', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2', '2024-11-13 17:12:06'),
(11, 2, 'senha', '$2y$12$7XIGkGN8S76gL2ojnFofZuy', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2', '2024-11-13 17:12:10'),
(12, 3, 'senha', '$2y$12$7XIGkGN8S76gL2ojnFofZuy', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2', '2024-11-13 17:12:14'),
(13, 4, 'senha', '$2y$12$7XIGkGN8S76gL2ojnFofZuy', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2', '2024-11-13 17:12:17'),
(14, 5, 'senha', '$2y$12$7XIGkGN8S76gL2ojnFofZuy', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2', '2024-11-13 17:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qtd_item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs_tokens`
--

CREATE TABLE `logs_tokens` (
  `id_token` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `used_at` varchar(255) NOT NULL,
  `motivo` enum('redefinição de senha','confirmação de email','','') NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` enum('cliente','profissional','estabelecimento','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs_tokens`
--

INSERT INTO `logs_tokens` (`id_token`, `token`, `email`, `created_at`, `used_at`, `motivo`, `id_usuario`, `tipo_usuario`) VALUES
(1, 'JCObTFytbAhEwBicRO7tPbocRoq31LYse1zdoIXfBxq3K7p9bKZ4mG21rIF6', 'rodrigooliveirafeitosa@gmail.com', '2024-11-13 16:13:57', '2024-11-13 16:15:00', 'confirmação de email', 1, 'cliente'),
(2, 'PsdZupDGQu6Xi4K299flvOyvOI3JSbdQLTlRHI6w5z2QckhisztxWpq5P7KG', 'rodrigooliveirafeitosa@gmail.com', '2024-11-13 16:17:32', '2024-11-13 16:17:50', 'redefinição de senha', 1, 'cliente'),
(3, 'AK263giGjiXVLqafA2wUIbpBoMsNT9kZD26DBBBXWnc9V05Vv9ZxNzMKMS9e', 'rodrigooliveirafeitosa@gmail.com', '2024-11-13 18:56:00', '2024-11-13 18:56:39', 'confirmação de email', 5, 'profissional'),
(4, 'AfOrtVbJLMEHeFRSBq2Y0BbQcJyJho4uUfJWJ4ItC1Lgzm5Ckyg8KF983jqv', 'rodrigooliveirafeitosa@gmail.com', '2024-11-13 18:58:26', '2024-11-13 18:58:47', 'redefinição de senha', 5, 'profissional'),
(5, '8Lrtxsf94x5itngwl44fPO477hYRrZK7uxYZKiwgxPmOgAzyGPvu8MNw5NLd', 'rodrigooliveirafeitosa@gmail.com', '2024-11-13 19:19:51', '2024-11-13 19:20:18', 'confirmação de email', 6, 'estabelecimento'),
(6, 'mRyDrqtom3ZNcUvLzlB6S2z8QLrmp0onDnIbNYee8ZsMmyVIFdJ2DqC9zB1O', 'rodrigooliveirafeitosa@gmail.com', '2024-11-13 19:20:57', '2024-11-13 19:21:14', 'redefinição de senha', 6, 'estabelecimento');

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
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `estabel_vinculado` int(11) DEFAULT NULL,
  `email_verificado` tinyint(1) NOT NULL,
  `imagem_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profissionais`
--

INSERT INTO `profissionais` (`id_profissional`, `nome`, `data_nasc`, `CPF`, `telefone`, `email`, `senha`, `estabel_vinculado`, `email_verificado`, `imagem_perfil`) VALUES
(1, 'Felipe Gonçalves Cardoso', '1977-07-06', '957.256.305-01', '(99) 97556-1878', 'fefe@exemplo.com', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2fC0VygV8JqWtyQVs1cY8ByTQhw8qWe', NULL, 1, '1731528200_3.jpg'),
(2, 'Amanda Pereira Torres', '2005-12-25', '025.948.848-80', '(97) 99175-9060', 'amandinha@exemplo.com', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2fC0VygV8JqWtyQVs1cY8ByTQhw8qWe', NULL, 1, 'ytderty.jpg'),
(3, 'Carolina Nogueira Lopes', '1998-09-30', '631.432.950-74', '(33) 98366-1972', 'carol@exemplo.com', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2fC0VygV8JqWtyQVs1cY8ByTQhw8qWe', NULL, 1, 'hgfhrt.jpg'),
(4, 'Larissa Mendes Araújo', '1995-11-23', '846.397.918-10', '(69) 99864-3244', 'lari@exemplo.com', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2fC0VygV8JqWtyQVs1cY8ByTQhw8qWe', NULL, 1, 'hgfhrt.jpg'),
(5, 'rodrigooliveirafeitosa@gmail.com', '2001-03-02', '431.424.890-45', '(68) 97323-6557', 'rodrigooliveirafeitosa@gmail.com', '$2y$12$bBHA2XPVgaje7K2oqhm8KO2fC0VygV8JqWtyQVs1cY8ByTQhw8qWe', NULL, 1, NULL);

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
-- Stand-in structure for view `profissionais_populares`
-- (See below for the actual view)
--
CREATE TABLE `profissionais_populares` (
`id` int(11)
,`nome` varchar(50)
,`total_agendamentos` bigint(21)
,`imagem` varchar(255)
,`estabel_vinculado` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `profissionais_servicos`
--

CREATE TABLE `profissionais_servicos` (
  `id_profissional` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resets_senhas`
--

CREATE TABLE `resets_senhas` (
  `token` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` enum('cliente','profissional','estabelecimento','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `status_agendamentos`
--

CREATE TABLE `status_agendamentos` (
  `id_status` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_pedidos`
--

CREATE TABLE `status_pedidos` (
  `id_status` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Structure for view `estabelecimentos_populares`
--
DROP TABLE IF EXISTS `estabelecimentos_populares`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estabelecimentos_populares`  AS SELECT `e`.`id_estabelecimento` AS `id`, `e`.`nome_fantasia` AS `nome_fantasia`, count(`a`.`id_agendamento`) AS `total_agendamentos`, `e`.`imagem_perfil` AS `imagem` FROM ((`estabelecimentos` `e` join `profissionais` `p` on(`p`.`estabel_vinculado` = `e`.`id_estabelecimento`)) join `agendamentos` `a` on(`a`.`id_profissional` = `p`.`id_profissional`)) GROUP BY `e`.`id_estabelecimento`, `e`.`nome_fantasia`, `e`.`imagem_perfil` ORDER BY count(`a`.`id_agendamento`) DESC LIMIT 0, 3 ;

-- --------------------------------------------------------

--
-- Structure for view `profissionais_agendamentos`
--
DROP TABLE IF EXISTS `profissionais_agendamentos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `profissionais_agendamentos`  AS SELECT `profissionais`.`nome` AS `nome`, `agendamentos`.`data_realizacao` AS `data_realizacao`, `agendamentos`.`valor_total` AS `valor_total` FROM (`profissionais` join `agendamentos` on(`profissionais`.`id_profissional` = `agendamentos`.`id_profissional`)) ;

-- --------------------------------------------------------

--
-- Structure for view `profissionais_populares`
--
DROP TABLE IF EXISTS `profissionais_populares`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `profissionais_populares`  AS SELECT `p`.`id_profissional` AS `id`, `p`.`nome` AS `nome`, count(`a`.`id_agendamento`) AS `total_agendamentos`, `p`.`imagem_perfil` AS `imagem`, `p`.`estabel_vinculado` AS `estabel_vinculado` FROM (`profissionais` `p` join `agendamentos` `a` on(`a`.`id_profissional` = `p`.`id_profissional`)) GROUP BY `p`.`id_profissional`, `p`.`nome`, `p`.`imagem_perfil`, `p`.`estabel_vinculado` ORDER BY count(`a`.`id_agendamento`) DESC LIMIT 0, 3 ;

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
-- Indexes for table `logs_tokens`
--
ALTER TABLE `logs_tokens`
  ADD PRIMARY KEY (`id_token`);

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
  MODIFY `id_agendamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias_produto`
--
ALTER TABLE `categorias_produto`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias_servico`
--
ALTER TABLE `categorias_servico`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  MODIFY `id_estabelecimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `formas_pagamentos`
--
ALTER TABLE `formas_pagamentos`
  MODIFY `id_opcaopag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades_horario`
--
ALTER TABLE `grades_horario`
  MODIFY `id_grade` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historico_clientes`
--
ALTER TABLE `historico_clientes`
  MODIFY `id_alteracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `historico_estabelecimentos`
--
ALTER TABLE `historico_estabelecimentos`
  MODIFY `id_alteracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `historico_profissionais`
--
ALTER TABLE `historico_profissionais`
  MODIFY `id_alteracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `logs_tokens`
--
ALTER TABLE `logs_tokens`
  MODIFY `id_token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profissionais`
--
ALTER TABLE `profissionais`
  MODIFY `id_profissional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_agendamentos`
--
ALTER TABLE `status_agendamentos`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_pedidos`
--
ALTER TABLE `status_pedidos`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vinculos`
--
ALTER TABLE `vinculos`
  MODIFY `id_vinculo` int(11) NOT NULL AUTO_INCREMENT;

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
