-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 15, 2022 at 01:11 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

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
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `Id` int(11) NOT NULL,
  `Title` varchar(254) NOT NULL,
  `Description` text NOT NULL,
  `Seller` varchar(254) NOT NULL,
  `Conditions` enum('New','Usage') NOT NULL,
  `Price` float NOT NULL,
  `Discount` int(3) NOT NULL DEFAULT '0',
  `Pieces` int(11) NOT NULL,
  `IdCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`Id`, `Title`, `Description`, `Seller`, `Conditions`, `Price`, `Discount`, `Pieces`, `IdCategory`) VALUES
(1, 'La Russia di Putin', '«Siamo solo un mezzo, per lui. Un mezzo per rag­giungere il potere personale. Per questo dispone di noi come vuole. Può giocare con noi, se ne ha voglia. Può distruggerci, se lo desidera. Noi non siamo niente. Lui, finito dov’è per puro caso, è il dio e il re che dobbiamo temere e venerare. La Russia ha già avuto governanti di questa risma. Ed è finita in tragedia. In un bagno di sangue. In guerre civili. Io non voglio che accada di nuovo. Per questo ce l’ho con un tipico čekista sovietico che ascende al trono di Russia incedendo tronfio sul tappeto rosso del Cremlino».\r\nAnna Politkovskaja', 'zzala', 'New', 10, 10, 1, 4),
(2, 'Apple AirPods 2', 'Taglia unica, comodi da indossare tutto il giorno.\r\nLa custodia si ricarica sia in wireless, usando un caricabatterie certificato Qi, sia tramite connettore Lightning.\r\nSi accendono automaticamente esicollegano all’istante.\r\nSetup semplicissimo su tutti i dispositivi Apple.\r\nAttivazione rapida di Siri con il comando “Ehi Siri”.\r\nConnessione istantanea anche da un dispositivo all’altro.\r\nCustodia di ricarica per oltre 24 ore di autonomia.', 'zzala', 'Usage', 110.98, 0, 1, 7),
(3, 'Echo Dot (4ª generazione) - Alexa', '1) Ti presentiamo Echo Dot con orologio - Il nostro altoparlante intelligente con Alexa più venduto. Dal design sobrio e compatto, questo dispositivo offre un suono ricco, con voci nitide e bassi bilanciati.\r\n2) Perfetto sul comodino - Leggi che ore sono e controlla le sveglie e i timer che hai impostato sul display LED. Tocca la parte superiore del dispositivo per posticipare una sveglia.\r\n3) Sempre pronta ad aiutarti - Chiedi ad Alexa di raccontare una barzelletta, riprodurre musica, rispondere a domande, leggerti le ultime notizie, darti le previsioni del tempo, impostare sveglie e molto altro.\r\n4) Supporta l’audio HD senza perdita di qualità, disponibile con i servizi di musica in streaming compatibili, come Amazon Music HD.\r\n5) Controlla i tuoi dispositivi per Casa Intelligente - Usa la tua voce per controllare i dispositivi compatibili e accendere la luce, regolare un termostato o chiudere la porta.\r\n6) Resta sempre in contatto con gli altri - Effettua una chiamata senza dover usare le mani. Chiama immediatamente un dispositivo in un\'altra stanza con Drop In o annuncia a tutti che la cena è pronta.\r\n7) Progettato per tutelare la tua privacy - Echo Dot è stato costruito con diversi elementi per la protezione e il controllo della privacy, tra cui un apposito pulsante per disattivare i microfoni.\r\n', 'Amazon', 'New', 69.99, 36, 8, 7),
(18, 'Yeezy 350 V2 Beluga RF', 'Scarpe comodissime', 'zzala', 'New', 310, 10, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `Id` int(11) NOT NULL,
  `IdUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`Id`, `IdUser`) VALUES
(1, NULL),
(6, NULL),
(16, NULL),
(17, NULL),
(18, NULL),
(19, NULL),
(20, NULL),
(21, NULL),
(22, NULL),
(15, 1),
(23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Id` int(11) NOT NULL,
  `Type` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
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
(11, 'Computers'),
(12, 'Sport');

-- --------------------------------------------------------

--
-- Table structure for table `contains`
--

CREATE TABLE `contains` (
  `IdArticle` int(11) NOT NULL,
  `IdCart` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contains`
--

INSERT INTO `contains` (`IdArticle`, `IdCart`, `Quantity`) VALUES
(2, 15, 1),
(2, 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `includes`
--

CREATE TABLE `includes` (
  `IdWishlist` int(11) NOT NULL,
  `IdArticle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `includes`
--

INSERT INTO `includes` (`IdWishlist`, `IdArticle`) VALUES
(6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Id` int(11) NOT NULL,
  `SubmissionDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DeliveryDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PaymentMethod` varchar(255) NOT NULL,
  `ShippingAddress` varchar(255) NOT NULL,
  `ShippingCosts` float NOT NULL,
  `IdCart` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Id`, `SubmissionDate`, `DeliveryDate`, `PaymentMethod`, `ShippingAddress`, `ShippingCosts`, `IdCart`) VALUES
(11, '2022-05-09 22:22:03', '2022-05-15 22:00:00', 'Paypal', 'Via Burlone 10', 5, 16),
(12, '2022-05-10 15:47:12', '2022-05-16 22:00:00', 'Paypal', 'Via Burlone 10', 5, 21),
(13, '2022-05-10 15:55:16', '2022-05-16 22:00:00', 'Paypal', 'Via Burlone 10', 5, 15);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `Id` int(11) NOT NULL,
  `Type` enum('PayPal','Credit Card') NOT NULL,
  `Email` varchar(319) DEFAULT NULL,
  `CardNumber` varchar(16) DEFAULT NULL,
  `NameOnCard` varchar(100) DEFAULT NULL,
  `ExpirationDate` varchar(7) DEFAULT NULL,
  `IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`Id`, `Type`, `Email`, `CardNumber`, `NameOnCard`, `ExpirationDate`, `IdUser`) VALUES
(2, 'Credit Card', NULL, '1234567812345678', 'Lazzarin Andrea', '2032-06', 1),
(3, 'PayPal', 'lazzarin.andrea03@gmail.com', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `Id` int(11) NOT NULL,
  `IdArticle` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Stars` enum('1','2','3','4','5') NOT NULL,
  `Comment` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`Id`, `IdArticle`, `IdUser`, `Title`, `Stars`, `Comment`, `Date`) VALUES
(1, 2, 1, 'Ottimo acquisto', '3', 'consigliatissimo', '2022-04-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `BirthDate` date NOT NULL,
  `Email` varchar(319) NOT NULL,
  `MobilePhoneNumber` varchar(12) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Seller` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Username`, `FirstName`, `LastName`, `BirthDate`, `Email`, `MobilePhoneNumber`, `Password`, `Seller`) VALUES
(1, 'zzala', 'Andrea', 'Lazzarin', '2003-10-03', 'lazzarin.andrea03@gmail.com', '3312212839', '25ed1bcb423b0b7200f485fc5ff71c8e', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `Id` int(11) NOT NULL,
  `IdUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`Id`, `IdUser`) VALUES
(2, NULL),
(3, NULL),
(4, NULL),
(5, NULL),
(6, NULL),
(7, NULL),
(8, NULL),
(1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ArticleCategory` (`IdCategory`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdUser` (`IdUser`),
  ADD KEY `CartUser` (`IdUser`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `contains`
--
ALTER TABLE `contains`
  ADD PRIMARY KEY (`IdArticle`,`IdCart`),
  ADD KEY `ContainCart` (`IdCart`);

--
-- Indexes for table `includes`
--
ALTER TABLE `includes`
  ADD PRIMARY KEY (`IdWishlist`,`IdArticle`),
  ADD KEY `IncludeArticle` (`IdArticle`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `OrderCart` (`IdCart`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `PaymentMethodUser` (`IdUser`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ReviewUser` (`IdUser`),
  ADD KEY `ReviewArticle` (`IdArticle`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `WishlistUser` (`IdUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `ArticleCategory` FOREIGN KEY (`IdCategory`) REFERENCES `categories` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `CartUser` FOREIGN KEY (`IdUser`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contains`
--
ALTER TABLE `contains`
  ADD CONSTRAINT `ContainArticle` FOREIGN KEY (`IdArticle`) REFERENCES `articles` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ContainCart` FOREIGN KEY (`IdCart`) REFERENCES `carts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `includes`
--
ALTER TABLE `includes`
  ADD CONSTRAINT `IncludeArticle` FOREIGN KEY (`IdArticle`) REFERENCES `articles` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IncludeWishlist` FOREIGN KEY (`IdWishlist`) REFERENCES `wishlists` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `OrderCart` FOREIGN KEY (`IdCart`) REFERENCES `carts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `PaymentMethodUser` FOREIGN KEY (`IdUser`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `ReviewArticle` FOREIGN KEY (`IdArticle`) REFERENCES `articles` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ReviewUser` FOREIGN KEY (`IdUser`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `WishlistUser` FOREIGN KEY (`IdUser`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
