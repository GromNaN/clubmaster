<?php

namespace Club\RankingBundle\Listener;

class Ranking
{
    private $em;
    private $club_ranking;

    public function __construct($em, $club_ranking)
    {
        $this->em = $em;
        $this->club_ranking = $club_ranking;
    }

    public function onMatchDelete(\Club\MatchBundle\Event\FilterMatchEvent $event)
    {
        $this->club_ranking->revokePoint($event->getMatch());
    }

    public function onMatchNew(\Club\MatchBundle\Event\FilterMatchEvent $event)
    {
        $this->processMatch($event->getMatch());
    }

    public function onMatchTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
    {
        return;
        $matches = $this->em->getRepository('ClubMatchBundle:Match')->getUnprocessed();

        foreach ($matches as $match) {
            $this->processMatch($match);
        }
    }

    private function processMatch(\Club\MatchBundle\Entity\Match $match)
    {
        $this->club_ranking->addPoint($match);
    }
}
