-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Jan-2023 às 19:42
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `login_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `filme`
--

CREATE TABLE `filme` (
  `idmovie` int(255) NOT NULL,
  `moviename` varchar(50) NOT NULL,
  `preco` varchar(6) NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Disponivel',
  `cover` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `filme`
--

INSERT INTO `filme` (`idmovie`, `moviename`, `preco`, `estado`, `cover`) VALUES
(1, 'Harry Potter', '10.99', 'Indisponivel', 'harrypotter1.jpg'),
(2, 'Spider-Man', '12,99', 'Disponivel', 'spiderman.png'),
(6, 'Jaws', '3.99', 'Disponivel', 'jaws.jpg'),
(8, 'Infinity War', '9.99', 'Disponivel', 'avengers-infinity-war_89e0d364_480x.progressive..png'),
(9, 'Back From Future', '3.99', 'Indisponivel', 'backfromfuture.png'),
(10, 'CREED III', '10.99', 'Brevemente', 'creed3.jpg'),
(11, 'John Wick 4', '9.99', 'Disponivel', 'john_wick_chapter_four_ver2.jpg'),
(12, 'Indiana Jones', '4.99', 'Brevemente', 'indiana_jones_and_the_dial_of_destiny.jpg'),
(13, 'Black Panther', '9.99', 'Disponivel', 'black_panther_wakanda_forever_ver30.jpg'),
(14, 'SCREAM 6', '9.99', 'Indisponivel', 'scream_six.jpg'),
(15, '007 ', '12.99', 'Indisponivel', '194534529_519924755715883_7550284638314939040_n_480x.progressive.png'),
(16, 'Star Wars', '6.99', 'Disponivel', '23fd3ba334c1e8e84c96906497d577bf_6d652cf7-d705-42d2-96aa-2c3963f8a178_480x.progressive.png'),
(17, 'Matrix', '4.99', 'Brevemente', 'ed4796ac6feff9d2a6115406f964c928_6b200bda-fe71-4900-ad7f-903cdda50dab_480x.progressive.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `renthistory`
--

CREATE TABLE `renthistory` (
  `rentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `idmovie` int(11) NOT NULL,
  `moviename` varchar(255) NOT NULL,
  `preco` varchar(10) NOT NULL,
  `datetim` varchar(255) NOT NULL,
  `rentState` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `renthistory`
--

INSERT INTO `renthistory` (`rentid`, `userid`, `username`, `idmovie`, `moviename`, `preco`, `datetim`, `rentState`) VALUES
(98, 72, 'Joao', 16, 'Star Wars', '6.99', 'January 21, 2023, 6:00 pm', 'January 21, 2023, 6:00 pm'),
(99, 72, 'Joao', 15, '007 ', '12.99', 'January 21, 2023, 6:00 pm', 'Devolver'),
(100, 56, 'Marco Coelho', 1, 'Harry Potter', '10.99', 'January 21, 2023, 6:02 pm', 'January 21, 2023, 6:04 pm'),
(101, 56, 'Marco Coelho', 2, 'Spider-Man', '12,99', 'January 21, 2023, 6:02 pm', 'January 21, 2023, 6:04 pm'),
(102, 56, 'Marco Coelho', 9, 'Back From Future', '3.99', 'January 21, 2023, 6:02 pm', 'Devolver'),
(103, 73, 'Cliente1', 1, 'Harry Potter', '10.99', 'January 21, 2023, 6:07 pm', 'Devolver'),
(104, 73, 'Cliente1', 14, 'SCREAM 6', '9.99', 'January 21, 2023, 6:07 pm', 'Devolver');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nome` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'user',
  `fotourl` varchar(255) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `nome`, `email`, `password_hash`, `user_type`, `fotourl`) VALUES
(56, 'Marco Coelho', '8210079@estg.ipp.pt', '$2y$10$O70VEx0msxyUPdMbEPgT7eTyCciD9fegbGUTqrufBhNpLmLv/WDIe', 'admin', '4983798-gato-logo-preto-gato-andando-gato-silhueta-de-gato-gratis-vetor.jpg'),
(72, 'Joao', '8210072@estg.ipp.pt', '$2y$10$J5WmnkJC8cma8r9GlZFTc.HNXYO38gj4h00LDSFUrgzK3NV68s18S', 'user', '7d7b36c198f93f8d15a4389e56cde84f.jpg'),
(73, 'Cliente1', 'cliente1@server-79.pt', '$2y$10$4.p7YzOQ7I37myw3g/vftuJ85HleBIJA5j4N8g.M4JCnLwj2hmor6', 'user', 'default.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `filme`
--
ALTER TABLE `filme`
  ADD PRIMARY KEY (`idmovie`),
  ADD KEY `moviename` (`moviename`,`preco`);

--
-- Índices para tabela `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- Índices para tabela `renthistory`
--
ALTER TABLE `renthistory`
  ADD PRIMARY KEY (`rentid`),
  ADD KEY `fk_userid` (`userid`),
  ADD KEY `fk_idmovie` (`idmovie`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `nome` (`nome`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `filme`
--
ALTER TABLE `filme`
  MODIFY `idmovie` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `renthistory`
--
ALTER TABLE `renthistory`
  MODIFY `rentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
