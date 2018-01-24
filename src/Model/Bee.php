<?php


namespace Model;
/**
 * base Bee
 *
 * @author AB
 */
abstract class Bee
{
    /**
     * Max Hit Points
     * @var int
     */
    public static $MAX_HP = 75;
    /**
     * Damage per Hit taken
     * @var int
     */
    public static $DPH = 10;
    /**
     * Current Hit points
     * @var int
     */
    protected $currentHP;
    public function __construct()
    {
        $this->currentHP = static::$MAX_HP;
    }
    public function getCurrentHP()
    {
        return $this->currentHP;
    }
    /**
     * return child class
     *
     * @param bool $short
     * @return string
     */
    public function getClass($short = false)
    {
        if ($short) {
            return end(explode('\\', get_class($this)));
        } else {
            return get_class($this);
        }
    }
    /**
     *
     * @return bool if hit point lowered
     */
    public function hit()
    {
        if (!$this->isKilled()) {
            $this->currentHP = max(0, $this->currentHP - static::$DPH);
            return true;
        } else {
            return false;
        }
    }
    public function isKilled()
    {
        if (!$this->currentHP) {
            return true;
        } else {
            return false;
        }
    }
}