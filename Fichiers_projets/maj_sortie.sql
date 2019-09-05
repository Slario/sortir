-- A INSERER DANS LA DB

SET GLOBAL event_scheduler = ON;

CREATE DEFINER =`root`@`localhost` EVENT `archivage` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-09-04 10:12:00' ENDS '2019-09-30 00:00:00' ON COMPLETION PRESERVE ENABLE COMMENT 'com' DO UPDATE `sortie`
                                                                                                                                                                                       SET `etat`= 'ARC'
                                                                                                                                                                                       WHERE (DATE_ADD(sortie.date_debut, INTERVAL (sortie.duree + 43830) MINUTE) <
                                                                                                                                                                                              LOCALTIME)

CREATE DEFINER =`root`@`localhost` EVENT `passe de en cours a passee` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-08-07 00:00:00' ENDS '2019-09-30 00:00:00' ON COMPLETION PRESERVE ENABLE COMMENT 'com' DO UPDATE `sortie`
                                                                                                                                                                                                        SET `etat`= 'PAS'
                                                                                                                                                                                                        WHERE (DATE_ADD(sortie.date_debut, INTERVAL sortie.duree MINUTE) < LOCALTIME)
                                                                                                                                                                                                          AND (sortie.etat = 'ENC')

CREATE DEFINER =`root`@`localhost` EVENT `maj de close à en cours` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-09-04 00:00:00' ENDS '2019-10-17 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sortie`
                                                                                                                                                                                           SET `etat`= 'ENC'
                                                                                                                                                                                           WHERE (sortie.date_debut < LOCALTIME)
                                                                                                                                                                                             AND sortie.etat = 'CLO'

CREATE DEFINER =`root`@`localhost` EVENT `mise à jour de ouverte à clôture des inscriptions` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-06-05 10:12:00' ENDS '2019-12-12 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sortie`
                                                                                                                                                                                                                     SET `etat`= 'CLO'
                                                                                                                                                                                                                     WHERE (sortie.date_cloture < LOCALTIME)
                                                                                                                                                                                                                       AND (sortie.etat = 'OUV')
                                                                                                                                                                                                                       AND (sortie.etat = 'OUV')
