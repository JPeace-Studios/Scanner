-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 23 Paź 2020, 12:09
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `3c`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `account`
--

CREATE TABLE `account` (
  `id` int(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `account`
--

INSERT INTO `account` (`id`, `login`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson2`
--

CREATE TABLE `lesson2` (
  `sid` int(11) NOT NULL,
  `presence` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson2`
--

INSERT INTO `lesson2` (`sid`, `presence`) VALUES
(1, b'0'),
(2, b'0');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson3`
--

CREATE TABLE `lesson3` (
  `vfdvf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson4`
--

CREATE TABLE `lesson4` (
  `sid` int(11) NOT NULL,
  `presence` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson4`
--

INSERT INTO `lesson4` (`sid`, `presence`) VALUES
(1, b'0'),
(2, b'0');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson5`
--

CREATE TABLE `lesson5` (
  `sid` int(11) NOT NULL,
  `presence` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson5`
--

INSERT INTO `lesson5` (`sid`, `presence`) VALUES
(1, b'0'),
(2, b'0');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson6`
--

CREATE TABLE `lesson6` (
  `sid` int(11) NOT NULL,
  `presence` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson6`
--

INSERT INTO `lesson6` (`sid`, `presence`) VALUES
(1, b'0'),
(2, b'0');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson7`
--

CREATE TABLE `lesson7` (
  `sid` int(11) NOT NULL,
  `presence` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson7`
--

INSERT INTO `lesson7` (`sid`, `presence`) VALUES
(1, b'0'),
(2, b'0');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson8`
--

CREATE TABLE `lesson8` (
  `sid` int(11) NOT NULL,
  `presence` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson8`
--

INSERT INTO `lesson8` (`sid`, `presence`) VALUES
(1, b'0'),
(2, b'0');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson9`
--

CREATE TABLE `lesson9` (
  `sid` int(11) NOT NULL,
  `presence` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson9`
--

INSERT INTO `lesson9` (`sid`, `presence`) VALUES
(1, b'0'),
(2, b'0'),
(3, b'0'),
(4, b'0');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `students`
--

CREATE TABLE `students` (
  `sid` int(11) NOT NULL,
  `id` bigint(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `students`
--

INSERT INTO `students` (`sid`, `id`, `name`) VALUES
(1, 1234567890, 'Jonny Bed'),
(2, 3336669990, 'Ted Kaczynsky'),
(3, 496334419, 'Jan Pawel'),
(4, 487231571, 'TED');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `lesson2`
--
ALTER TABLE `lesson2`
  ADD PRIMARY KEY (`sid`);

--
-- Indeksy dla tabeli `lesson4`
--
ALTER TABLE `lesson4`
  ADD PRIMARY KEY (`sid`);

--
-- Indeksy dla tabeli `lesson5`
--
ALTER TABLE `lesson5`
  ADD PRIMARY KEY (`sid`);

--
-- Indeksy dla tabeli `lesson6`
--
ALTER TABLE `lesson6`
  ADD PRIMARY KEY (`sid`);

--
-- Indeksy dla tabeli `lesson7`
--
ALTER TABLE `lesson7`
  ADD PRIMARY KEY (`sid`);

--
-- Indeksy dla tabeli `lesson8`
--
ALTER TABLE `lesson8`
  ADD PRIMARY KEY (`sid`);

--
-- Indeksy dla tabeli `lesson9`
--
ALTER TABLE `lesson9`
  ADD PRIMARY KEY (`sid`);

--
-- Indeksy dla tabeli `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `account`
--
ALTER TABLE `account`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `lesson2`
--
ALTER TABLE `lesson2`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `lesson4`
--
ALTER TABLE `lesson4`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `lesson5`
--
ALTER TABLE `lesson5`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `lesson6`
--
ALTER TABLE `lesson6`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `lesson7`
--
ALTER TABLE `lesson7`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `lesson8`
--
ALTER TABLE `lesson8`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `lesson9`
--
ALTER TABLE `lesson9`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `students`
--
ALTER TABLE `students`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
