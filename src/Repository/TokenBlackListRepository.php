<?php

namespace App\Repository;

use App\Entity\TokenBlackList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * @extends ServiceEntityRepository<TokenBlackList>
 *
 * @method TokenBlackList|null find($id, $lockMode = null, $lockVersion = null)
 * @method TokenBlackList|null findOneBy(array $criteria, array $orderBy = null)
 * @method TokenBlackList[]    findAll()
 * @method TokenBlackList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenBlackListRepository extends ServiceEntityRepository
{
    private JWTTokenManagerInterface $JWTManager;

    public function __construct(ManagerRegistry $registry, JWTTokenManagerInterface $JWTManager)
    {
        $this->JWTManager = $JWTManager;
        parent::__construct($registry, TokenBlackList::class);
    }

    public function save(TokenBlackList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TokenBlackList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function addTokenToBlackList(string $token): void
    {
        $tokenBlackList = new TokenBlackList();
        $tokenBlackList->setToken($token);

        $tokenParts = explode(".", $token);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload);

        $tokenBlackList->setExpirationDate(new \DateTime('@' . $jwtPayload->exp));

        $this->save($tokenBlackList, true);
    }

    //    /**
    //     * @return TokenBlackList[] Returns an array of TokenBlackList objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TokenBlackList
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
