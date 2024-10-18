-- Criar banco de dados
CREATE DATABASE barbeariaricardo;

-- Usar o banco de dados criado
USE barbeariaricardo;

-- Criar tabela de cortes (agendamentos)
CREATE TABLE agendamentos (
    id_horario INT PRIMARY KEY AUTO_INCREMENT,
    dt_corte DATE NOT NULL,
    hr_corte TIME NOT NULL,
    nm_corte VARCHAR(100) NOT NULL,
    vl_corte DECIMAL(10, 2) NOT NULL,
    nm_forma_pagamento VARCHAR(50) NOT NULL,
    fg_id_cortes INT,
    fg_id_funcionario INT
);

-- Criar tabela de usuários
CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nm_usuario VARCHAR(100) NOT NULL,
    nr_telefone VARCHAR(15),
    nm_senha VARCHAR(255) NOT NULL
);

-- Criar tabela de funcionários
CREATE TABLE funcionarios (
    id_funcionario INT PRIMARY KEY AUTO_INCREMENT,
    nm_funcionario VARCHAR(100) NOT NULL,
    cd_login VARCHAR(50) NOT NULL UNIQUE,
    id_nivel INT NOT NULL
);

-- Criar tabela de tipos de corte
CREATE TABLE tipos_corte (
    id_corte INT PRIMARY KEY AUTO_INCREMENT,
    nm_corte VARCHAR(100) NOT NULL,
    nr_preco DECIMAL(10, 2) NOT NULL,
    ds_corte TEXT
);

select * from usuarios;
