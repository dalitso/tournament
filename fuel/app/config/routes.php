<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),

	/*
     *  API routing
     */
    'tournament/teams' => array(
        array(
            'GET',
            new Route('tournament/tournament_teams')
        )
    ),

	'tournament/team/:team_id/players/:player_id/stats' => array(
		array(
			'GET',
			new Route('tournament/player_stats')
		)
	),

	'tournament/team/:team_id/players/:player_id' => array(
		array(
			'GET',
			new Route('tournament/team_player')
		)
	),

	'tournament/team/:team_id/players' => array(
		array(
			'GET',
			new Route('tournament/team_players')
		)
	),

	'tournament/team/:team_id' => array(
		array(
			'GET',
			new Route('tournament/tournament_team')
		)
	),

);
