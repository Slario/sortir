<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;



/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function searchSorties($site, $nom, $dateMin, $dateMax, $checkbox, User $user)
    {
        $result = $this->createQueryBuilder('a')
        ->andWhere('a.etat != "ARC"');
        if ($site) {
            $result->andWhere('a.site = :site')
                ->setParameter('site', $site);
        }
        if ($nom) {
            $result->andWhere('a.nom LIKE :nom')
                ->setParameter('nom', '%' . $nom . '%');
        }
        if ($dateMin) {
            $result->andWhere('a.dateDebut >= :dateMin')
                ->setParameter('dateMin', $dateMin);
        }
        if ($dateMax) {
            $result->andWhere('a.dateDebut <= :dateMax')
                ->setParameter('dateMax', $dateMax);
        }
        if (in_array('userIsOrga', $checkbox)) {
            $result->andWhere('a.organisateur = :user')
                ->setParameter('user', $user);
        }
        if (in_array('userSubscribed', $checkbox)) {
            $result->join('a.inscriptions', 'i')
                ->andWhere('i.participant = :user')
                ->setParameter('user', $user);
        }
        if (in_array('sortiesFinies', $checkbox)) {
            $result->andWhere("a.etat = 'PAS'");
        };


        $resultQuery = $result->getQuery()->getResult();
        dump($result->getQuery());
        $collecResultQuery = new ArrayCollection();
        foreach ($resultQuery as $coll) {
            $collecResultQuery->add($coll);
        }
        $notSubed = $this->resultNotSubscribed($user);


        if (!in_array('userNotSubscribed', $checkbox)) {
            return $collecResultQuery;
        } else if ($this->subedAndNotSubed($checkbox)) {

            return null;

        } else if ($site || $nom || $dateMin || $dateMax) {

            $collecAReturn = new ArrayCollection();
            foreach ($notSubed as $ns) {
                if ($collecResultQuery->contains($ns)) {
                    $collecAReturn->add($ns);
                }
                return $collecAReturn;
            }
        } else if (in_array('userSubscribed', $checkbox) || in_array('userIsOrga', $checkbox)
            || in_array('sortiesFinies', $checkbox)) {

            foreach ($notSubed as $ns) {
                if (!$collecResultQuery->contains($ns)) {
                    $collecResultQuery->add($ns);
                }
            }
            return $collecResultQuery;
        } else {
            return $notSubed;
        }
    }

    private function subedAndNotSubed($checkbox)
    {
        if (in_array('userSubscribed', $checkbox) && in_array('userNotSubscribed', $checkbox)) {
            return true;
        }
        return false;
    }

    private function resultNotSubscribed(User $user)
    {
        $sortiesARecup = new ArrayCollection();
        $sorties = $this->findAll();
        foreach ($sorties as $sortie) {
            $inscris = false;
            if ($sortie->getInscriptions()) {
                foreach ($sortie->getInscriptions() as $ins) {
                    if ($ins->getParticipant() === $user) {
                        $inscris = true;
                        break;
                    }
                }
            }


            if ($inscris === false) {
                $sortiesARecup->add($sortie);
            }
        }

        return $sortiesARecup;

    }



}
