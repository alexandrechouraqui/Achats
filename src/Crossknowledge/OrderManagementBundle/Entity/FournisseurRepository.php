<?php

namespace Crossknowledge\OrderManagementBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FournisseurRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FournisseurRepository extends EntityRepository
{
    public function getTotal()
    {
        $qb = $this->createQueryBuilder('a')
                   ->select('COUNT(a)');     // On sélectionne simplement COUNT(a)

        return (int) $qb->getQuery()
                         ->getSingleScalarResult(); // Utilisation de getSingleScalarResult pour avoir directement le résultat du COUNT
    }
}