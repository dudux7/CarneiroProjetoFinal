CREATE TABLE pessoas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(15),
    email VARCHAR(100) UNIQUE NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    adm ENUM('0', '1') DEFAULT '0'
);

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idPessoa INT,
    FOREIGN KEY (idPessoa) REFERENCES pessoas(id) ON DELETE CASCADE
);

CREATE TABLE barbeiros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idPessoa INT,
    dataContratacao DATE,
    especialidade VARCHAR(100),
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    FOREIGN KEY (idPessoa) REFERENCES pessoas(id) ON DELETE CASCADE
);

CREATE TABLE servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    valor DECIMAL(10, 2) NOT NULL,
    duracao INT NOT NULL,
    idBarbeiro INT,
    FOREIGN KEY (idBarbeiro) REFERENCES barbeiros(id) ON DELETE SET NULL
);

CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    datahora DATETIME NOT NULL,
    idCliente INT,
    idServico INT,
    status ENUM('pendente', 'confirmado', 'cancelado', 'concluído') DEFAULT 'pendente',
    observacoes TEXT,
    FOREIGN KEY (idCliente) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (idServico) REFERENCES servicos(id) ON DELETE SET NULL
);