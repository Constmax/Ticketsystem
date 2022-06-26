-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Jun 2022 um 22:42
-- Server-Version: 10.4.24-MariaDB
-- PHP-Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ticketdatabase`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `issue`
--

CREATE TABLE `issue` (
  `Fehler_ID` int(11) NOT NULL,
  `ticket_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `Raum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Gerät` text CHARACTER SET utf8 NOT NULL,
  `Beschreibung` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `issue`
--

INSERT INTO `issue` (`Fehler_ID`, `ticket_ID`, `user_ID`, `Raum`, `Gerät`, `Beschreibung`) VALUES
(22, 52, 0, 'W103', 'Kabel', 'Das HDMI Kabel, dass man den Computer anschließen muss ist kaputt.'),
(23, 53, 0, 'Q203', 'Beamer', 'Der Beamer geht nicht an'),
(24, 54, 0, '204', 'Beamerwagen', 'Bei dem Beamer wagen im zwieiten stock fehlt das Stromkabel für den Beamer'),
(25, 55, 0, 'Q3', 'Dokumentenkamera ', 'Die Documentenkamera hat immer ein Schwarzes Bild'),
(26, 56, 0, 'W3', 'Computer', 'Der Computer kann sich nicht mit dem Internet verbinden'),
(27, 57, 0, '302', 'Lautsprecher', 'Wenn ich den Lautsprecher anmache und ihn aufdrehe kommt kein Ton\r\n'),
(28, 58, 0, 'Q201', 'Beamer', 'Der Beamer falckert immer blau');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tickets`
--

CREATE TABLE `tickets` (
  `ticket_ID` int(11) NOT NULL,
  `fehler_ID` int(11) NOT NULL,
  `nutzer_ID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `StatusTicket` enum('open','closed','resolved') NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tickets`
--

INSERT INTO `tickets` (`ticket_ID`, `fehler_ID`, `nutzer_ID`, `title`, `created`, `StatusTicket`) VALUES
(52, 22, 12, 'Hdmi Kabel', '2022-06-26 21:27:22', 'resolved'),
(53, 23, 12, 'Beamer', '2022-06-26 21:28:16', 'open'),
(54, 24, 13, 'Beamerwagen', '2022-06-26 21:30:23', 'open'),
(55, 25, 13, 'Dokumentenkamera kaputt', '2022-06-26 21:31:23', 'open'),
(56, 26, 14, 'Computer', '2022-06-26 21:32:29', 'closed'),
(57, 27, 14, 'Lautsprecher gibt kein Ton', '2022-06-26 21:33:34', 'open'),
(58, 28, 14, 'Beamer', '2022-06-26 21:34:13', 'open');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tickets_comments`
--

CREATE TABLE `tickets_comments` (
  `kommentar_ID` int(11) NOT NULL,
  `ticket_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `kommentar` varchar(255) NOT NULL,
  `erstelldatum` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tickets_comments`
--

INSERT INTO `tickets_comments` (`kommentar_ID`, `ticket_ID`, `user_ID`, `kommentar`, `erstelldatum`) VALUES
(3, 52, 0, 'Das betroffene HDMI Kabel wurde ausgetauscht und der Beaner sollte damit wieder gehen', 2147483647),
(4, 56, 0, 'Das Lan-Kabel war nicht richtig reingesteckt und das Problem wurde behoben\r\n', 2147483647),
(5, 54, 0, 'Um welchen Beamerwagen handelt es sich denn?', 2147483647);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Nachname` text CHARACTER SET utf8 NOT NULL,
  `Vorname` text CHARACTER SET utf8 NOT NULL,
  `Passwort` varchar(255) NOT NULL,
  `Rechte` enum('admin','benutzer') CHARACTER SET utf8 NOT NULL DEFAULT 'benutzer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`User_ID`, `Email`, `Nachname`, `Vorname`, `Passwort`, `Rechte`) VALUES
(11, 'admin@schule.com', 'admin', 'admin', 'root', 'admin'),
(12, 'Max.Mustermann@schule.net', 'Mustermann', 'Max', '1234', 'benutzer'),
(13, 'Paul.H@ggb.kbs.schule', 'Hartmut', 'Paul', 'Dose123', 'benutzer'),
(14, 'Tiziano.k@schule.com', 'Kümler', 'Tiziano', 'passwort123', 'benutzer'),
(15, 'Malte.Schroeter@ggb.schule', 'Schröter', 'Malte', '9876', 'benutzer'),
(16, 'Kilian.Schild@gmail.net', 'Schild', 'Kilian', 'Schwert234', 'benutzer'),
(17, 'Matteo.S@ggb.kbs.uni', 'Schoenberger', 'Matteo', 'berger', 'benutzer');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`Fehler_ID`),
  ADD KEY `ticket_F_key` (`ticket_ID`),
  ADD KEY `user_F_key` (`user_ID`);

--
-- Indizes für die Tabelle `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_ID`),
  ADD KEY `fehler_F_key` (`fehler_ID`),
  ADD KEY `User_foreign_key` (`nutzer_ID`);

--
-- Indizes für die Tabelle `tickets_comments`
--
ALTER TABLE `tickets_comments`
  ADD PRIMARY KEY (`kommentar_ID`),
  ADD KEY `ticketr_foreignkey` (`ticket_ID`),
  ADD KEY `user_FOreignKey` (`user_ID`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `issue`
--
ALTER TABLE `issue`
  MODIFY `Fehler_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT für Tabelle `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT für Tabelle `tickets_comments`
--
ALTER TABLE `tickets_comments`
  MODIFY `kommentar_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `issue`
--
ALTER TABLE `issue`
  ADD CONSTRAINT `ticket_F_key` FOREIGN KEY (`ticket_ID`) REFERENCES `tickets` (`ticket_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_F_key` FOREIGN KEY (`user_ID`) REFERENCES `user` (`User_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `User_foreign_key` FOREIGN KEY (`nutzer_ID`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `fehler_F_key` FOREIGN KEY (`fehler_ID`) REFERENCES `issue` (`Fehler_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tickets_comments`
--
ALTER TABLE `tickets_comments`
  ADD CONSTRAINT `ticketr_foreignkey` FOREIGN KEY (`ticket_ID`) REFERENCES `tickets` (`ticket_ID`),
  ADD CONSTRAINT `user_FOreignKey` FOREIGN KEY (`user_ID`) REFERENCES `user` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
