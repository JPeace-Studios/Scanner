-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Lis 2020, 23:01
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
-- Struktura tabeli dla tabeli `lesson126000`
--

CREATE TABLE `lesson126000` (
  `sid` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson126000`
--

INSERT INTO `lesson126000` (`sid`, `status`) VALUES
(1, 0),
(2, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson1601892600`
--

CREATE TABLE `lesson1601892600` (
  `sid` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson1601892600`
--

INSERT INTO `lesson1601892600` (`sid`, `status`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson1604933280`
--

CREATE TABLE `lesson1604933280` (
  `sid` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson1604933280`
--

INSERT INTO `lesson1604933280` (`sid`, `status`) VALUES
(1, 0),
(2, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson1620186900`
--

CREATE TABLE `lesson1620186900` (
  `sid` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson1620186900`
--

INSERT INTO `lesson1620186900` (`sid`, `status`) VALUES
(1, 0),
(2, 0);

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
(1, 1234567891, 'Ted'),
(2, 9876543210, 'Jimmy');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `lesson126000`
--
ALTER TABLE `lesson126000`
  ADD PRIMARY KEY (`sid`);

--
-- Indeksy dla tabeli `lesson1601892600`
--
ALTER TABLE `lesson1601892600`
  ADD PRIMARY KEY (`sid`);

--
-- Indeksy dla tabeli `lesson1604933280`
--
ALTER TABLE `lesson1604933280`
  ADD PRIMARY KEY (`sid`);

--
-- Indeksy dla tabeli `lesson1620186900`
--
ALTER TABLE `lesson1620186900`
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
-- AUTO_INCREMENT dla tabeli `lesson126000`
--
ALTER TABLE `lesson126000`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `lesson1601892600`
--
ALTER TABLE `lesson1601892600`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `lesson1604933280`
--
ALTER TABLE `lesson1604933280`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `lesson1620186900`
--
ALTER TABLE `lesson1620186900`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `students`
--
ALTER TABLE `students`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
