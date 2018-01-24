<?php
namespace Manager;
use Model\QueenBee;
use Model\DroneBee;
use Model\WorkerBee;
/**
 * Class Game
 *
 * @author AB
 */
class Game 
{
    /**
     * @var array
     */
    private $bees = [];
    /**
     * Current non-achieved round
     * @var int
     */
    private $round = 1;
    /**
     * @var array
     */
    private $hitLogs = [];
    /**
     * max number of QueenBee objects
     * @ar int
     */
    private $maxQueens;
    /**
     * @var int
     */
    private $maxWorkers;
    /**
     * @var int
     */
    private $maxDrones;
    /**
     * @param int $maxWorkers
     * @param int $maxDrones
     * @param int $maxQueens
     */
    public function __construct($maxWorkers = 5, $maxDrones = 8, $maxQueens = 1)
    {
        /* Configurable swarm size */
        if (!is_null($maxWorkers)) $this->maxWorkers = $maxWorkers;
        if (!is_null($maxDrones))  $this->maxDrones  = $maxDrones;
        if (!is_null($maxQueens))  $this->maxQueens  = $maxQueens;
        for ($i = 0; $i < $this->maxQueens;$i++) {
            $this->bees[] = new QueenBee();
        }
        for ($i = 0; $i < $this->maxWorkers;$i++) {
            $this->bees[] = new WorkerBee();
        }
        for ($i = 0; $i < $this->maxDrones;$i++) {
            $this->bees[] = new DroneBee();
        }
    }
    /**
     * @param int $position - if null, random bee hitted
     * @return string
     */
    public function play($position = null)
    {
        $story = '';
        if (is_null($position)) {
            $position = rand(0, $this->getCountBees()-1);
        }
        if (!isset($this->bees[$position])) {
            throw new Exception("Bee position $position undefined");
        }
        /** @var \Model\Bee $bee */
        $bee = $this->bees[$position];
        if ($bee->hit()) {
            $story.= $bee->getClass(1).' #'.$position.' hitted ! '
                . $bee::$DPH.' damage points taken. Current HP : '
                . $bee->getCurrentHP().' / '
                . $bee::$MAX_HP
                . '.'.PHP_EOL;
            if ($bee->isKilled()) {
				 
              
				   if ($bee->getClass(1)=='QueenBee'){
                    $this->bees = [];
                    $story.= 'Queen killed ! All bees are dying ! '.PHP_EOL;
                   
                } else {
                    unset($this->bees[$position]);
                    $this->bees = array_values(array_filter($this->bees));
                    $story.= $bee->getClass(1).' #'.$position.' killed ! Bees remaining : '
                        . $this->getCountBees()
                        . '.'.PHP_EOL;
                }
            }
        }
        $this->round++;
        $this->hitLogs[] = $story;
        return $story;
    }
    /**
     * @return bool
     */
    public function isDead()
    {
        return !(bool)$this->getCountBees();
    }
    /**
     * @return int
     */
    public function getRound()
    {
        return $this->round;
    }
    /**
     * @return array
     */
    public function getHitLogs()
    {
        return $this->hitLogs;
    }
    /**
     * @return array
     */
    public function getBees()
    {
        return $this->bees;
    }
    /**
     * @return int
     */
    public function getCountBees()
    {
        return count($this->bees);
    }
}