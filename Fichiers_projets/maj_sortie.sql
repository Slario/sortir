SELECT prix_vente, prix_propose FROM VENTES
                                         INNER JOIN ENCHERES ON VENTES.no_utilisateur = 1 AND ENCHERES.no_utilisateur = 	5


WHERE VENTES.date_fin_encheres <= CAST(CURRENT_TIMESTAMP as date) AND encheres
SELECT * FROM VENTES
                  INNER JOIN ENCHERES ON VENTES.no_utilisateur = 1 AND ENCHERES.no_utilisateur = 	5


-- Mise à jour de ouverte à close quand on ne peut plus s'inscrire
UPDATE `sortie` SET `etat`= 'CLOS' WHERE (sortie.date_cloture < LOCALTIME) AND (sortie.etat = 'OUV');
-- Mise à jour de ouverte/close à en cours une fois l'événement commencé
UPDATE `sortie` SET `etat`= 'ENC' WHERE (sortie.date_debut < LOCALTIME) AND (sortie.etat = 'OUV') OR (sortie.etat = 'CLOS');
-- Mise à jour de en cours à passée une fois le temps terminé
UPDATE `sortie` SET `etat`= 'PAS' WHERE (DATE_ADD(sortie.date_debut, INTERVAL sortie.duree MINUTE) < LOCALTIME) AND (sortie.etat = 'ENC');
-- Mise à jour de passée à archivée après un mois
UPDATE `sortie` SET `etat`= 'ARC' WHERE (DATE_ADD(sortie.date_debut, INTERVAL (sortie.duree + 43830) MINUTE) < LOCALTIME);