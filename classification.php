<?php
	$classification_page = file_get_contents('http://globoesporte.globo.com/servico/esportes_campeonato/responsivo/widget-uuid/09021843-e53d-4020-80f7-302a15756585/fases/fase-unica-brasileiro-2015/classificacao.html');
	$classification_page = explode('<table class="tabela-times">', $classification_page);
	$header = $classification_page[0];
	$content = explode('<div class="tabela-scroll overthrow">', $classification_page[1]);
	$list_teams = $content[0];
	$list_teams = str_replace('Classificação', '', $list_teams);
	$shield = array(
					'FLU' => 'http://s.glbimg.com/es/sde/f/equipes/2015/07/21/fluminense_60x60.png',
					'CAP' => 'http://s.glbimg.com/es/sde/f/equipes/2015/06/24/atletico-pr_2015_65.png',
					'INT' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/internacional_60x60.png',
					'JEC' => 'http://s.glbimg.com/es/sde/f/equipes/2015/07/20/Joinville65.png',
					'FIG' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/figueirense_60x60.png',
					'SAN' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/santos_60x60.png',
					'PAL' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/palmeiras_60x60.png',
					'SPO' => 'http://s.glbimg.com/es/sde/f/equipes/2015/07/21/sport65.png',
					'COR' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/corinthians_60x60.png',
					'FLA' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/flamengo_60x60.png',
					'VAS' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/vasco_60x60.png',
					'GRE' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/gremio_60x60.png',
					'CFC' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/coritiba_60x60.png',
					'SAO' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/sao_paulo_60x60.png',
					'CHA' => 'http://s.glbimg.com/es/sde/f/equipes/2015/08/03/Escudo-Chape-165.png',
					'AVA' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/avai_60x60_.png',
					'GOI' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/goias_60x60.png',
					'CRU' => 'http://s.glbimg.com/es/sde/f/equipes/2015/04/29/cruzeiro_65.png',
					'CAM' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/atletico_mg_60x60.png',
					'PON' => 'http://s.glbimg.com/es/sde/f/equipes/2014/04/14/ponte_preta_60x60.png'
					);
	$list_teams = explode('<a class="tabela-times-time-link"', $list_teams);
	for ($i=1; $i < count($list_teams); $i++) {
		$team = str_replace('</a>', '', $list_teams[$i]);
		$team = explode('" title="', $team);
		$team = $team[1];
		$team = explode('" alt="', $team);
		$team = $team[1];
		$team = explode('" itemprop="url">', $team);
		$name_team = strip_tags($team[0]);
		$shortening = str_replace($name_team, '', strip_tags($team[1]));
		// echo $name_team." - ".strlen($name_team).'<br>';
		$shortening = substr($shortening, 0, 3);
		$teams[] = array('team' => $name_team, 'shortening' => $shortening, 'shield' => $shield[$shortening]);
	}
	$content = explode('<footer class="legenda-classificacao">', $content[1]);
	$points = $content[0];
	$points = explode('<td class="tabela-pontos-ponto">', $points);
	for ($i=1; $i < count($points); $i++) {
		$data_points = $points[$i];
		$data_points = str_replace('</td><td>', '|', $data_points);
		$data_points = strip_tags($data_points);
		$data_points = explode('|', $data_points);
		$array_points = array('p' => $data_points[0],
							  'j' => $data_points[1],
							  'v' => $data_points[2],
							  'e' => $data_points[3],
							  'd' => $data_points[4],
							  'gp' => $data_points[5],
							  'gc' => $data_points[6],
							  'sg' => $data_points[7],
							  'percent' => $data_points[8]);
		$teams[$i - 1]['points'] =$array_points;
	}
echo json_encode($teams);

?>