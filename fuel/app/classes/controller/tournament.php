<?php
/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Tournament extends Controller_Rest
{
    protected $format = 'json';
    /*
     * Response content
     */
    private $response_content;

    /*
     * tournament object holder
     */
    private $_tournament;

    public function before()
    {
        parent::before();

        $prem = new Tournament_Football("Premiership");

		$modelTeams = new Model_Teams();
		$teams = $modelTeams->get();

		foreach($teams as $key => $data){
			$team = new Tournament_Team($data["name"]);
			if(!isset($data["players"])) continue;

			foreach($data["players"] as $pData){
				$player = new Tournament_Player($pData);
				$team->addPlayer($player);
			}

			$prem->addTeam($team);
		}

        $this->_tournament = $prem;
    }

    public function get_tournament_teams()
    {
        try
        {
            $teams = array();

            foreach($this->_tournament->getTeams() as $key => $team)
            {
                $teams[$key] = array(
                    "id" => $key,
                    "name" => $team->name,
                    "links" => array(
                        array(
                            "rel" => "players",
                            "url" => "/tournament/team/" . $key . "/players"
                        )
                    )
                );
            }

            $this->response_content = $teams;
        } catch(Exception $e) {
            $this->response_content = "No teams available";
            $this->response_status = 404;
        }
    }

    public function get_tournament_team()
    {
        try
        {
            $team_id = $this->get_numeric_param("team_id");
            $this->response_content = $this->_tournament->getTeam($team_id);
        } catch(Exception $e) {
            $this->response_status = 500;
            $this->response_content = $e->getMessage();
        }
    }

    public function get_team_players()
    {
        try
        {
            $team_id = $this->get_numeric_param("team_id");
            $this->response_content = $this->_tournament
                ->getTeam($team_id)
                ->getPlayers();
        } catch(Exception $e) {
            $this->response_status = 500;
            $this->response_content = $e->getMessage();
        }
    }

    public function get_team_player()
    {
        try{
            $team_id = $this->get_numeric_param("team_id");
            $player_id = $this->get_numeric_param("player_id");
            $this->response_content = $this->_tournament
                ->getTeam($team_id)
                ->getPlayer($player_id);
        } catch(Exception $e) {
            $this->response_status = 500;
            $this->response_content = $e->getMessage();
        }
    }

    public function get_player_stats()
    {
        try{
            $team_id = $this->get_numeric_param("team_id");
            $player_id = $this->get_numeric_param("player_id");
            
            $this->dummy_stat($player_id, $team_id);
            $this->dummy_stat($player_id, $team_id);

            $player = $this->_tournament
                ->getTeam($team_id)
                ->getPlayer($player_id);

            $this->response_content = array(
                "name" => $player->name,
                "stats" => $player->stats
            );
        } catch(Exception $e) {
            $this->response_status = 500;
            $this->response_content = $e->getMessage();
        }
    }

    private function dummy_stat($player_id, $team_id)
    {
        $goalStat = Tournament_Stat_Factory::get("goal");
		$goalStat->update(
			array(
				"assistBy" => "Ozil",
				"against" => "Tottenham"
			)
		);

		$this->_tournament->getTeam($team_id)
			->getPlayer($player_id)
			->addStat($goalStat);
    }

    private function get_numeric_param($name)
    {
        $param = $this->param($name);
        if(!$param || !is_numeric($param))
            throw new Exception("Bad id");

        return $param;
    }

    public function after($response = array())
    {
        return $this->response(array(
                "content" => $this->response_content
            ),
            $this->response_status
        );
    }
}
