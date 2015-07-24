<?php

class Tournament_Football
{
    public $name;

    protected $teams = array();

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addTeam(Tournament_Team $team)
    {
        if(array_search(ucwords($team->name), $this->teams))
            throw new Exception("Team already exists");

        $index = count($this->teams) + 1;
        $this->teams[$index] = $team;
    }

    public function getTeam($id)
    {
        if(!isset($this->teams[$id]))
            throw new Exception("Team not found");

        return $this->teams[$id];
    }

    public function getTeams()
    {
        if(!isset($this->teams))
            throw new Exception("This is an empty tournament");

        return $this->teams;
    }

    public function getStandings()
    {

    }
}

class Tournament_Team
{
    public $name;

    private $players = array();

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addPlayer(Tournament_Player $player)
    {
        if(array_search(ucwords($player->name), $this->players))
            throw new Exception("Player already exists");

        $index = count($this->players) + 1;
        $this->players[$index] = $player;
    }

    public function getPlayer($id)
    {
        if(!isset($this->players[$id]))
            throw new Exception("Player not found");

        return $this->players[$id];
    }

    public function getPlayers()
    {
        return $this->players;
    }
}

class Tournament_Player
{
    public $name;

    public $squadNumber;

    public $positions = array();

    public $stats = array();

    public function __construct($info = array())
    {
        $this->name = $info["name"];
        $this->positions = $info["positions"]; // positions as array
    }

    public function addStat(Tournament_Stat $stat)
    {
        $this->stats[$stat::TYPE][] = $stat;
    }

    public function getPositionRating(Tournament_Player_Position $position)
    {
        $position = ucwords($position->name);

        if(!isset($this->positions[$position])) return 0;
        return $this->positions[$position];
    }
}

class Tournament_Player_Position
{
    public $name;

    public $player;

    const MAX_RATING = 10;

    public function __construct($position)
    {
        $this->name = $position;
    }

    public function setPlayer(Tournament_Player $player)
    {
        $this->player = $player;
    }
}

class Tournament_Stat_Factory
{
    public static function get($type)
    {
        $stat_type = "Tournament_Stat_" . ucwords($type);
        if(!class_exists($stat_type))
            throw new Exception("Invalid stat type requested");

        return new $stat_type();
    }
}

abstract class Tournament_Stat
{
    protected $gameId;

    protected $timestamp;

    protected $pitchLocation;
}

class Tournament_Stat_Tackle extends Tournament_Stat
{
    /*
     * Tournament_Team
     */
    public $against;

    /*
     * Boolean
     */
    public $successful;

}

class Tournament_Stat_Goal extends Tournament_Stat
{
    const TYPE = "goal";

    /*
     * Tournament_Player
     */
    public $assistBy;

    /*
     * Tournament_Team
     */
    public $against;

    public function update($info = array())
    {
        $this->assistBy = $info["assistBy"];
        $this->against = $info["against"];
    }
}

class Tournament_Game
{
    public $homeTeam;

    public $visitingTeam;

    const MAX_TEAM_PLAYERS = 11;
}

class Tournament_Team_Formation
{
    private $default = array(
        "goalkeeper" => 1,
        "defender" => 4,
        "midfielder" => 4,
        "forward" => 2
    );

    public function setFormation($type = array())
    {
        if(empty($type)) $type = $this->default;

        if(array_sum($type) > Tournament_Game::MAX_TEAM_PLAYERS)
            throw new Exception("Too many positions for this formation");

        foreach ($type as $position => $count) {
            for($i=1;$i<=$count;$i++){
                 $newPosition = new Tournament_Player_Position($position);
                 $this->positions[] = $newPosition;
            }
        }

        return $this;
    }

    public function generate(Tournament_Team $team, $type = array())
    {
        $munk = new Vendor_Munkres();

        $this->setFormation($type);
		$formation = $munk->compute($this->generateMatrix($team));

        return $formation;
    }

    private function generateMatrix(Tournament_Team $team)
    {
        $players = $team->getPlayers();
        $matrix = array();

        foreach ($players as $i => $player) {
            $pMatrix = array();
            foreach($this->positions as $key=>$position){
                // Flip values to achieve maximal reduction(maximum weighted matching)
                $pMatrix[] = abs($player->getPositionRating($position) - Tournament_Player_Position::MAX_RATING);
            }

            $matrix[] = $pMatrix;
        }

        return $matrix;
    }
}
