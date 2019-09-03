<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

use Doctrine\ORM\Query\Expr\Join;

use Doctrine\ORM\Query\ResultSetMapping;



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

    public function searchSorties($site, $nom, $dateMin, $dateMax, $checkbox, User $user){

        $result = $this->createQueryBuilder('a');
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
            if (in_array('userSubscribed', $checkbox) && in_array('userNotSubscribed', $checkbox)){

            }
                else if (in_array('userSubscribed', $checkbox)){
                    $result->join('a.inscriptions', 'i')
                        ->andWhere('i.participant = :user')
                        ->setParameter('user', $user);
                    dump('ccccc');
                }
                else if(in_array('userNotSubscribed', $checkbox)) {

                    $result->leftJoin('a.inscriptions', 'i')
                        ->andWhere('i.participant != :user')
                        ->setParameter('user', $user);

                    //$result->andWhere(':user  MEMBER OF a.inscriptions')
                        //->setParameter('user', $user);
                    //$result->leftJoin('a.inscriptions', 'i', "WITH", "i.participant != :user")
                        //->andWhere(':user MEMBER OF a.inscriptions')
                        //->orWhere(':user NOT IN(45)')
                        //->orWhere('i.participant is NULL')

                        //->leftJoin('n.participant', 'p')
                        //->andWhere('p = :user')
                        //->setParameter('user', $user);
                        //->where('n.participant = :user')
                        //->setParameter('user', $user);
                }
            if (in_array('sortiesFinies', $checkbox)) {
                $result->andWhere("a.etat = 'PAS'");
            }
            ;
            dump($result->getQuery());
        return $result->getQuery()->getResult();
    }

    public function getByVille($ville){
        $req = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.lieu = :ville')
            ->setParameter('ville', "9");
        $query = $req->getQuery();
        $result = $query->getResult();
        dump($result);

        return $result;
    }
    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
