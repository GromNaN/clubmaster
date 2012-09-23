<?php

namespace Club\RankingBundle\Helper;

class Ranking
{
    protected $em;
    protected $translator;
    protected $club_match;

    protected $ranking;
    protected $match;

    public function __construct($em, $translator, $club_match)
    {
        $this->em = $em;
        $this->translator = $translator;
        $this->club_match = $club_match;
    }

    public function addPoint(\Club\MatchBundle\Entity\Match $match)
    {
        $ranking = $this->em->getRepository('ClubRankingBundle:Ranking')->getByMatch($match);
        if (!$ranking) return;

        foreach ($match->getMatchTeams() as $match_team) {

            $lt = $this->em->getRepository('ClubRankingBundle:RankingEntry')->getTeam($ranking, $match_team->getTeam());

            if ($match_team == $match->getWinner()) {
                $lt->setPlayed($lt->getPlayed()+1);
                $lt->setWon($lt->getWon()+1);
                $lt->setPoint($lt->getPoint()+$ranking->getRule()->getPointWon());

            } else {
                $lt->setPlayed($lt->getPlayed()+1);
                $lt->setLost($lt->getLost()+1);
                $lt->setPoint($lt->getPoint()+$ranking->getRule()->getPointLost());

            }

            $this->em->persist($lt);
            $this->em->flush();
        }
    }

    public function revokePoint(\Club\MatchBundle\Entity\Match $match)
    {
        //if (!$match->getProcessed()) return;

        $ranking = $this->em->getRepository('ClubRankingBundle:Ranking')->getByMatch($match);
        if (!$ranking) return;

        foreach ($match->getMatchTeams() as $match_team) {

            $lt = $this->em->getRepository('ClubRankingBundle:RankingEntry')->getTeam($ranking, $match_team->getTeam());

            if ($match_team == $match->getWinner()) {
                $lt->setPlayed($lt->getPlayed()-1);
                $lt->setWon($lt->getWon()-1);
                $lt->setPoint($lt->getPoint()-$ranking->getRule()->getPointWon());

            } else {
                $lt->setPlayed($lt->getPlayed()-1);
                $lt->setLost($lt->getLost()-1);

                if ($lt->getPoint() > 0)
                    $lt->setPoint($lt->getPoint()-$ranking->getRule()->getPointLost());

            }

            $this->em->persist($lt);
        }
    }

    public function validateMatch(\Club\RankingBundle\Entity\Ranking $ranking)
    {
        try {
            $this->ranking = $ranking;
            $this->match = $this->club_match->getMatch();

            $this->validateGender($this->match);
            if ($ranking->getInviteOnly()) {
                if (!$ranking->canPlay($user)) {
                    throw new \Exception($this->translator->trans('%user% is not allowed to play in this league.', array(
                        '%user%' => $user->getName()
                    )));
                }
            }

            //$this->validateSets();
            //$this->validateRules();

        } catch (\Exception $e) {
            $this->club_match->setError($e->getMessage());
        }
    }

    private function validateSets(\Club\MatchBundle\Entity\Match $match)
    {
    }

    private function validateGender(\Club\MatchBundle\Entity\Match $match)
    {
        if (!$this->ranking->getGender()) {
            return;

            foreach ($match->getMatchTeams() as $team) {
                foreach ($team->getTeam()->getUsers() as $user) {

                    if ($user->getProfile()->getGender() != $this->ranking->getGender()) {
                        throw new \Exception($this->translator->trans('Only %gender% is allowed to play in this league.', array(
                            '%gender%' => $this->ranking->getGender()
                        )));
                    }
                }
            }
        }
    }

    private function validateRules()
    {
        $qb = $this->em->createQueryBuilder()
            ->select('count(mt.team)')
            ->from('ClubMatchBundle:MatchTeam', 'mt')
            ->leftJoin('mt.match', 'm')
            ->where('m.league = :league')
            ->andWhere('mt.team = ?1 OR mt.team = ?2')
            ->groupBy('mt.match')
            ->having('count(mt.team) = 2')
            ->setParameter('league', $this->match->getLeague()->getId());

        $i = 0;
        foreach ($this->match->getMatchTeams() as $match_team) {
            $i++;
            $qb
                ->setParameter($i, $match_team->getTeam()->getId());
        }

        $matches = $qb
            ->getQuery()
            ->getResult();

        $total = $this->match->getLeague()->getRule()->getSamePlayer();

        if (count($matches) >= $total) {
            throw new \Exception($this->translator->trans('Teams has already played %count% matches against each other.', array(
                '%count%' => count($matches)
            )));

            return false;
        }

        return true;
    }
}
