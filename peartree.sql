-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Lip 2022, 18:17
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `peartree`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dialogues`
--

CREATE TABLE `dialogues` (
  `id` int(11) NOT NULL,
  `peartree_character` varchar(30) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `peartree_line` varchar(2000) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `peartree_tag` varchar(1000) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `peartree_link` varchar(200) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `peartree_min_fp` int(11) DEFAULT NULL,
  `peartree_image` varchar(200) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `peartree_weather` varchar(200) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `dialogues`
--

INSERT INTO `dialogues` (`id`, `peartree_character`, `peartree_line`, `peartree_tag`, `peartree_link`, `peartree_min_fp`, `peartree_image`, `peartree_weather`) VALUES
(1, 'Anna', 'Witaj, ładna pogoda, czyż nie?', 'gr', '3,4', 0, 'anna_wesola', 'sunny'),
(2, 'Anna', 'Cześć! Oh, ale dzisiaj brzydko na dworze.', 'gr', '50,51', 0, 'anna_neutral', 'rainy'),
(3, 'Gracz', 'To prawda, bardzo lubię Słońce!', '', '52', 0, '', ''),
(4, 'Gracz', 'Uh, od tego całego Słońca boli mnie głowa.', '', '53', 0, '', ''),
(50, 'Gracz', 'Ja tam bardzo lubię deszcz.', '', '53', 0, '', ''),
(51, 'Gracz', 'Masz rację Anno, w ogóle nie podoba mi się ta pogoda.', '', '52', 0, '', ''),
(52, 'Anna', 'O, widzę, że się zgadzamy! Hm, a masz może ochotę na herbatkę?', '', '54,55', 0, 'anna_wesola', ''),
(53, 'Anna', 'Oh, rozumiem. ', '', '', 0, 'anna_neutral', ''),
(54, 'Gracz', 'Jasne, o której?', '', '56', 0, '', ''),
(55, 'Gracz', 'Nie dzięki, może innym razem.', '', '', 0, '', ''),
(56, 'Anna', 'Zapraszam popołudniu. Zatem do zobaczenia!', '', '', 0, 'anna_wesola', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL,
  `password` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'Admin', 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_table_connection`
--

CREATE TABLE `user_table_connection` (
  `id_user` int(11) NOT NULL,
  `table_name` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `user_table_connection`
--

INSERT INTO `user_table_connection` (`id_user`, `table_name`) VALUES
(1, 'dialogues');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dialogues`
--
ALTER TABLE `dialogues`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `dialogues`
--
ALTER TABLE `dialogues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
