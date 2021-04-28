<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;

use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{

    /**
    * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Evenement::class);
        $this->paginator = $paginator;
    }

    // /**
    //  * @return Evenement[] Returns an array of Evenement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Evenement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findEvenementByid($x)
    {
        return $this->createQueryBuilder('evenement')
            ->where('evenement.id LIKE :id OR evenement.datedebut LIKE :id OR evenement.datefin LIKE :id OR evenement.nom LIKE :id OR evenement.nbrparticipant LIKE :id ')
            ->setParameter('id', '%' . $x . '%')
            ->getQuery()
            ->getResult();
    }


    /**
     * Récupère les produits en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {


        $query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            5
        );
    }

    private function getSearchQuery(SearchData $search): QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('e')
            ->select('c', 'e')
            ->join('e.categories', 'c');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('e.nom LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }



        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categorie)')
                ->setParameter('categorie', $search->categories);
        }
        return $query;
    }



    public function findOneByIdJoinedToCategory($id)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT e, c FROM App\Entity\Evenement e
            JOIN e.categories c
            WHERE e.id = :id'
            )->setParameter('id', $id);

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
