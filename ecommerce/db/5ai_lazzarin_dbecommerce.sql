-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 01, 2022 alle 00:03
-- Versione del server: 10.4.22-MariaDB
-- Versione PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `5ai_lazzarin_dbecommerce`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `articles`
--

CREATE TABLE `articles` (
  `Id` int(11) NOT NULL,
  `Title` varchar(254) NOT NULL,
  `Description` text NOT NULL,
  `Seller` varchar(254) NOT NULL,
  `Conditions` enum('Nuovo','Usato') NOT NULL,
  `Price` float NOT NULL,
  `Pieces` int(11) NOT NULL,
  `IdCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `carts`
--

CREATE TABLE `carts` (
  `Id` int(11) NOT NULL,
  `IdUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `carts`
--

INSERT INTO `carts` (`Id`, `IdUser`) VALUES
(2, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `categories`
--

CREATE TABLE `categories` (
  `Id` int(11) NOT NULL,
  `Type` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `contains`
--

CREATE TABLE `contains` (
  `IdArticle` int(11) NOT NULL,
  `IdCart` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `includes`
--

CREATE TABLE `includes` (
  `IdWishlist` int(11) NOT NULL,
  `IdArticle` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `orders`
--

CREATE TABLE `orders` (
  `Id` int(11) NOT NULL,
  `SubmissionDate` date NOT NULL,
  `DeliveryDate` date NOT NULL,
  `PaymentMethod` int(11) NOT NULL,
  `ShippingAddress` int(11) NOT NULL,
  `ShippingCosts` float NOT NULL,
  `IdCart` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `reviews`
--

CREATE TABLE `reviews` (
  `IdArticle` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `Text` text NOT NULL,
  `Stars` enum('1','2','3','4','5') NOT NULL,
  `Date` date NOT NULL,
  `Title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `BirthDate` date NOT NULL,
  `Email` varchar(319) NOT NULL,
  `MobilePhoneNumber` varchar(12) NOT NULL,
  `Password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`Id`, `Username`, `FirstName`, `LastName`, `BirthDate`, `Email`, `MobilePhoneNumber`, `Password`) VALUES
(3, 'zzala', 'Andrea', 'Lazzarin', '2003-10-03', 'lazzarin.andrea03@gmail.com', '3312212839', '25ed1bcb423b0b7200f485fc5ff71c8e');

-- --------------------------------------------------------

--
-- Struttura della tabella `wishlists`
--

CREATE TABLE `wishlists` (
  `Id` int(11) NOT NULL,
  `IdUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ArticleCategory` (`IdCategory`);

--
-- Indici per le tabelle `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `IdUser` (`IdUser`),
  ADD KEY `CartUser` (`IdUser`);

--
-- Indici per le tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Id`);

--
-- Indici per le tabelle `contains`
--
ALTER TABLE `contains`
  ADD PRIMARY KEY (`IdArticle`,`IdCart`),
  ADD KEY `ContainCart` (`IdCart`);

--
-- Indici per le tabelle `includes`
--
ALTER TABLE `includes`
  ADD PRIMARY KEY (`IdWishlist`,`IdArticle`),
  ADD KEY `IncludeArticle` (`IdArticle`);

--
-- Indici per le tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `OrderCart` (`IdCart`);

--
-- Indici per le tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`IdArticle`,`IdUser`),
  ADD KEY `ReviewUser` (`IdUser`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indici per le tabelle `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `WishlistUser` (`IdUser`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `articles`
--
ALTER TABLE `articles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `carts`
--
ALTER TABLE `carts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `ArticleCategory` FOREIGN KEY (`IdCategory`) REFERENCES `categories` (`Id`);

--
-- Limiti per la tabella `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `CartUser` FOREIGN KEY (`IdUser`) REFERENCES `users` (`Id`);

--
-- Limiti per la tabella `contains`
--
ALTER TABLE `contains`
  ADD CONSTRAINT `ContainArticle` FOREIGN KEY (`IdArticle`) REFERENCES `articles` (`Id`),
  ADD CONSTRAINT `ContainCart` FOREIGN KEY (`IdCart`) REFERENCES `carts` (`Id`);

--
-- Limiti per la tabella `includes`
--
ALTER TABLE `includes`
  ADD CONSTRAINT `IncludeArticle` FOREIGN KEY (`IdArticle`) REFERENCES `articles` (`Id`),
  ADD CONSTRAINT `IncludeWishlist` FOREIGN KEY (`IdWishlist`) REFERENCES `wishlists` (`Id`);

--
-- Limiti per la tabella `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `OrderCart` FOREIGN KEY (`IdCart`) REFERENCES `carts` (`Id`);

--
-- Limiti per la tabella `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `ReviewArticle` FOREIGN KEY (`IdArticle`) REFERENCES `articles` (`Id`),
  ADD CONSTRAINT `ReviewUser` FOREIGN KEY (`IdUser`) REFERENCES `users` (`Id`);

--
-- Limiti per la tabella `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `WishlistUser` FOREIGN KEY (`IdUser`) REFERENCES `users` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
