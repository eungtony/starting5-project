<?php

namespace AppBundle\Repository;
use AppBundle\Entity\UserTeam;
use Doctrine\ORM\EntityManager;

/**
 * UserTeamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserTeamRepository extends \Doctrine\ORM\EntityRepository
{
    public function getTeamRating($players)
    {
        $pointGuard = $players['pointGuard'];
        $shootingGuard = $players['shootingGuard'];
        $smallForward = $players['smallForward'];
        $powerForward = $players['powerForward'];
        $center = $players['center'];

        $average = ($pointGuard["rating"] + $shootingGuard["rating"] + $smallForward["rating"] + $powerForward["rating"] + $center["rating"]) / 5;

        return $average;
    }

    public function getOffRating($players)
    {
        $pointGuard = $players['pointGuard'];
        $shootingGuard = $players['shootingGuard'];
        $smallForward = $players['smallForward'];
        $powerForward = $players['powerForward'];
        $center = $players['center'];

        $average = ($pointGuard["offensiveRating"] + $shootingGuard["offensiveRating"] + $smallForward["offensiveRating"] + $powerForward["offensiveRating"] + $center["offensiveRating"]) / 5;

        return $average;
    }

    public function getDefRating($players)
    {
        $pointGuard = $players['pointGuard'];
        $shootingGuard = $players['shootingGuard'];
        $smallForward = $players['smallForward'];
        $powerForward = $players['powerForward'];
        $center = $players['center'];

        $average = ($pointGuard["offensiveRating"] + $shootingGuard["offensiveRating"] + $smallForward["offensiveRating"] + $powerForward["offensiveRating"] + $center["offensiveRating"]) / 5;

        return $average;
    }

    public function searchPlayer($min, $max, $ownTeamId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('ut')
            ->from('AppBundle:UserTeam', 'ut')
            ->leftJoin('AppBundle:User', 'u', 'WITH', 'u.id = ut.user')
            ->where('ut.id != :ownTeamId')
            ->andWhere('u.battleMode != :battleMode')
            ->setParameters(['ownTeamId' => $ownTeamId, 'battleMode' => 0])
            ->andWhere($qb->expr()->between('ut.teamRating', $min, $max))
            ->andWhere($qb->expr()->eq('ut.active', true))
            ->getQuery();

        $opponent = $query->getResult();

        return $opponent;
    }
}
