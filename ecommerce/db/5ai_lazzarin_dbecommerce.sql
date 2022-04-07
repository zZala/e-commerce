-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 07, 2022 alle 17:40
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
  `Conditions` enum('New','Usage') NOT NULL,
  `Price` float NOT NULL,
  `Discount` int(3) NOT NULL DEFAULT 0,
  `Pieces` int(11) NOT NULL,
  `IdCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `articles`
--

INSERT INTO `articles` (`Id`, `Title`, `Description`, `Seller`, `Conditions`, `Price`, `Discount`, `Pieces`, `IdCategory`) VALUES
(1, 'La Russia di Putin', '«Siamo solo un mezzo, per lui. Un mezzo per rag­giungere il potere personale. Per questo dispone di noi come vuole. Può giocare con noi, se ne ha voglia. Può distruggerci, se lo desidera. Noi non siamo niente. Lui, finito dov’è per puro caso, è il dio e il re che dobbiamo temere e venerare. La Russia ha già avuto governanti di questa risma. Ed è finita in tragedia. In un bagno di sangue. In guerre civili. Io non voglio che accada di nuovo. Per questo ce l’ho con un tipico čekista sovietico che ascende al trono di Russia incedendo tronfio sul tappeto rosso del Cremlino».\r\nAnna Politkovskaja', 'zzala', 'New', 10, 10, 1, 4),
(2, 'Apple AirPods con custodia di ricarica tramite cavo (seconda generazione)', 'Informazioni su questo articolo\r\nTaglia unica, comodi da indossare tutto ilgiorno\r\nLa custodia si ricarica sia in wireless, usando un caricabatterie certificato Qi, sia tramite connettore Lightning\r\nSi accendono automaticamente esicollegano all’istante\r\nSetup semplicissimo su tutti i dispositivi Apple\r\nAttivazione rapida di Siri con il comando “Ehi Siri”\r\nConnessione istantanea anche da un dispositivo all’altro\r\nCustodia di ricarica per oltre 24 ore di autonomia', 'zzala', 'Usage', 110.98, 0, 2, 7);

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
(3, NULL),
(2, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `categories`
--

CREATE TABLE `categories` (
  `Id` int(11) NOT NULL,
  `Type` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categories`
--

INSERT INTO `categories` (`Id`, `Type`) VALUES
(1, 'Clothing'),
(2, 'Shoes'),
(3, 'Jewelry & Watches'),
(4, 'Books'),
(5, 'Movies'),
(6, 'Games'),
(7, 'Electronics'),
(8, 'Food'),
(9, 'Home, Garden & Tools'),
(10, 'Beverages'),
(11, 'Computers');

-- --------------------------------------------------------

--
-- Struttura della tabella `contains`
--

CREATE TABLE `contains` (
  `IdArticle` int(11) NOT NULL,
  `IdCart` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `contains`
--

INSERT INTO `contains` (`IdArticle`, `IdCart`, `Quantity`) VALUES
(1, 2, 4),
(1, 3, 3),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `includes`
--

CREATE TABLE `includes` (
  `IdWishlist` int(11) NOT NULL,
  `IdArticle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `includes`
--

INSERT INTO `includes` (`IdWishlist`, `IdArticle`) VALUES
(1, 1),
(6, 1);

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
-- Dump dei dati per la tabella `wishlists`
--

INSERT INTO `wishlists` (`Id`, `IdUser`) VALUES
(2, NULL),
(3, NULL),
(4, NULL),
(5, NULL),
(6, NULL),
(1, 3);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `carts`
--
ALTER TABLE `carts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
