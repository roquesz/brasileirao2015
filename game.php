<?php
	$game = $_GET['game'];
	$game_page = file_get_contents('http://globoesporte.globo.com/servico/esportes_campeonato/responsivo/widget-uuid/09021843-e53d-4020-80f7-302a15756585/fases/fase-unica-brasileiro-2015/rodada/'.$game.'/jogos.html');
	$game_data = explode('</li>', $game_page);
	for ($i=0; $i < count($game_data) - 1; $i++) {
		$info_game = $game_data[$i];
		$info_game = $content = explode('<meta itemprop="name" content=', $info_game);
		$info_game = $info_game[1];
		$info_game = explode('<div class="placar-jogo-informacoes">', $info_game);
		$teams = explode('>', strip_tags($info_game[0]));
		$teams = str_replace('"', '', $teams[0]);
		$date_game = $info_game[1];
		$date_game = explode('<div class="placar-jogo-informacoes">', $date_game);
		$date_game = $date_game[0];
		$date_game = str_replace(array('<span class="placar-jogo-informacoes-local">', '</span>'), ' - ', $date_game);
		$date_game = strip_tags($date_game);
		$shield1 = explode('src="', $content[2]);
		$shield1 = explode('"', $shield1[1]);
		$shield1 = $shield1[0];
		$shield2 = explode('src="', $content[3]);
		$shield2 = explode('"', $shield2[1]);
		$shield2 = $shield2[0];
		$games[] = array('teams' => $teams, 'date' => $date_game, 'shields' => array($shield1, $shield2));
	}
	echo json_encode($games);

?>