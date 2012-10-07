<?php

namespace Club\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\MatchBundle\Entity\Match
 *
 * @ORM\Table(name="club_match_match")
 * @ORM\Entity(repositoryClass="Club\MatchBundle\Entity\MatchRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Match
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $display_result
     *
     * @ORM\Column(type="string")
     */
    private $display_result;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="Club\MatchBundle\Entity\MatchTeam")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    protected $winner;

    /**
     * @ORM\ManyToOne(targetEntity="Club\MatchBundle\Entity\League")
     */
    protected $league;

    /**
     * @ORM\ManyToOne(targetEntity="Club\TournamentBundle\Entity\Tournament")
     */
    protected $tournament;

    /**
     * @var Club\MatchBundle\Entity\MatchTeam
     *
     * @ORM\OneToMany(targetEntity="MatchTeam", mappedBy="match", cascade={"persist"})
     */
    protected $match_teams;

    /**
     * @var Club\MatchBundle\Entity\MatchComment
     *
     * @ORM\OneToMany(targetEntity="MatchComment", mappedBy="match")
     */
    protected $match_comments;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    protected $user;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set league
     *
     * @param Club\MatchBundle\Entity\League $league
     */
    public function setLeague(\Club\MatchBundle\Entity\League $league)
    {
        $this->league = $league;
    }

    /**
     * Get league
     *
     * @return Club\MatchBundle\Entity\League
     */
    public function getLeague()
    {
        return $this->league;
    }
    public function __construct()
    {
        $this->match_teams = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add match_teams
     *
     * @param Club\MatchBundle\Entity\MatchTeam $matchTeams
     */
    public function addMatchTeam(\Club\MatchBundle\Entity\MatchTeam $matchTeams)
    {
        $this->match_teams[] = $matchTeams;
    }

    /**
     * Get match_teams
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMatchTeams()
    {
        return $this->match_teams;
    }

    /**
     * Set display_result
     *
     * @param string $displayResult
     */
    public function setDisplayResult($displayResult)
    {
        $this->display_result = $displayResult;
    }

    /**
     * Get display_result
     *
     * @return string
     */
    public function getDisplayResult()
    {
        return $this->display_result;
    }

    public function getTeamOne()
    {
      $teams = $this->getMatchTeams();

      return ($teams[0]->getId() > $teams[1]->getId()) ? $teams[1] : $teams[0];
    }

    public function getTeamTwo()
    {
      $teams = $this->getMatchTeams();

      return ($teams[0]->getId() > $teams[1]->getId()) ? $teams[0] : $teams[1];
    }

    /**
     * Set winner
     *
     * @param Club\MatchBundle\Entity\MatchTeam $winner
     */
    public function setWinner(\Club\MatchBundle\Entity\MatchTeam $winner)
    {
        $this->winner = $winner;
    }

    /**
     * Get winner
     *
     * @return Club\MatchBundle\Entity\MatchTeam
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Add match_comments
     *
     * @param Club\MatchBundle\Entity\MatchComment $matchComments
     */
    public function addMatchComment(\Club\MatchBundle\Entity\MatchComment $matchComments)
    {
        $this->match_comments[] = $matchComments;
    }

    /**
     * Get match_comments
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMatchComments()
    {
        return $this->match_comments;
    }

    public function isOwner(\Club\UserBundle\Entity\User $user)
    {
      foreach ($this->getMatchTeams() as $mt) {
        foreach ($mt->getTeam()->getUsers() as $u) {
          if ($user == $u) {
            return true;
          }
        }
      }

      return false;
    }

    /**
     * Set tournament
     *
     * @param Club\TournamentBundle\Entity\Tournament $tournament
     */
    public function setTournament(\Club\TournamentBundle\Entity\Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * Get tournament
     *
     * @return Club\TournamentBundle\Entity\Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Remove match_teams
     *
     * @param Club\MatchBundle\Entity\MatchTeam $matchTeams
     */
    public function removeMatchTeam(\Club\MatchBundle\Entity\MatchTeam $matchTeams)
    {
        $this->match_teams->removeElement($matchTeams);
    }

    /**
     * Remove match_comments
     *
     * @param Club\MatchBundle\Entity\MatchComment $matchComments
     */
    public function removeMatchComment(\Club\MatchBundle\Entity\MatchComment $matchComments)
    {
        $this->match_comments->removeElement($matchComments);
    }

    /**
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     * @return Match
     */
    public function setUser(\Club\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Club\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}