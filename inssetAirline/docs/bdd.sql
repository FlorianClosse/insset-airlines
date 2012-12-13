-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 13 Décembre 2012 à 16:14
-- Version du serveur: 5.5.28
-- Version de PHP: 5.4.6-1ubuntu1.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `airlinesBDD`
--

-- --------------------------------------------------------

--
-- Structure de la table `aeroport`
--

CREATE TABLE IF NOT EXISTS `aeroport` (
  `idAeroport` int(11) NOT NULL AUTO_INCREMENT,
  `nomAeroport` varchar(100) DEFAULT NULL,
  `trigramme` varchar(3) DEFAULT NULL,
  `longueurPiste` int(11) DEFAULT NULL,
  `idVille` int(11) DEFAULT NULL,
  PRIMARY KEY (`idAeroport`),
  KEY `v1` (`idVille`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `aeroport`
--

INSERT INTO `aeroport` (`idAeroport`, `nomAeroport`, `trigramme`, `longueurPiste`, `idVille`) VALUES
(1, 'aeroport de saint quentin', 'SQU', 160, 1),
(2, 'aeroport de cambrai', 'CAM', 95, 2),
(3, 'aeroport de arras', 'ARR', 238, 3);

-- --------------------------------------------------------

--
-- Structure de la table `avion`
--

CREATE TABLE IF NOT EXISTS `avion` (
  `idAvion` int(11) NOT NULL AUTO_INCREMENT,
  `numImmatriculation` varchar(100) DEFAULT NULL,
  `dateMisEnService` date DEFAULT NULL,
  `nombreHeureTotale` int(11) DEFAULT NULL,
  `nbHeureVolDepuisGrandeRevision` int(11) DEFAULT NULL,
  `nbHeureVolDepuisPetiteRevision` int(11) DEFAULT NULL,
  `statut` varchar(100) DEFAULT NULL,
  `idModele` int(11) DEFAULT NULL,
  `localisation` int(11) DEFAULT NULL,
  `idAeroportDattache` int(11) DEFAULT NULL,
  PRIMARY KEY (`idAvion`),
  KEY `avion2` (`idModele`),
  KEY `avion3` (`idAeroportDattache`),
  KEY `avion4` (`localisation`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `avion`
--

INSERT INTO `avion` (`idAvion`, `numImmatriculation`, `dateMisEnService`, `nombreHeureTotale`, `nbHeureVolDepuisGrandeRevision`, `nbHeureVolDepuisPetiteRevision`, `statut`, `idModele`, `localisation`, `idAeroportDattache`) VALUES
(1, '3514724566', '2012-11-08', 34, 0, 0, 'en vol', 1, 1, 1),
(2, '67365387326', '2012-11-01', 50, 0, 0, 'en vol', 3, 3, 2),
(3, 'ddddddd', '0000-00-00', 0, 0, 0, '1', 4, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `brevet`
--

CREATE TABLE IF NOT EXISTS `brevet` (
  `idBrevet` int(11) NOT NULL AUTO_INCREMENT,
  `dureeBrevetEnAnnee` int(11) DEFAULT NULL,
  `nomBrevet` varchar(30) NOT NULL,
  PRIMARY KEY (`idBrevet`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `brevet`
--

INSERT INTO `brevet` (`idBrevet`, `dureeBrevetEnAnnee`, `nomBrevet`) VALUES
(1, 4, 'brev1'),
(2, 2, 'truc'),
(3, 4, 'brevet3'),
(4, 1, 'brevet de super pilote'),
(5, 6, 'bbbb');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `idCommentaire` int(11) NOT NULL AUTO_INCREMENT,
  `idAvion` int(11) DEFAULT NULL,
  `commentaire` text,
  `dateCommentaire` date DEFAULT NULL,
  PRIMARY KEY (`idCommentaire`),
  KEY `commentaire1` (`idAvion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `commentaireVol`
--

CREATE TABLE IF NOT EXISTS `commentaireVol` (
  `idCommentaireVol` int(11) NOT NULL AUTO_INCREMENT,
  `idJournalDeBord` int(11) DEFAULT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `commentaire` text,
  PRIMARY KEY (`idCommentaireVol`),
  KEY `cv1` (`idJournalDeBord`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `jour`
--

CREATE TABLE IF NOT EXISTS `jour` (
  `idJour` int(11) NOT NULL AUTO_INCREMENT,
  `libelleJour` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idJour`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `jour`
--

INSERT INTO `jour` (`idJour`, `libelleJour`) VALUES
(1, 'lundi'),
(2, 'mardi'),
(3, 'mercredi'),
(4, 'jeudi'),
(5, 'vendredi'),
(6, 'samedi'),
(7, 'dimanche');

-- --------------------------------------------------------

--
-- Structure de la table `journalDeBord`
--

CREATE TABLE IF NOT EXISTS `journalDeBord` (
  `idJournalDeBord` int(11) NOT NULL AUTO_INCREMENT,
  `idPilote` int(11) DEFAULT NULL,
  `idCoPilote` int(11) DEFAULT NULL,
  `idAvion` int(11) DEFAULT NULL,
  `idVol` int(11) DEFAULT NULL,
  `dateDepart` date DEFAULT NULL,
  `nbPlaceDispo` int(11) DEFAULT NULL,
  `statut` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idJournalDeBord`),
  KEY `j1` (`idPilote`),
  KEY `j2` (`idCoPilote`),
  KEY `j3` (`idAvion`),
  KEY `j4` (`idVol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `journalDeBord`
--

INSERT INTO `journalDeBord` (`idJournalDeBord`, `idPilote`, `idCoPilote`, `idAvion`, `idVol`, `dateDepart`, `nbPlaceDispo`, `statut`) VALUES
(1, 1, 2, 1, 2, '2012-12-12', 200, 'attente'),
(2, 3, 4, 2, 8, '2012-11-20', 40, 'attente'),
(3, 3, 4, 1, 10, '2012-12-13', 4444, 'en vol'),
(4, 1, 5, 2, 9, '2012-12-13', 33, 'en vol'),
(5, 2, 3, 1, 12, '2012-12-13', 55, 'en vol'),
(6, 1, 2, 2, 13, '2012-12-13', 77, 'attente'),
(7, 3, 4, 2, 14, '2012-12-13', 55, 'attente');

-- --------------------------------------------------------

--
-- Structure de la table `liaisonBrevetModele`
--

CREATE TABLE IF NOT EXISTS `liaisonBrevetModele` (
  `idBrevet` int(11) NOT NULL DEFAULT '0',
  `idModele` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idBrevet`,`idModele`),
  KEY `lbm1` (`idModele`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `liaisonPiloteBrevet`
--

CREATE TABLE IF NOT EXISTS `liaisonPiloteBrevet` (
  `idPilote` int(11) NOT NULL DEFAULT '0',
  `idBrevet` int(11) NOT NULL DEFAULT '0',
  `dateDobtention` date DEFAULT NULL,
  PRIMARY KEY (`idPilote`,`idBrevet`),
  KEY `a2` (`idBrevet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `liaisonPiloteBrevet`
--

INSERT INTO `liaisonPiloteBrevet` (`idPilote`, `idBrevet`, `dateDobtention`) VALUES
(1, 1, '2012-12-12'),
(3, 4, '2012-12-12');

-- --------------------------------------------------------

--
-- Structure de la table `liaisonVolJour`
--

CREATE TABLE IF NOT EXISTS `liaisonVolJour` (
  `idJour` int(11) NOT NULL DEFAULT '0',
  `idVol` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idJour`,`idVol`),
  KEY `lvj2` (`idVol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `liaisonVolJour`
--

INSERT INTO `liaisonVolJour` (`idJour`, `idVol`) VALUES
(1, 8),
(3, 8),
(4, 8),
(7, 8),
(6, 9),
(7, 9),
(3, 10),
(4, 10),
(1, 11),
(2, 11),
(3, 11),
(4, 11),
(5, 11),
(6, 11),
(7, 11),
(1, 14),
(2, 14),
(3, 14),
(1, 15),
(2, 15),
(3, 15),
(3, 16),
(4, 16),
(3, 17),
(7, 17),
(3, 18),
(7, 18);

-- --------------------------------------------------------

--
-- Structure de la table `messageModifVol`
--

CREATE TABLE IF NOT EXISTS `messageModifVol` (
  `idMessage` int(11) NOT NULL AUTO_INCREMENT,
  `message` text,
  `statut` varchar(50) DEFAULT NULL,
  `dateMessage` date DEFAULT NULL,
  `idAeroport` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMessage`),
  KEY `mess1` (`idAeroport`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `modele`
--

CREATE TABLE IF NOT EXISTS `modele` (
  `idModele` int(11) NOT NULL AUTO_INCREMENT,
  `nomModele` varchar(50) DEFAULT NULL,
  `longueurPiste` int(11) DEFAULT NULL,
  `rayonDaction` int(11) DEFAULT NULL,
  `nbPlace` int(11) DEFAULT NULL,
  `periodePetiteRevision` int(11) DEFAULT NULL,
  `periodeGrandeRevision` int(11) DEFAULT NULL,
  PRIMARY KEY (`idModele`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `modele`
--

INSERT INTO `modele` (`idModele`, `nomModele`, `longueurPiste`, `rayonDaction`, `nbPlace`, `periodePetiteRevision`, `periodeGrandeRevision`) VALUES
(1, 'A247', 780, 1500, 260, 230, 1400),
(2, 'medele2', 500, 1000, 200, 200, 1000),
(3, 'A380', 1200, 3500, 840, 140, 800),
(4, 'url', 120, 250, 4, 150, 1500),
(5, 'machin', 300, 800, 150, 400, 2000);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `idPays` int(11) NOT NULL AUTO_INCREMENT,
  `nomPays` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idPays`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `pays`
--

INSERT INTO `pays` (`idPays`, `nomPays`) VALUES
(1, 'france');

-- --------------------------------------------------------

--
-- Structure de la table `pilote`
--

CREATE TABLE IF NOT EXISTS `pilote` (
  `idPilote` int(11) NOT NULL AUTO_INCREMENT,
  `nomPilote` varchar(100) DEFAULT NULL,
  `prenomPilote` varchar(100) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `idPays` int(11) DEFAULT NULL,
  `idAeroportEmbauche` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPilote`),
  KEY `p1` (`idAeroportEmbauche`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `pilote`
--

INSERT INTO `pilote` (`idPilote`, `nomPilote`, `prenomPilote`, `adresse`, `telephone`, `email`, `idPays`, `idAeroportEmbauche`) VALUES
(1, 'dupon', 'jean', '15 rue machin', '0635854312', 'jeandupon@gmail.com', 1, 1),
(2, 'derache', 'matthieu', '6 rue pasteur', '0644444444', 'mathDerache@gmail.com', 1, 2),
(3, 'beze', 'nicolas', '6 rue pasteur', '0623370599', 'nicolas.beze@laposte.net', 1, 3),
(4, 'closse', 'florian', '1 rue truck', '0633333333', 'flo.closse@gmail.com', 1, 1),
(5, 'doyen', 'cyril', '2 rue blabla', '0688888888', 'cyrilD@hotmail.fr', 1, 2),
(6, 'zzzzz', 'zzzzz', 'zzzzzzz', '1111111111', 'nnnnn@laposte.net', NULL, 1),
(7, 'zzzzz', 'zzzzz', 'zzzzzzz', '1111111111', 'nnnnn@laposte.net', NULL, 1),
(8, 'zzz', 'zzz', 'zzz', 'zzz', 'zzzz', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `idReservation` int(11) NOT NULL AUTO_INCREMENT,
  `statutReservation` varchar(50) DEFAULT NULL,
  `idJournal` int(11) DEFAULT NULL,
  PRIMARY KEY (`idReservation`),
  KEY `mess1` (`idJournal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `revision`
--

CREATE TABLE IF NOT EXISTS `revision` (
  `idRevision` int(11) NOT NULL AUTO_INCREMENT,
  `immatriculationAvion` varchar(100) DEFAULT NULL,
  `datePrevue` date DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `commentaire` text,
  `statutRevision` varchar(25) DEFAULT NULL,
  `idAvion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idRevision`),
  KEY `r1` (`idAvion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `nomUser` varchar(40) DEFAULT NULL,
  `prenomUser` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `motDePasse` varchar(40) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `service` int(11) DEFAULT NULL,
  `idAeroport` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  KEY `user` (`idAeroport`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE IF NOT EXISTS `ville` (
  `idVille` int(11) NOT NULL AUTO_INCREMENT,
  `nomVille` varchar(100) DEFAULT NULL,
  `cpVille` varchar(10) DEFAULT NULL,
  `idPays` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVille`),
  KEY `v1` (`idPays`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `ville`
--

INSERT INTO `ville` (`idVille`, `nomVille`, `cpVille`, `idPays`) VALUES
(1, 'saint-quentin', '02100', 1),
(2, 'cambrai', '59400', 1),
(3, 'arras', '62000', 1);

-- --------------------------------------------------------

--
-- Structure de la table `vol`
--

CREATE TABLE IF NOT EXISTS `vol` (
  `idVol` int(11) NOT NULL AUTO_INCREMENT,
  `numVol` varchar(100) DEFAULT NULL,
  `periodicite` int(11) DEFAULT NULL,
  `aeroportDepart` int(11) DEFAULT NULL,
  `aeroportArrivee` int(11) DEFAULT NULL,
  `datePrevu` date DEFAULT NULL,
  `dureeVol` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVol`),
  KEY `v2` (`aeroportDepart`),
  KEY `v3` (`aeroportArrivee`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `vol`
--

INSERT INTO `vol` (`idVol`, `numVol`, `periodicite`, `aeroportDepart`, `aeroportArrivee`, `datePrevu`, `dureeVol`) VALUES
(2, 'blablabla', NULL, 1, 3, '2012-10-21', 75),
(8, 'blablabla', NULL, 2, 3, NULL, 500),
(9, 'num342657', NULL, 2, 1, NULL, 456),
(10, 'aaaaaaaaaaaaa', NULL, 1, 1, NULL, 405),
(11, 'aaaaaaaaaazzzzzzzzzzzzzzzzzz', NULL, 1, 3, NULL, 345),
(12, '', NULL, 1, 1, '2012-10-10', 0),
(13, '', NULL, 1, 1, '2012-10-10', 0),
(14, 'aaaaaaa', NULL, 1, 1, NULL, 240),
(15, '111111111111111111111', NULL, 1, 1, NULL, 345),
(16, '9', NULL, 1, 1, NULL, 0),
(17, '123', NULL, 1, 2, NULL, 207360),
(18, '123', NULL, 1, 2, NULL, 1003);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `aeroport`
--
ALTER TABLE `aeroport`
  ADD CONSTRAINT `aeroport_ibfk_1` FOREIGN KEY (`idVille`) REFERENCES `ville` (`idVille`);

--
-- Contraintes pour la table `avion`
--
ALTER TABLE `avion`
  ADD CONSTRAINT `avion_ibfk_1` FOREIGN KEY (`idModele`) REFERENCES `modele` (`idModele`),
  ADD CONSTRAINT `avion_ibfk_2` FOREIGN KEY (`idAeroportDattache`) REFERENCES `aeroport` (`idAeroport`),
  ADD CONSTRAINT `avion_ibfk_3` FOREIGN KEY (`localisation`) REFERENCES `aeroport` (`idAeroport`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`idAvion`) REFERENCES `avion` (`idAvion`);

--
-- Contraintes pour la table `commentaireVol`
--
ALTER TABLE `commentaireVol`
  ADD CONSTRAINT `commentaireVol_ibfk_1` FOREIGN KEY (`idJournalDeBord`) REFERENCES `journalDeBord` (`idJournalDeBord`);

--
-- Contraintes pour la table `journalDeBord`
--
ALTER TABLE `journalDeBord`
  ADD CONSTRAINT `journalDeBord_ibfk_1` FOREIGN KEY (`idPilote`) REFERENCES `pilote` (`idPilote`),
  ADD CONSTRAINT `journalDeBord_ibfk_2` FOREIGN KEY (`idCoPilote`) REFERENCES `pilote` (`idPilote`),
  ADD CONSTRAINT `journalDeBord_ibfk_3` FOREIGN KEY (`idAvion`) REFERENCES `avion` (`idAvion`),
  ADD CONSTRAINT `journalDeBord_ibfk_4` FOREIGN KEY (`idVol`) REFERENCES `vol` (`idVol`);

--
-- Contraintes pour la table `liaisonBrevetModele`
--
ALTER TABLE `liaisonBrevetModele`
  ADD CONSTRAINT `liaisonBrevetModele_ibfk_1` FOREIGN KEY (`idBrevet`) REFERENCES `brevet` (`idBrevet`),
  ADD CONSTRAINT `liaisonBrevetModele_ibfk_2` FOREIGN KEY (`idModele`) REFERENCES `modele` (`idModele`);

--
-- Contraintes pour la table `liaisonPiloteBrevet`
--
ALTER TABLE `liaisonPiloteBrevet`
  ADD CONSTRAINT `liaisonPiloteBrevet_ibfk_1` FOREIGN KEY (`idPilote`) REFERENCES `pilote` (`idPilote`),
  ADD CONSTRAINT `liaisonPiloteBrevet_ibfk_2` FOREIGN KEY (`idBrevet`) REFERENCES `brevet` (`idBrevet`);

--
-- Contraintes pour la table `liaisonVolJour`
--
ALTER TABLE `liaisonVolJour`
  ADD CONSTRAINT `liaisonVolJour_ibfk_1` FOREIGN KEY (`idJour`) REFERENCES `jour` (`idJour`) ON DELETE CASCADE,
  ADD CONSTRAINT `liaisonVolJour_ibfk_2` FOREIGN KEY (`idVol`) REFERENCES `vol` (`idVol`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messageModifVol`
--
ALTER TABLE `messageModifVol`
  ADD CONSTRAINT `messageModifVol_ibfk_1` FOREIGN KEY (`idAeroport`) REFERENCES `aeroport` (`idAeroport`);

--
-- Contraintes pour la table `pilote`
--
ALTER TABLE `pilote`
  ADD CONSTRAINT `pilote_ibfk_1` FOREIGN KEY (`idAeroportEmbauche`) REFERENCES `aeroport` (`idAeroport`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`idJournal`) REFERENCES `journalDeBord` (`idJournalDeBord`);

--
-- Contraintes pour la table `revision`
--
ALTER TABLE `revision`
  ADD CONSTRAINT `revision_ibfk_1` FOREIGN KEY (`idAvion`) REFERENCES `avion` (`idAvion`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idAeroport`) REFERENCES `aeroport` (`idAeroport`);

--
-- Contraintes pour la table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `ville_ibfk_1` FOREIGN KEY (`idPays`) REFERENCES `pays` (`idPays`);

--
-- Contraintes pour la table `vol`
--
ALTER TABLE `vol`
  ADD CONSTRAINT `vol_ibfk_1` FOREIGN KEY (`aeroportDepart`) REFERENCES `aeroport` (`idAeroport`),
  ADD CONSTRAINT `vol_ibfk_2` FOREIGN KEY (`aeroportArrivee`) REFERENCES `aeroport` (`idAeroport`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

