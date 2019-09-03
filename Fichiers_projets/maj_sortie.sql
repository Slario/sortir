SELECT prix_vente, prix_propose FROM VENTES
                                         INNER JOIN ENCHERES ON VENTES.no_utilisateur = 1 AND ENCHERES.no_utilisateur = 	5


WHERE VENTES.date_fin_encheres <= CAST(CURRENT_TIMESTAMP as date) AND encheres
SELECT * FROM VENTES
                  INNER JOIN ENCHERES ON VENTES.no_utilisateur = 1 AND ENCHERES.no_utilisateur = 	5
-- Mise à jour de ouverte à close quand on ne peut plus s'inscrire
UPDATE `sortie` SET `etat`= 'CLOS' WHERE (sortie.date_cloture < LOCALTIME) AND (sortie.etat = 'OUV')
-- Mise à