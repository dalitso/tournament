<?php

class Model_Teams
{
    private $teams = NULL;

    public function get()
    {
        $teams = array(
			"1" => array(
                "name" => "Arsenal",
				"players" => array(
					"1" => array(
						"name" => "Thierry Henry",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 0,
                            "Midfielder" => 3,
							"Forward" => 10,
						)
					),
					"2" => array(
						"name" => "Alexis Sanchez",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 0,
                            "Midfielder" => 4,
							"Forward" => 10,
						)
					),
					"3" => array(
						"name" => "Petr Cech",
						"positions" => array(
                            "Goalkeeper" => 10,
                            "Defender" => 0,
                            "Midfielder" => 0,
							"Forward" => 0,
						)
					),
                    "4" => array(
						"name" => "Big F German",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 10,
                            "Midfielder" => 0,
							"Forward" => 0,
						)
					),
                    "5" => array(
						"name" => "Laurent Koscielny",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 10,
                            "Midfielder" => 0,
							"Forward" => 0,
						)
					)
                    ,
                    "6" => array(
						"name" => "Jack Wilshire",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 0,
                            "Midfielder" => 10,
							"Forward" => 0,
						)
					)
				)
			),
			"2" => array(
                "name" => "Chelsea",
				"players" => array(
                    "1" => array(
						"name" => "Eden Hazard",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 0,
                            "Midfielder" => 9,
							"Forward" => 7,
						)
					),
                    "2" => array(
						"name" => "Oscar",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 0,
                            "Midfielder" => 4,
							"Forward" => 10,
						)
					)
				)
			),
			"3" => array(
                "name" => "Manchester United",
				"players" => array(
                    "1" => array(
						"name" => "Wayne Rooney",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 0,
                            "Midfielder" => 4,
							"Forward" => 10,
						)
					),
                    "2" => array(
						"name" => "Juan Mata",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 0,
                            "Midfielder" => 8,
							"Forward" => 4,
						)
					)
				)
			),
			"4" => array(
                "name" => "Liverpool",
				"players" => array(
                    "1" => array(
						"name" => "Daniel Sturridge",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 0,
                            "Midfielder" => 4,
							"Forward" => 10,
						)
					),
                    "2" => array(
						"name" => "James Milner",
						"positions" => array(
                            "Goalkeeper" => 0,
                            "Defender" => 0,
                            "Midfielder" => 8,
							"Forward" => 4,
						)
					)
				)
			)
		);
        $this->teams = $teams;
        return $teams;
    }

}
