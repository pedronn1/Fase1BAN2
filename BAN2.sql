CREATE DATABASE ban2;

USE ban2;

CREATE TABLE Cidade (
    cidade_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100)
);

CREATE TABLE Funcionario (
    funcionario_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cidade_id INT,
    email VARCHAR(100),
    senha VARCHAR(255),
    FOREIGN KEY (cidade_id) REFERENCES Cidade(cidade_id) ON DELETE CASCADE
);

CREATE TABLE Cliente (
    cliente_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cidade_id INT,
    FOREIGN KEY (cidade_id) REFERENCES Cidade(cidade_id) ON DELETE CASCADE
);

CREATE TABLE Loja (
    loja_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cidade_id INT,
    rua VARCHAR(200),
    numero INT,
    bairro VARCHAR(100),
    FOREIGN KEY (cidade_id) REFERENCES Cidade(cidade_id) ON DELETE CASCADE
);


CREATE TABLE Fornecedor (
    fornecedor_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cnpj BIGINT(14),
    cidade_id INT,
    rua VARCHAR(200),
    numero INT,
    bairro VARCHAR(100),
    FOREIGN KEY (cidade_id) REFERENCES Cidade(cidade_id) ON DELETE CASCADE
);

CREATE TABLE Produto (
    produto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    preco DECIMAL(10, 2),
    fornecedor_id INT,
    FOREIGN KEY (fornecedor_id) REFERENCES Fornecedor(fornecedor_id) ON DELETE CASCADE
);

CREATE TABLE Venda (
    venda_id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    funcionario_id INT,
    loja_id INT,
    data_venda DATE,
    valor_total INT,
    FOREIGN KEY (cliente_id) REFERENCES Cliente(cliente_id) ON DELETE CASCADE,
    FOREIGN KEY (funcionario_id) REFERENCES Funcionario(funcionario_id) ON DELETE CASCADE,
    FOREIGN KEY (loja_id) REFERENCES Loja(loja_id) ON DELETE CASCADE
);

CREATE TABLE venda_produto (
    prod_venda_id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT,
    produto_id INT,
    quantidade INT,
    FOREIGN KEY (venda_id) REFERENCES Venda(venda_id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES Produto(produto_id) ON DELETE CASCADE
);

CREATE TABLE Compra (
    compra_id INT AUTO_INCREMENT PRIMARY KEY,
    fornecedor_id INT,
    funcionario_id INT,
    loja_id INT,
    data_compra DATE,
    valor_total INT,
    FOREIGN KEY (fornecedor_id) REFERENCES Fornecedor(fornecedor_id) ON DELETE CASCADE,
    FOREIGN KEY (funcionario_id) REFERENCES Funcionario(funcionario_id) ON DELETE CASCADE,
    FOREIGN KEY (loja_id) REFERENCES Loja(loja_id) ON DELETE CASCADE
);

CREATE TABLE compra_produto (
    prod_compra_id INT AUTO_INCREMENT PRIMARY KEY,
    compra_id INT,
    produto_id INT,
    quantidade INT,
    custo FLOAT,
    FOREIGN KEY (compra_id) REFERENCES Compra(compra_id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES Produto(produto_id) ON DELETE CASCADE
);

CREATE TABLE Estoque (
    estoque_id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT,
    quantidade INT,
    FOREIGN KEY (produto_id) REFERENCES Produto(produto_id) ON DELETE CASCADE
);


INSERT INTO Cidade (nome) VALUES
    ('Joinville'),
    ('Curitiba'),
    ('Cascavel'),
    ('Jaraguá'),
    ('Araquari'),
    ('Toledo'),
    ('Florianopolis'),
    ('Porto Alegre'),
    ('Curitibanos'),
    ('Maçaranduba');

INSERT INTO Funcionario (nome, cidade_id, email, senha) VALUES
    ('PEDRO', 1, 'funcionario1@example.com', 'PEDRO123'),
    ('GUSTAVO', 2, 'funcionario2@example.com', 'GUSTAVO123'),
    ('ANA', 3, 'funcionario3@example.com', 'ANA123'),
    ('BAN', 4, 'funcionario4@example.com', 'BAN123'),
    ('SOP', 5, 'funcionario5@example.com', 'SOP123'),
    ('Funcionario6', 6, 'funcionario6@example.com', 'senha123'),
    ('Funcionario7', 7, 'funcionario7@example.com', 'senha123'),
    ('Funcionario8', 8, 'funcionario8@example.com', 'senha123'),
    ('Funcionario9', 9, 'funcionario9@example.com', 'senha123'),
    ('Funcionario10', 10, 'funcionario10@example.com', 'senha123');

INSERT INTO Cliente (nome, cidade_id) VALUES
    ('Cliente 1', 1),
    ('Cliente 2', 2),
    ('Cliente 3', 3),
    ('Cliente 4', 4),
    ('Cliente 5', 5),
    ('Cliente 6', 6),
    ('Cliente 7', 7),
    ('Cliente 8', 8),
    ('Cliente 9', 9),
    ('Cliente 10', 10);

INSERT INTO Loja (nome, cidade_id, rua, numero, bairro) VALUES
    ('Loja 1', 1, 'Rua A', 123, 'Centro'),
    ('Loja 2', 2, 'Rua B', 456, 'Iririu'),
    ('Loja 3', 3, 'Rua C', 789, 'Nova Brasília'),
    ('Loja 4', 4, 'Rua D', 101, 'Bom Retiro'),
    ('Loja 5', 5, 'Rua E', 55, 'Aventireiro'),
    ('Loja 6', 6, 'Rua F', 333, 'São Marcos'),
    ('Loja 7', 7, 'Rua G', 777, 'Vila Nova'),
    ('Loja 8', 8, 'Rua H', 888, 'Vila Cubatão'),
    ('Loja 9', 9, 'Rua I', 222, 'Jardim Paraíso'),
    ('Loja 10', 10, 'Rua J', 777, 'Boa Vista');

INSERT INTO Fornecedor (nome, cnpj, cidade_id, rua, numero, bairro) VALUES
    ('Fornecedor A', 12345678901234, 1, 'Av. X', 789, 'Centro'),
    ('Fornecedor B', 98765432109876, 2, 'Av. Y', 456, 'Guanabara'),
    ('Fornecedor C', 45678901234567, 3, 'Av. Z', 123, 'Jardim Iririu'),
    ('Fornecedor D', 11111111111111, 4, 'Av. W', 321, 'Jardim Sofia'),
    ('Fornecedor E', 22222222222222, 5, 'Av. V', 444, 'Comasa'),
    ('Fornecedor F', 33333333333333, 6, 'Av. U', 555, 'Bom Retiro'),
    ('Fornecedor G', 44444444444444, 7, 'Av. T', 666, 'Zona Industrial'),
    ('Fornecedor H', 55555555555555, 8, 'Av. S', 777, 'Pirabeiraba'),
    ('Fornecedor I', 66666666666666, 9, 'Av. R', 888, 'Espinheiros'),
    ('Fornecedor J', 77777777777777, 10, 'Av. Q', 999, 'Ulises Guimarães');

-- Inserindo 10 elementos na tabela Produto
INSERT INTO Produto (nome, preco, fornecedor_id) VALUES
    ('Roda', 10.99, 1),
    ('Limpador de parabrisa', 15.99, 2),
    ('Escapamento', 20.49, 3),
    ('Radiador', 8.75, 4),
    ('Banco', 12.50, 5),
    ('Capô', 18.99, 6),
    ('Porta', 7.25, 7),
    ('Filtro', 9.99, 8),
    ('Fluido de radiador', 14.50, 9),
    ('Oleo', 22.99, 10);

-- Inserindo 10 elementos na tabela Venda
INSERT INTO Venda (cliente_id, funcionario_id, loja_id, data_venda, valor_total) VALUES
    (1, 1, 1, '2023-09-16', 35),
    (2, 2, 2, '2023-09-15', 45),
    (3, 3, 3, '2023-09-14', 55),
    (4, 4, 4, '2023-09-13', 28),
    (5, 5, 5, '2023-09-12', 40),
    (6, 6, 6, '2023-09-11', 60),
    (7, 7, 7, '2023-09-10', 22),
    (8, 8, 8, '2023-09-09', 18),
    (9, 9, 9, '2023-09-08', 33),
    (10, 10, 10, '2023-09-07', 72);

-- Inserindo 10 elementos na tabela venda_produto
INSERT INTO venda_produto (venda_id, produto_id, quantidade) VALUES
    (1, 1, 3),
    (1, 2, 2),
    (2, 2, 4),
    (2, 3, 1),
    (3, 3, 2),
    (3, 1, 1),
    (4, 4, 5),
    (4, 5, 3),
    (5, 5, 2),
    (5, 4, 4);

-- Inserindo 10 elementos na tabela Compra
INSERT INTO Compra (fornecedor_id, funcionario_id, loja_id, data_compra, valor_total) VALUES
    (1, 1, 1, '2023-09-06', 120),
    (2, 2, 2, '2023-09-05', 80),
    (3, 3, 3, '2023-09-04', 60),
    (4, 4, 4, '2023-09-03', 95),
    (5, 5, 5, '2023-09-02', 72),
    (6, 6, 6, '2023-09-01', 110),
    (7, 7, 7, '2023-08-31', 45),
    (8, 8, 8, '2023-08-30', 38),
    (9, 9, 9, '2023-08-29', 65),
    (10, 10, 10, '2023-08-28', 88);

-- Inserindo 10 elementos na tabela compra_produto
INSERT INTO compra_produto (compra_id, produto_id, quantidade, custo) VALUES
    (1, 1, 10, 100),
    (1, 2, 8, 120),
    (2, 2, 6, 80),
    (2, 3, 4, 60),
    (3, 3, 5, 75),
    (3, 1, 3, 30),
    (4, 4, 12, 150),
    (4, 5, 8, 96),
    (5, 5, 7, 84),
    (5, 4, 6, 72);

-- Inserindo 10 elementos na tabela Estoque
INSERT INTO Estoque (produto_id, quantidade) VALUES
    (1, 23),
    (2, 18),
    (3, 15),
    (4, 28),
    (5, 22),
    (6, 33),
    (7, 11),
    (8, 9),
    (9, 20),
    (10, 27);
