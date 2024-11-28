    CREATE TABLE pessoas (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        telefone VARCHAR(15),
        email VARCHAR(100) UNIQUE NOT NULL,
        usuario VARCHAR(50) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        adm ENUM('0', '1', '2') DEFAULT '0'
    );

    CREATE TABLE clientes (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        idPessoa INT UNSIGNED NOT NULL,
        FOREIGN KEY (idPessoa) REFERENCES pessoas(id) ON DELETE CASCADE
    );

    CREATE TABLE barbeiros (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        idPessoa INT UNSIGNED NOT NULL,
        especialidade VARCHAR(100),
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        FOREIGN KEY (idPessoa) REFERENCES pessoas(id) ON DELETE CASCADE
    );


    CREATE TABLE datas (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        data DATE NOT NULL UNIQUE,
        feriado ENUM('0', '1') NOT NULL DEFAULT '0'
    );

    CREATE TABLE horarios (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        horario TIME NOT NULL UNIQUE,
        idBarbeiro INT UNSIGNED NOT NULL,
        status ENUM('disponível', 'ocupado') DEFAULT 'disponível',
        FOREIGN KEY (idBarbeiro) REFERENCES barbeiros(id) ON DELETE CASCADE
    );


    CREATE TABLE servicos (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descricao TEXT,
        valor DECIMAL(10, 2) NOT NULL,
        duracao INT NOT NULL,
        idBarbeiro INT UNSIGNED,
        FOREIGN KEY (idBarbeiro) REFERENCES barbeiros(id) ON DELETE SET NULL
    );


    CREATE TABLE agendamentos (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        idCliente INT UNSIGNED NOT NULL,
        idServico INT UNSIGNED,
        status ENUM('pendente', 'confirmado', 'cancelado', 'concluído') DEFAULT 'pendente',
        observacoes TEXT,
        id_data INT UNSIGNED NOT NULL,
        id_horario INT UNSIGNED NOT NULL,
        FOREIGN KEY (idCliente) REFERENCES clientes(id) ON DELETE CASCADE,
        FOREIGN KEY (idServico) REFERENCES servicos(id) ON DELETE SET NULL,
        FOREIGN KEY (id_data) REFERENCES datas(id) ON DELETE CASCADE,
        FOREIGN KEY (id_horario) REFERENCES horarios(id) ON DELETE CASCADE
    );

    DELIMITER $$

    
    CREATE TRIGGER atualizar_agendamento_ao_disponibilizar_horario
    AFTER UPDATE ON horarios
    FOR EACH ROW
    BEGIN
        -- Verifica se o status do horário foi alterado para 'disponível'
        IF NEW.status = 'disponível' THEN
            -- Atualiza o status do agendamento para 'cancelado' correspondente ao horário
            DELETE FROM agendamentos WHERE id_horario = NEW.id;
        END IF;
    END$$

    DELIMITER ;


/*CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    datahora DATETIME NOT NULL,
    idCliente INT,
    idServico INT,
    status ENUM('pendente', 'confirmado', 'cancelado', 'concluído') DEFAULT 'pendente',
    observacoes TEXT,
    FOREIGN KEY (idCliente) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (idServico) REFERENCES servicos(id) ON DELETE SET NULL
);*/

/* data precisa receber o id do barbeiro??????*/
