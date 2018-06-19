<?php

class SocRodadasController extends AppController {

    public $components = array('App');

    private $rodada;

    public function beforeRender()
    {
        parent::beforeRender();
        $this->SocRodada->recursive = -1;

        $targetPath = 'files/Soccer_Expert_Rodadas_Imagem_Modal';
        if(!is_dir($targetPath)) {
            mkdir($targetPath, 0777);
        }
    }

    private function salvarPremiacao($grupo, $dado, $porcentagem)
    {
        $ok = true;
        $this->StartTransaction();
        $owner = $this->User->read(null, $dado['SocAposta']['owner_id']);

        $saldo = $this->Balance->find('first', [
            'conditions' => [
                'Balance.owner_id' => $owner['User']['id']
            ]
        ]);

        $historico['HistoricBalance']['balance_id'] = $saldo['Balance']['id'];
        $historico['HistoricBalance']['owner_id'] = $owner['User']['id'];
        $historico['HistoricBalance']['from'] = $saldo['Balance']['value'];


        $saldo['Balance']['value'] += $grupo['SocRodadasGrupo']['arrecadado'] * $porcentagem / 100;

        $ok = $this->Balance->save($saldo);
        $this->HistoricBalance->create();
        $historico['HistoricBalance']['soccer_expert_bet_id'] = $dado['SocAposta']['id'];
        $historico['HistoricBalance']['amount'] = $grupo['SocRodadasGrupo']['arrecadado'] * $porcentagem / 100;
        $historico['HistoricBalance']['to'] = $saldo['Balance']['value'];
        $historico['HistoricBalance']['type'] = 1;
        $historico['HistoricBalance']['description'] = 'award';

        $ok = $this->HistoricBalance->save($historico);

        $this->validaTransacao($ok);


        //$historico_soccer['HistoricBalanceSoccer']['historic_balance_id'] = $this->HistoricBalance->id;
        //$historico_soccer['HistoricBalanceSoccer']['soc_aposta_id'] = $dado['SocAposta']['id'];
        //$historico_soccer['HistoricBalanceSoccer']['soc_rodada_grupo_id'] = $grupo['SocRodadasGrupo']['id'];
        //$historico_soccer['HistoricBalanceSoccer']['value'] = $grupo['SocRodadasGrupo']['arrecadado'] * $porcentagem / 100;
        //$this->HistoricBalanceSoccer->create();
        //$this->HistoricBalanceSoccer->save($historico_soccer);
    }

    private function saveQuintos() {

    }

    public function gerarPremiacao($id)
    {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';
        $this->SocRodada->recursive = -1;


        $this->loadModel('SocAposta');
        $this->loadModel('SocApostasJogo');
        $this->loadModel('SocRodadasGrupo');
        $this->loadModel('Balance');
        $this->loadModel('HistoricBalance');
        $this->loadModel('HistoricBalanceSoccer');
        $this->loadModel('HistoricBalanceDevolution');
        $this->loadModel('User');
        $this->SocRodadasGrupo->recursive = -1;
        $this->SocAposta->recursive = -1;
        $this->SocApostasJogo->recursive = -1;
        $this->Balance->recursive = -1;
        $this->HistoricBalance->recursive = -1;
        $this->User->recursive = -1;
        $this->HistoricBalanceSoccer->recursive = -1;
        $this->HistoricBalanceDevolution->recursive = -1;

        $this->render = false;

        $rodada = $this->SocRodada->read(null, $id);

        $grupos = null;
        $grupo_sem_qtd_minima = null;

        if($rodada['SocRodada']['minimo'] != null) {
            $grupos = $this->SocRodadasGrupo->find('all', [
                'conditions' => [
                    'SocRodadasGrupo.soc_rodada_id' => $id,
                    'SocRodadasGrupo.count >=' => $rodada['SocRodada']['minimo']
                ]
            ]);
        } else {
            $grupos = $this->SocRodadasGrupo->find('all', [
                'conditions' => [
                    'SocRodadasGrupo.soc_rodada_id' => $id
                ]
            ]);
        }

        $grupo_sem_qtd_minima = $this->SocRodadasGrupo->find('all', [
            'conditions' => [
                'SocRodadasGrupo.soc_rodada_id' => $id,
                'SocRodadasGrupo.count <' => $rodada['SocRodada']['minimo']
            ]
        ]);


        foreach ($grupos as $key => $grupo) {

            $total_prc = 77;

            $prc = [
                0 => [
                    'prc' => 50,
                    'status' => 1,
                ],
                1 => [
                    'prc' => 10,
                    'status' => 1,
                ],
                2 => [
                    'prc' => 5,
                    'status' => 1,
                ],
                3 => [
                    'prc' => 1,
                    'status' => 1,
                ],
                4 => [
                    'prc' => 1,
                    'status' => 1,
                ],
                5 => [
                    'prc' => 1,
                    'status' => 1,
                ],
                6 => [
                    'prc' => 1,
                    'status' => 1,
                ],
                7 => [
                    'prc' => 1,
                    'status' => 1,
                ],
                8 => [
                    'prc' => 1,
                    'status' => 1,
                ],
                9 => [
                    'prc' => 1,
                    'status' => 1,
                ],
                10 => [
                    'prc' => 0.5,
                    'status' => 1,
                ],
                11 => [
                    'prc' => 0.5,
                    'status' => 1,
                ],
                12 => [
                    'prc' => 0.5,
                    'status' => 1,
                ],
                13 => [
                    'prc' => 0.5,
                    'status' => 1,
                ],
                14 => [
                    'prc' => 0.5,
                    'status' => 1,
                ],
                15 => [
                    'prc' => 0.5,
                    'status' => 1,
                ],
                16 => [
                    'prc' => 0.5,
                    'status' => 1,
                ],
                17 => [
                    'prc' => 0.5,
                    'status' => 1,
                ],
                18 => [
                    'prc' => 0.5,
                    'status' => 1,
                ],
                19 => [
                    'prc' => 0.5,
                    'status' => 1,
                ],
            ];

            /*if($grupo['SocRodadasGrupo']['count'] < $rodada['SocRodada']['minimo']) {
                continue;
            }*/

            $primeiros = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 1,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);

            $prc_maxima = 77;
            //Verifico se todos ficaram em primeiro
            //Caso sim, a porcentagem máxima é de 77%
            if(count($primeiros) >= 20) {
                foreach ($primeiros as $k => $primeiro) {
                    $this->salvarPremiacao($grupo, $primeiro, count($primeiros) / $prc_maxima);
                    $dado['SocAposta']['quantia'] = ($grupo['SocRodadasGrupo']['arrecadado'] * (count($primeiros) / $prc_maxima)) / 100;
                    $dado['SocAposta']['vencedor'] = 1;
                    $this->SocAposta->save($dado);
                }
                //Passo pro próximo grupo porque já premiei os usuários
                continue;
            } else if(count($primeiros) == 0) {
                //Caso não encontrei ningúem em primeiro nesse grupo, passo pro próximo grupo
                continue;
            }

            //Porcentagem dos primeiros colocados
            $primeiro_pct = 0;

            //Posicão do array
            //Pega a premiação na posição disponível no vetor
            $pos_disponivel = 0;

            $end = count($primeiros);
            //Percorre todos os primeiros colocados
            for ($i = 0; $i < $end; $i++) {
                //Caso não encontre mais nenhuma posição no vetor é porque todos são primeiros colocados
                if(!isset($prc[$i])) {
                    //Caso sim, a porcentagem máxima é de 77%
                    $primeiro_pct = 77;
                    break;
                }
                $primeiro_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                //Próxima posição de premiação disponível
                $pos_disponivel = $i + 1;
            }

            //Percorrendo todos os primeiros colocados
            foreach ($primeiros as $k => $primeiro) {
                //Salvo a premiação para o usuário com base na porcentagem encontrada
                $this->salvarPremiacao($grupo, $primeiro, $primeiro_pct / count($primeiros));
                $primeiro['SocAposta']['quantia'] = ($grupo['SocRodadasGrupo']['arrecadado'] * ($primeiro_pct / count($primeiros))) / 100;
                $primeiro['SocAposta']['vencedor'] = 1;
                $this->SocAposta->save($primeiro);
            }

            //Caso sim, a porcentagem máxima é de 77%, passo pro próximo grupo da cartela
            if($primeiro_pct == 77) {
                continue;
            }

            //Pegando todos em segundo lugar
            $segundos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 2,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);


            $segundos_pct = 0;
            $prc_maxima = 28;

            $end += count($segundos);
            //Iniciando $i com a última posição encontrada no vetor de premiações e pego todas as posições com base no total
            //De usuário na segunda posição
            for ($i = $pos_disponivel; $i < count($primeiros) + count($segundos); $i++) {
                //Caso já tenha ultrapassado o limite de premiações
                //O máximo de porcentagem do segundo é 28
                //Sai do loop
                if(!isset($prc[$i])) {
                    $segundos_pct = 28;
                    break;
                }
                //Porcentagem
                $segundos_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($segundos as $k => $segundo) {
                if($segundos_pct > 0) {
                    $this->salvarPremiacao($grupo, $segundo, $segundos_pct / count($segundos));
                    $segundo['SocAposta']['quantia'] = ($grupo['SocRodadasGrupo']['arrecadado'] * ($segundos_pct / count($segundos))) / 100;
                    $segundo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($segundo);
                }
            }

            //Caso sim, a porcentagem máxima é de 28%, passo pro próximo grupo da cartela
            if($segundos_pct == 28) {
                continue;
            }

            //Terceiro colocado
            $terceiros = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 3,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $terceiros_pct = 0;
            $prc_maxima = 18;

            $end += count($terceiros);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $terceiros_pct = 18;
                    break;
                }
                $terceiros_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($terceiros as $k => $terceiro) {
                if($terceiros_pct > 0) {
                    $this->salvarPremiacao($grupo, $terceiro, $terceiros_pct / count($terceiros));
                    $terceiro['SocAposta']['quantia'] = ($grupo['SocRodadasGrupo']['arrecadado'] * ($terceiros_pct / count($terceiros))) / 100;
                    $terceiro['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($terceiro);
                }
            }
            if($terceiros_pct == 18) {
                continue;
            }

            //Quarto colocado
            $quartos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 4,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $quartos_pct = 0;
            $prc_maxima = 12;

            $end = count($primeiros) + count($segundos) + count($terceiros) + count($quartos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $quartos_pct = 12;
                    break;
                }
                $quartos_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($quartos as $k => $quarto) {
                if($quartos_pct > 0) {
                    $this->salvarPremiacao($grupo, $quarto, $quartos_pct / count($quartos));
                    $quarto['SocAposta']['quantia'] = ($grupo['SocRodadasGrupo']['arrecadado'] * ($quartos_pct / count($quartos))) / 100;
                    $quarto['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($quarto);
                }
            }

            if($quartos_pct == 12) {
                continue;
            }

            //Quinto colocado
            $quintos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 5,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $quintos_pct = 0;
            $prc_maxima = 11;

            $end += count($quintos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $quintos_pct = 11;
                    break;
                }
                $quintos_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($quintos as $k => $quinto) {
                if($quintos_pct > 0) {
                    $this->salvarPremiacao($grupo, $quinto, $quintos_pct / count($quintos));
                    $quinto['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($quintos_pct / count($quintos)) / 100;
                    $quinto['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($quinto);
                }
            }

            if($quintos_pct == 11) {
                continue;
            }

            //Sexto colocado
            $sextos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 6,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $sextos_pct = 0;
            $prc_maxima = 10;

            $end += count($sextos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $sextos_pct = 10;
                    break;
                }
                $sextos_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($sextos as $k => $sexto) {
                if($sextos_pct > 0) {
                    $this->salvarPremiacao($grupo, $sexto, $sextos_pct / count($sextos));
                    $sexto['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($sextos_pct / count($sextos)) / 100;
                    $sexto['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($sexto);
                }
            }

            if($sextos_pct == 10) {
                continue;
            }

            //Sétimo colocado
            $setimos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 7,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $setimo_pct = 0;
            $prc_maxima = 9;

            $end += count($setimos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $setimo_pct = 9;
                    break;
                }
                $setimo_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($setimos as $k => $setimo) {
                if($setimo_pct > 0) {
                    $this->salvarPremiacao($grupo, $setimo, $setimo_pct / count($setimos));
                    $setimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($setimo_pct / count($setimos)) / 100;
                    $setimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($setimo);
                }
            }

            if($setimo_pct == 9) {
                continue;
            }

            //Oitavo colocado
            $oitavos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 8,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $oitavo_pct = 0;
            $prc_maxima = 8;

            $end += count($oitavos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $oitavo_pct = 8;
                    break;
                }
                $oitavo_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($oitavos as $k => $oitavo) {
                if($oitavo_pct > 0) {
                    $this->salvarPremiacao($grupo, $oitavo, $oitavo_pct / count($oitavos));
                    $oitavo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($oitavo_pct / count($oitavos)) / 100;
                    $oitavo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($oitavo);
                }
            }

            if($oitavo_pct == 8) {
                continue;
            }

            //Novo colocado
            $nonos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 9,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $nono_pct = 0;
            $prc_maxima = 7;

            $end += count($nonos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $nono_pct = 7;
                    break;
                }
                $nono_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($nonos as $k => $nono) {
                if($nono_pct > 0) {
                    $this->salvarPremiacao($grupo, $nono, $nono_pct / count($nonos));
                    $nono['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($nono_pct / count($nonos)) / 100;
                    $nono['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($nono);
                }
            }

            if($nono_pct == 7) {
                continue;
            }


            //Décimo colocado
            $decimos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 10,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_pct = 0;
            $prc_maxima = 5;

            $end += count($decimos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_pct = 5;
                    break;
                }
                $decimo_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($decimos as $k => $decimo) {
                if($decimo_pct > 0) {
                    $this->salvarPremiacao($grupo, $decimo, $decimo_pct / count($decimos));
                    $decimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_pct / count($decimos)) / 100;
                    $decimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($decimo);
                }
            }

            if($decimo_pct == 5) {
                continue;
            }

            //Décimo primeiro colocado
            $decimo_primeiros = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 11,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_primeiro_pct = 0;
            $prc_maxima = 5;

            $end += count($decimo_primeiros);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_primeiro_pct = 5;
                    break;
                }
                $decimo_primeiro_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($decimo_primeiros as $k => $decimo) {
                if($decimo_primeiro_pct > 0) {
                    $this->salvarPremiacao($grupo, $decimo, $decimo_primeiro_pct / count($decimo_primeiros));
                    $decimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_primeiro_pct / count($decimo_primeiros)) / 100;
                    $decimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($decimo);
                }
            }

            if($decimo_primeiro_pct == 5) {
                continue;
            }


            //Décimo segundo colocado
            $decimo_segundos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 12,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_segundo_pct = 0;
            $prc_maxima = 4.5;

            $end += count($decimo_segundos);

            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_segundo_pct = 4.5;
                    break;
                }
                $decimo_segundo_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($decimo_segundos as $k => $decimo) {
                if($decimo_segundo_pct > 0) {
                    $this->salvarPremiacao($grupo, $decimo, $decimo_segundo_pct / count($decimo_segundos));
                    $decimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_segundo_pct / count($decimo_segundos)) / 100;
                    $decimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($decimo);
                }
            }

            if($decimo_segundo_pct == 4.5) {
                continue;
            }

            //Décimo terceiro colocado
            $decimo_terceiros = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 13,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_terceiro_pct = 0;
            $prc_maxima = 4;

            $end += count($decimo_terceiros);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_terceiro_pct = 4;
                    break;
                }
                $decimo_terceiro_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($decimo_terceiros as $k => $decimo) {
                if($decimo_terceiro_pct > 0) {
                    $this->salvarPremiacao($grupo, $decimo, $decimo_terceiro_pct / count($decimo_terceiros));
                    $decimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_terceiro_pct / count($decimo_terceiros)) / 100;
                    $decimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($decimo);
                }
            }

            if($decimo_terceiro_pct == 4) {
                continue;
            }

            //Décimo quarto colocado
            $decimo_quartos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 14,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_quarto_pct = 0;
            $prc_maxima = 3.5;

            $end += count($decimo_quartos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_quarto_pct = 3.5;
                    break;
                }
                $decimo_quarto_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($decimo_quartos as $k => $decimo) {
                if($decimo_quarto_pct > 0) {
                    $this->salvarPremiacao($grupo, $decimo, $decimo_quarto_pct / count($decimo_quartos));
                    $decimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_quarto_pct / count($decimo_quartos)) / 100;
                    $decimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($decimo);
                }
            }

            if($decimo_quarto_pct == 3.5) {
                continue;
            }


            //Décimo quinto colocado
            $decimo_quintos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 15,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_quinto_pct = 0;
            $prc_maxima = 3;

            $end += count($decimo_quintos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_quinto_pct = 3;
                    break;
                }
                $decimo_quinto_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($decimo_quintos as $k => $decimo) {
                if($decimo_quinto_pct > 0) {
                    $this->salvarPremiacao($grupo, $decimo, $decimo_quinto_pct / count($decimo_quintos));
                    $decimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_quinto_pct / count($decimo_quintos)) / 100;
                    $decimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($decimo);
                }
            }

            if($decimo_quinto_pct == 3) {
                continue;
            }

            //Décimo sexto colocado
            $decimo_sextos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 16,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_sexto_pct = 0;
            $prc_maxima = 2.5;

            $end += count($decimo_sextos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_sexto_pct = 2.5;
                    break;
                }
                $decimo_sexto_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($decimo_sextos as $k => $decimo) {
                if($decimo_sexto_pct > 0) {
                    $this->salvarPremiacao($grupo, $decimo, $decimo_sexto_pct / count($decimo_sextos));
                    $decimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_sexto_pct / count($decimo_sextos)) / 100;
                    $decimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($decimo);
                }
            }

            if($decimo_sexto_pct == 2.5) {
                continue;
            }


            //Décimo setimo colocado
            $decimo_setimos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 17,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_setimo_pct = 0;
            $prc_maxima = 2;

            $end += count($decimo_setimos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_setimo_pct = 2;
                    break;
                }
                $decimo_setimo_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($decimo_setimos as $k => $decimo) {
                if($decimo_setimo_pct > 0) {
                    $this->salvarPremiacao($grupo, $decimo, $decimo_setimo_pct / count($decimo_setimos));
                    $decimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_setimo_pct / count($decimo_setimos)) / 100;
                    $decimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($decimo);
                }
            }

            if($decimo_setimo_pct == 2) {
                continue;
            }


            //Décimo oitavo colocado
            $decimo_oitavos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 18,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_oitavo_pct = 0;
            $prc_maxima = 1.5;

            $end += count($decimo_oitavos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_oitavo_pct = 1.5;
                    break;
                }
                $decimo_oitavo_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($decimo_oitavos as $k => $decimo) {
                if($decimo_oitavo_pct > 0) {
                    $this->salvarPremiacao($grupo, $decimo, $decimo_oitavo_pct / count($decimo_oitavos));
                    $decimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_oitavo_pct / count($decimo_oitavos)) / 100;
                    $decimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($decimo);
                }
            }

            if($decimo_oitavo_pct == 1.5) {
                continue;
            }

            //Décimo nono colocado
            $decimo_nonos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 19,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_nono_pct = 0;
            $prc_maxima = 1;

            $end += count($decimo_nonos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_nono_pct = 1;
                    break;
                }
                $decimo_nono_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            if($decimo_nono_pct > 0) {
                continue;
            }

            foreach ($decimo_nonos as $k => $decimo) {
                
                $this->salvarPremiacao($grupo, $decimo, $decimo_nono_pct / count($decimo_nonos));
                $decimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_nono_pct / count($decimo_nonos)) / 100;
                $decimo['SocAposta']['vencedor'] = 0;
                $this->SocAposta->save($decimo);
                
            }

            if($decimo_nono_pct == 1) {
                continue;
            }


            //Vigésimo colocado
            $vigesimos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 20,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $vigesimo_pct = 0;
            $prc_maxima = 0.5;

            $end += count($vigesimos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $vigesimo_pct = 0.5;
                    break;
                }
                $vigesimo_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($vigesimos as $k => $vigesimo) {
                if($vigesimo_pct > 0) {
                    $this->salvarPremiacao($grupo, $vigesimo, $vigesimo_pct / count($vigesimos));
                    $vigesimo['SocAposta']['quantia'] = $grupo['SocRodadasGrupo']['arrecadado'] * ($vigesimo_pct / count($vigesimos)) / 100;
                    $vigesimo['SocAposta']['vencedor'] = 0;
                    $this->SocAposta->save($vigesimo);
                }
            }

            if($vigesimo_pct == 0.5) {
                continue;
            }
            /*$decimo_primeiros = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao >=' => 11,
                    'SocAposta.posicao <=' => 20,
                    'SocAposta.pontuacao >' => 0,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $decimo_primeiro_pct = 0;
            $prc_maxima = 6;

            $end = count($primeiros) + count($segundos) + count($terceiros) + count($quartos) + count($decimo_primeiros);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $decimo_primeiro_pct = 6;
                    break;
                }
                $decimo_primeiro_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($decimo_primeiros as $k => $decimo_primeiro) {
                $this->salvarPremiacao($grupo, $decimo_primeiro, $decimo_primeiro_pct / count($decimo_primeiros));
                $decimo_primeiro['SocAposta']['quantia'] = ($grupo['SocRodadasGrupo']['arrecadado'] * ($decimo_primeiro_pct / count($decimo_primeiros))) / 100;
                $decimo_primeiro['SocAposta']['vencedor'] = 0;
                $this->SocAposta->save($decimo_primeiro);
            }

            if($decimo_primeiro_pct == 6) {
                continue;
            }*/

            //$this->salvarPremiacao($grupo, $apostas);
        }

        $this->StartTransaction();
        $ok = true;

        //Fazendo devolução do dinheiro para os usuários
        //Porque estes grupos não possuia uma quantidade mínima de usuários
        foreach ($grupo_sem_qtd_minima as $k => $grupo) {

            $apostas = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                ],
            ]);

            foreach ($apostas as $key => $aposta) {

                $owner = $this->User->read(null, $aposta['SocAposta']['owner_id']);

                $saldo = $this->Balance->find('first', [
                    'conditions' => [
                        'Balance.owner_id' => $owner['User']['id']
                    ]
                ]);

                $historico['HistoricBalance']['balance_id'] = $saldo['Balance']['id'];
                $historico['HistoricBalance']['owner_id'] = $owner['User']['id'];
                $historico['HistoricBalance']['from'] = $saldo['Balance']['value'];


                $saldo['Balance']['value'] += $rodada['SocRodada']['valor'];

                $ok = $this->Balance->save($saldo);

                $this->HistoricBalance->create();
                $historico['HistoricBalance']['soccer_expert_bet_id'] = $aposta['SocAposta']['id'];
                $historico['HistoricBalance']['type'] = 1;
                $historico['HistoricBalance']['devolution'] = 1;
                $historico['HistoricBalance']['amount'] = $rodada['SocRodada']['valor'];
                $historico['HistoricBalance']['description'] = 'devolution';
                $historico['HistoricBalance']['to'] = $saldo['Balance']['value'];

                $ok = $this->HistoricBalance->save($historico);

                //$historico_soccer['HistoricBalanceDevolution']['historic_balance_id'] = $this->HistoricBalance->id;
                //$historico_soccer['HistoricBalanceDevolution']['soc_aposta_id'] = $aposta['SocAposta']['id'];
                //$historico_soccer['HistoricBalanceDevolution']['soc_rodada_grupo_id'] = $grupo['SocRodadasGrupo']['id'];
                //$historico_soccer['HistoricBalanceDevolution']['value'] = $rodada['SocRodada']['valor'];
                //$this->HistoricBalanceSoccer->create();
                //$this->HistoricBalanceSoccer->save($historico_soccer);
            }


        }

        $rodada['SocRodada']['active'] = 0;
        $ok = $this->SocRodada->save($rodada);

        $this->validaTransacao($ok);

        $this->response->body(json_encode([
            'msg' => 'Premiação atualizada com sucesso',
            'status' => 'ok'
        ]));

        $this->response->send();
        $this->_stop();
    }

    public function atualizarPontuacao($id)
    {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';
        $this->SocRodada->recursive = -1;

        $this->render(false);

        if($this->request->is('post')) {
            $this->loadModel('SocJogo');
            $this->SocJogo->recursive = -1;
            $this->loadModel('SocAposta');
            $this->loadModel('SocConfRodada');
            $this->loadModel('SocApostasJogo');
            $this->loadModel('SocRodadasGrupo');
            $this->SocAposta->recursive = -1;
            $this->SocConfRodada->recursive = -1;
            $this->SocApostasJogo->recursive = -1;
            $this->SocRodadasGrupo->recursive = -1;



            $config_rodada = $this->SocConfRodada->find('first', [
                'conditions' => [
                    'soc_rodada_id' => $id,
                    'active' => 1
                ]
            ]);

            if(!$config_rodada) {
                $this->response->body(json_encode([
                    'msg' => 'Não existe configuração cadastrada para a cartela',
                    'status' => 'error'
                ]));
                $this->response->statusCode(400);
                $this->response->send();
                $this->_stop();
            }

            //Pegando todas as cartelas do usuário
            $apostas = $this->SocAposta->find('all', [
                'conditions' => [
                    'soc_rodada_id' => $id
                ]
            ]);


            //Percorrendo todas as cartelas feitas
            foreach ($apostas as $a => $aposta) {
                //Pegando os jogos da cartela
                $aposta_jogos = $this->SocApostasJogo->find('all', [
                    'conditions' => [
                        'SocApostasJogo.soc_aposta_id' => $aposta['SocAposta']['id']
                    ]
                ]);

                $pontuacao = 0;
                $qtd_acertos_placares = 0;
                $qtd_acertos_diferenca_gols_ou_empates = 0;
                $qtd_pontuacao_bola_ouro = 0;
                $pontuacao_bola_ouro = 0;
                $pontuacao_sem_bola_ouro = 0;

                $pontuacao_bola_ouro_sem_prc = 0;



                //Percorrendo os jogos da cartela
                foreach ($aposta_jogos as $ap => $aposta_jogo) {


                    //Pesquisando resultado do jogo
                    $jogo = $this->SocJogo->find('first', [
                        'conditions' => [
                            'id' => $aposta_jogo['SocApostasJogo']['soc_jogo_id']
                        ]
                    ]);


                    $jogo_resultado_clube_casa = $jogo['SocJogo']['resultado_clube_casa'];
                    $jogo_resultado_clube_fora = $jogo['SocJogo']['resultado_clube_fora'];
                    $aposta_resultado_clube_casa = $aposta_jogo['SocApostasJogo']['resultado_clube_casa'];
                    $aposta_resultado_clube_fora = $aposta_jogo['SocApostasJogo']['resultado_clube_fora'];


                    if($jogo['SocJogo']['resultado_clube_casa'] == null
                        || $jogo['SocJogo']['resultado_clube_fora'] == null) {
                        continue;
                    }

                    $aposta_jogo['SocApostasJogo']['pontuacao'] = 0;

                    /**
                     * Não acertar vencedor
                     */
                    if(!$this->acertouVencedor($jogo, $aposta_jogo)) {
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $config_rodada['SocConfRodada']['nao_acertar_vencedor_jogo'];
                    }

                    /*
                     * Acertou vencedor
                     */
                    if($this->acertouVencedor($jogo, $aposta_jogo)) {
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $config_rodada['SocConfRodada']['acertar_vencedor_jogo'];
                    }

                    /*
                     * Acertou o empate, mas houve vencedor
                     */
                    if($this->empateComVendedor($jogo, $aposta_jogo)) {
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $config_rodada['SocConfRodada']['empate_com_vencedor'];
                    }

                    $old_value = $qtd_acertos_diferenca_gols_ou_empates;
                    /*
                     * Acertou o empate sem exatidão, ex: 1x1 mas o jogo foi 2x2
                     */
                    if($this->empateSemExatidao($jogo, $aposta_jogo)) {
                        $qtd_acertos_diferenca_gols_ou_empates++;
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $config_rodada['SocConfRodada']['acertar_empate_sem_exatidao'];
                    }

                    /*
                     * Acertou vecendor e diferença de gols
                     */
                    if($this->acertouDiferenca($jogo, $aposta_jogo) && $this->acertouVencedor($jogo, $aposta_jogo)) {
                        
                        $qtd_acertos_diferenca_gols_ou_empates = $old_value;
                        $qtd_acertos_diferenca_gols_ou_empates++;
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $config_rodada['SocConfRodada']['acertar_jogo_e_diferenca_gols'];
                    }


                    /*
                     * Acertou o placar
                     */
                    if($this->acertouPlacar($jogo, $aposta_jogo)) {
                        $qtd_acertos_diferenca_gols_ou_empates = $old_value;
                        $qtd_acertos_placares++;
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $config_rodada['SocConfRodada']['acertar_placar'];
                    }

                    $pontuacao_sem_bola_ouro += $aposta_jogo['SocApostasJogo']['pontuacao'];
                    if($aposta_jogo['SocApostasJogo']['bola_ouro'] == 1 && $aposta_jogo['SocApostasJogo']['pontuacao'] > 0) {
                        $pontuacao_bola_ouro_sem_prc += $aposta_jogo['SocApostasJogo']['pontuacao'];
                        $pontuacao_bola_ouro += $aposta_jogo['SocApostasJogo']['pontuacao'] + (($aposta_jogo['SocApostasJogo']['pontuacao'] * 25) / 100);
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $pontuacao_bola_ouro;
                        //$qtd_pontuacao_bola_ouro += $pontuacao_bola_ouro;
                        $qtd_pontuacao_bola_ouro++;
                    }

                    $pontuacao += $aposta_jogo['SocApostasJogo']['pontuacao'];


                    $this->SocApostasJogo->save($aposta_jogo);
                }                            

                
                //$criterio += ($qtd_acertos_diferenca_gols_ou_empates + $qtd_acertos_placares) * 3;
                
                
                //$pontuacao_bola_ouro_peso = $qtd_pontuacao_bola_ouro + $qtd_acertos_placares +    $qtd_acertos_diferenca_gols_ou_empates;
                //$criterio += $pontuacao;
                

                /*if($pontuacao_bola_ouro > 0) {
                    $pontuacao_sem_bola_ouro = $pontuacao_bola_ouro;
                }*/


                /**
                 * A quantidade de acerto dos placares vale mais do que o Maior número de acertos de diferença de gols ou empates
                 * Sabendo disso, faço a soma de todos os acertos de placares
                 * Mais a quantidade de acertos de diferença de gols
                 */
                /*$acertos_placares_peso = 0;
                if($qtd_acertos_placares > 0) {
                    $acertos_placares_peso = ($qtd_acertos_placares + $qtd_acertos_diferenca_gols_ou_empates);
                } 

                $acertos_diferenca_gols_ou_empates_peso = 0;
                if($qtd_acertos_diferenca_gols_ou_empates > 0) {
                    $acertos_diferenca_gols_ou_empates_peso = $qtd_acertos_diferenca_gols_ou_empates;
                }*/

                /*if($aposta['SocAposta']['id'] == 34) {
                    var_dump($pontuacao_sem_bola_ouro, $acertos_placares_peso, $acertos_diferenca_gols_ou_empates_peso, $pontuacao_bola_ouro_peso);
                }
                if($aposta['SocAposta']['id'] == 13) {
                    die(var_dump($pontuacao_sem_bola_ouro, $acertos_placares_peso, $acertos_diferenca_gols_ou_empates_peso, $pontuacao_bola_ouro_peso));
                }*/

                $aposta['SocAposta']['pontuacao'] = $pontuacao;
                $aposta['SocAposta']['qtd_acertos_placares'] = $qtd_acertos_placares;
                $aposta['SocAposta']['qtd_acertos_diferenca_gols_ou_empate'] = $qtd_acertos_diferenca_gols_ou_empates;
                $aposta['SocAposta']['total_pontuacao'] = $pontuacao;
                $aposta['SocAposta']['pontuacao_bola_ouro'] = $pontuacao_bola_ouro;
                $this->SocAposta->save($aposta);
            }


            $grupos = $this->SocRodadasGrupo->find('all', [
                'conditions' => [
                    'SocRodadasGrupo.soc_rodada_id =' => $id
                ]
            ]);

            //die(var_dump('ASDA'));
            foreach ($grupos as $key => $grupo) {
                
                $pontuacoes = $this->SocAposta->find('all', [
                    'fields' => 'SocAposta.total_pontuacao',
                    'conditions' => [
                        'SocAposta.soc_rodada_grupo_id =' => $grupo['SocRodadasGrupo']['id'],
                        'SocAposta.soc_rodada_id' => $grupo['SocRodadasGrupo']['soc_rodada_id']
                    ],
                    'order' => 'SocAposta.total_pontuacao DESC',
                    'group' => [
                        'SocAposta.total_pontuacao',
                    ]
                ]);

                foreach ($pontuacoes as $p => $pontuacao) {
                    
                    $aposta_empates = $this->SocAposta->find('all', [
                        'conditions' => [
                            'SocAposta.soc_rodada_grupo_id =' => $grupo['SocRodadasGrupo']['id'],
                            'SocAposta.soc_rodada_id =' => $grupo['SocRodadasGrupo']['soc_rodada_id'],
                            'SocAposta.total_pontuacao =' => $pontuacao['SocAposta']['total_pontuacao']
                        ],
                        'order' => [
                            'SocAposta.total_pontuacao DESC',
                            'SocAposta.pontuacao_bola_ouro DESC'
                        ],
                    ]);

                    for($i = 0; $i < count($aposta_empates); $i++) {
                        /*if($aposta_empates[$i]['SocAposta']['id'] == 10) {
                            die(var_dump($aposta_empates[$i]));
                        }*/
                        for($j = $i + 1; $j < count($aposta_empates); $j++) {
                            if($aposta_empates[$i]['SocAposta']['pontuacao_bola_ouro'] < $aposta_empates[$j]['SocAposta']['pontuacao_bola_ouro']) {
                                $aposta_empates[$j]['SocAposta']['total_pontuacao'] += 3;
                                /*$aux = $aposta_empates[$j]['SocAposta']['total_pontuacao'];
                                $aposta_empates[$j]['SocAposta']['total_pontuacao'] = $aposta_empates[$i]['SocAposta']['pontuacao_bola_ouro'];
                                $aposta_empates[$i]['SocAposta']['pontuacao_bola_ouro'] = $aux;*/
                                $this->SocAposta->save($aposta_empates[$j]);

                                break;
                            }

                            /*if($aposta_empates[$i]['SocAposta']['pontuacao_bola_ouro'] > $aposta_empates[$j]['SocAposta']['pontuacao_bola_ouro']) {
                                $aposta_empates[$i]['SocAposta']['total_pontuacao'] += 1;
                                $this->SocAposta->save($aposta_empates[$i]);
                                break;
                            }*/
                        }
                    }

                }
            }


            /**passo 2
            */

            foreach ($grupos as $key => $grupo) {
                
                $pontuacoes = $this->SocAposta->find('all', [
                    'fields' => 'SocAposta.total_pontuacao',
                    'conditions' => [
                        'SocAposta.soc_rodada_grupo_id =' => $grupo['SocRodadasGrupo']['id'],
                        'SocAposta.soc_rodada_id' => $grupo['SocRodadasGrupo']['soc_rodada_id']
                    ],
                    'order' => 'SocAposta.total_pontuacao DESC',
                    'group' => [
                        'SocAposta.total_pontuacao',
                    ]
                ]);

                foreach ($pontuacoes as $p => $pontuacao) {
                    
                    $aposta_empates = $this->SocAposta->find('all', [
                        'conditions' => [
                            'SocAposta.soc_rodada_grupo_id =' => $grupo['SocRodadasGrupo']['id'],
                            'SocAposta.soc_rodada_id =' => $grupo['SocRodadasGrupo']['soc_rodada_id'],
                            'SocAposta.total_pontuacao =' => $pontuacao['SocAposta']['total_pontuacao']
                        ],
                        'order' => [
                            'SocAposta.total_pontuacao DESC',
                            'SocAposta.qtd_acertos_placares DESC'
                        ],
                    ]);

                    for($i = 0; $i < count($aposta_empates); $i++) {
                        for($j = $i + 1; $j < count($aposta_empates); $j++) {
                            if($aposta_empates[$i]['SocAposta']['qtd_acertos_placares'] < $aposta_empates[$j]['SocAposta']['qtd_acertos_placares']) {
                                $aposta_empates[$j]['SocAposta']['total_pontuacao'] += 2;
                                $this->SocAposta->save($aposta_empates[$j]);
                                break;
                                /*$aposta_empates[$j]['SocAposta']['total_pontuacao'] += 1;
                                $this->SocAposta->save($aposta_empates[$j]);*/
                            }

                            /*if($aposta_empates[$i]['SocAposta']['qtd_acertos_placares'] > $aposta_empates[$j]['SocAposta']['qtd_acertos_placares']) {
                                $aposta_empates[$i]['SocAposta']['total_pontuacao'] += 1;
                                $this->SocAposta->save($aposta_empates[$i]);
                                break;
                            }*/
                        }
                    }

                }
            } 


            /**passo 3
            */

            foreach ($grupos as $key => $grupo) {
                
                $pontuacoes = $this->SocAposta->find('all', [
                    'fields' => 'SocAposta.total_pontuacao',
                    'conditions' => [
                        'SocAposta.soc_rodada_grupo_id =' => $grupo['SocRodadasGrupo']['id'],
                        'SocAposta.soc_rodada_id' => $grupo['SocRodadasGrupo']['soc_rodada_id']
                    ],
                    'order' => 'SocAposta.total_pontuacao DESC',
                    'group' => [
                        'SocAposta.total_pontuacao',
                    ]
                ]);

                foreach ($pontuacoes as $p => $pontuacao) {
                    
                    $aposta_empates = $this->SocAposta->find('all', [
                        'conditions' => [
                            'SocAposta.soc_rodada_grupo_id =' => $grupo['SocRodadasGrupo']['id'],
                            'SocAposta.soc_rodada_id =' => $grupo['SocRodadasGrupo']['soc_rodada_id'],
                            'SocAposta.total_pontuacao =' => $pontuacao['SocAposta']['total_pontuacao']
                        ],
                        'order' => [
                            'SocAposta.total_pontuacao DESC',
                            'SocAposta.qtd_acertos_diferenca_gols_ou_empate DESC'
                        ],
                    ]);

                    for($i = 0; $i < count($aposta_empates); $i++) {
                        $maior = false;
                        for($j = $i + 1; $j < count($aposta_empates); $j++) {
                            if($aposta_empates[$i]['SocAposta']['qtd_acertos_diferenca_gols_ou_empate'] < $aposta_empates[$j]['SocAposta']['qtd_acertos_diferenca_gols_ou_empate']) {
                                $aposta_empates[$j]['SocAposta']['total_pontuacao'] += 1;
                                $this->SocAposta->save($aposta_empates[$j]);
                                break;
                            }

                            /*if($aposta_empates[$i]['SocAposta']['qtd_acertos_diferenca_gols_ou_empate'] > $aposta_empates[$j]['SocAposta']['qtd_acertos_diferenca_gols_ou_empate']) {
                                $aposta_empates[$i]['SocAposta']['total_pontuacao'] += 1;
                                $this->SocAposta->save($aposta_empates[$i]);
                                break;
                            }*/
                        }
                    }

                }
            }                   

            //die(var_dump('ASDA'));
            $t = 1;
            $grupo_cont = 1;
            foreach ($grupos as $key => $grupo) {
                $pontuacoes = $this->SocAposta->find('all', [
                    'fields' => 'SocAposta.total_pontuacao',
                    'conditions' => [
                        'SocAposta.soc_rodada_grupo_id =' => $grupo['SocRodadasGrupo']['id'],
                        'SocAposta.soc_rodada_id' => $grupo['SocRodadasGrupo']['soc_rodada_id']
                    ],
                    'order' => 'SocAposta.total_pontuacao DESC',
                    'group' => [
                        'SocAposta.total_pontuacao',
                    ]
                ]);

                $loop_anterior = 0;
                $last = 1;
                foreach ($pontuacoes as $p => $pontuacao) {
                    $apostas = $this->SocAposta->find('all', [
                        'conditions' => [
                            'SocAposta.soc_rodada_grupo_id =' => $grupo['SocRodadasGrupo']['id'],
                            'SocAposta.soc_rodada_id =' => $grupo['SocRodadasGrupo']['soc_rodada_id'],
                            'SocAposta.total_pontuacao =' => $pontuacao['SocAposta']['total_pontuacao']
                        ],
                    ]);

                    
                    $count = 0;
                    foreach ($apostas as $ap => $aposta) {
                        $aposta['SocAposta']['posicao'] = ($p + 1) > 1 ? $last : 1;
                        $aposta['SocAposta']['ordem'] = $grupo_cont;
                        $grupo_cont++;
                        $count++;
                        
                        $this->SocAposta->save($aposta);

                        if((count($apostas) - 1) == $ap) {
                            $last += count($apostas);
                        }
                    }

                }
                $grupo_cont = 1;


                /*for ($i = 0; $i < count($apostas); $i++) {
                    
                    if($apostas[$i]['SocAposta']['posicao'] == null) {
                        $apostas[$i]['SocAposta']['posicao'] = $i + 1;
                    }
                    

                    for($j = $i + 1; $j < count($apostas); $j++) {
                        if($apostas[$i]['SocAposta']['pontuacao'] == $apostas[$j]['SocAposta']['pontuacao']) {

                            $apostas[$j]['SocAposta']['posicao'] = $apostas[$i]['SocAposta']['posicao'];
                            $apostas[$i]['SocAposta']['empatado'] = true;
                            $apostas[$j]['SocAposta']['empatado'] = true;
                            
                        } else if($apostas[$i]['SocAposta']['pontuacao'] > $apostas[$j]['SocAposta']['pontuacao']) {
                            $apostas[$j]['SocAposta']['posicao'] = $t + 2;
                        }
                        $this->SocAposta->save($apostas[$j]);
                    }

                    $apostas[$i]['SocAposta']['ordem'] = $i + 1;

                    $this->SocAposta->save($apostas[$i]);
                }*/
            }

            $this->response->body(json_encode([
                'msg' => 'Pontuação atualizada com sucesso',
                'status' => 'ok'
            ]));

            $this->response->send();
            $this->_stop();

        }

    }

    private function acertouDiferenca($jogo, $aposta)
    {
        $jogo_resultado_clube_casa = $jogo['SocJogo']['resultado_clube_casa'];
        $jogo_resultado_clube_fora = $jogo['SocJogo']['resultado_clube_fora'];
        $aposta_resultado_clube_casa = $aposta['SocApostasJogo']['resultado_clube_casa'];
        $aposta_resultado_clube_fora = $aposta['SocApostasJogo']['resultado_clube_fora'];

        $diferenca_jogo = $jogo_resultado_clube_casa - $jogo_resultado_clube_fora;
        $diferenca_jogo = $diferenca_jogo < 0 ? $diferenca_jogo * -1 : $diferenca_jogo;

        $diferenca_aposta = $aposta_resultado_clube_casa - $aposta_resultado_clube_fora;
        $diferenca_aposta = $diferenca_aposta < 0 ? $diferenca_aposta * -1 : $diferenca_aposta;

        if(!$this->empate($jogo_resultado_clube_casa, $jogo_resultado_clube_fora) && $diferenca_jogo == $diferenca_aposta) {
            return true;
        }
        return false;
    }

    private function empateSemExatidao($jogo, $aposta)
    {
        $jogo_resultado_clube_casa = $jogo['SocJogo']['resultado_clube_casa'];
        $jogo_resultado_clube_fora = $jogo['SocJogo']['resultado_clube_fora'];
        $aposta_resultado_clube_casa = $aposta['SocApostasJogo']['resultado_clube_casa'];
        $aposta_resultado_clube_fora = $aposta['SocApostasJogo']['resultado_clube_fora'];
        if(
            $this->empate($jogo_resultado_clube_casa, $jogo_resultado_clube_fora)
            && $this->empate($aposta_resultado_clube_casa, $aposta_resultado_clube_fora)
            && !$this->acertouPlacar($jogo, $aposta)
        )
        {
            return true;
        }
        return false;
    }

    private function empate($resultado_clube_casa, $resultado_clube_fora)
    {
        if($resultado_clube_casa == $resultado_clube_fora) {
            return true;
        }
        return false;
    }

    private function empateComVendedor($jogo, $aposta)
    {
        $jogo_resultado_clube_casa = $jogo['SocJogo']['resultado_clube_casa'];
        $jogo_resultado_clube_fora = $jogo['SocJogo']['resultado_clube_fora'];
        $aposta_resultado_clube_casa = $aposta['SocApostasJogo']['resultado_clube_casa'];
        $aposta_resultado_clube_fora = $aposta['SocApostasJogo']['resultado_clube_fora'];
        //Verifico se o usuário marcou empate, mas houve um ganhador do jogo
        if(!$this->empate($jogo_resultado_clube_casa, $jogo_resultado_clube_fora) &&
            $this->empate($aposta_resultado_clube_casa, $aposta_resultado_clube_fora))
        {
            return true;
        }
        return false;
    }


    private function acertouPlacar($jogo, $aposta)
    {
        if($jogo['SocJogo']['resultado_clube_casa'] == $aposta['SocApostasJogo']['resultado_clube_casa'] && $jogo['SocJogo']['resultado_clube_fora'] == $aposta['SocApostasJogo']['resultado_clube_fora']) {
            return true;
        }
        return false;
    }

    private function acertouVencedor($jogo, $aposta) {
        $vencedor = $jogo['SocJogo']['resultado_clube_casa'] >
        $jogo['SocJogo']['resultado_clube_fora'] ? 'casa' : 'fora';


        $vencedorUsuario = $aposta['SocApostasJogo']['resultado_clube_casa'] >
        $aposta['SocApostasJogo']['resultado_clube_fora'] ? 'casa' : 'fora';

        $jogo_resultado_clube_casa = $jogo['SocJogo']['resultado_clube_casa'];
        $jogo_resultado_clube_fora = $jogo['SocJogo']['resultado_clube_fora'];
        $aposta_resultado_clube_casa = $aposta['SocApostasJogo']['resultado_clube_casa'];
        $aposta_resultado_clube_fora = $aposta['SocApostasJogo']['resultado_clube_fora'];

        if($vencedor == $vencedorUsuario
            && !$this->empate($jogo_resultado_clube_casa, $jogo_resultado_clube_fora)
            && !$this->empate($aposta_resultado_clube_casa, $aposta_resultado_clube_fora)
        ) {
            return true;
        }
        return false;
    }

    public function cadastrarResultados($id)
    {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';
        $this->SocRodada->recursive = -1;
        $this->loadModel('SocJogo');
        $this->SocJogo->recursive = -1;
        //$categoria = $this->SocJogo->read(null, $id);

        if($this->request->is('post')) {

            $error = 0;
            $msg = '';
            foreach ($this->request->data['SocJogo'] as $key => $value) {
                $save_data['SocJogo']['id'] = $key;
                $save_data['SocJogo']['soc_rodada_id'] = $value['soc_rodada_id'];
                $save_data['SocJogo']['gel_clube_casa_id'] = $value['gel_clube_casa_id'];
                $save_data['SocJogo']['resultado_clube_casa'] = $value['resultado_clube_casa'];
                $save_data['SocJogo']['gel_clube_fora_id'] = $value['gel_clube_fora_id'];
                $save_data['SocJogo']['resultado_clube_fora'] = $value['resultado_clube_fora'];

                $this->SocJogo->create(false);
                if(!$this->SocJogo->save($save_data)) {
                    $error = 1;
                    $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                }
            }

            if($error == 0) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            }

        } else {
            $jogos = $this->SocJogo->find('all', [
                'conditions' => [
                    'soc_rodada_id' => $id
                ]
            ]);

            $categoria = $this->SocRodada->read(null, $id);
            $this->set('jogos', $jogos);
            $this->set('soc_rodada_id', $id);
            $this->set('categoria', $categoria);
        }

    }

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL       
        $this->SocRodada->recursive = 1;
        $this->SocRodada->validate = array();

        // TRATA CONDIÇÕES
        foreach($options['conditions'] as $field => $value){
            if ($field == 'SocRodada.nome'){
                $options['conditions'][$field.' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->SocRodada->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados','modal'));
    }


    public function carregarImagem($id) {
        if($this->request->is('post')) {

            $this->request->data['SocRodada']['id'] = $id;
            unset($this->SocRodada->validate);

            $this->SocRodada->create(false);

            //die(var_dump($this->request->data));
            if($this->uploadFile($_FILES['imagem_capa'], $id)) {
                $this->SocRodada->save($this->request->data);
                die(json_encode(true));
            }
            die(json_encode(false));
        } else {
            $dados = $this->SocRodada->read(null, $id);
            $this->set('dados', $dados);
        }
    }

    public function carregarImagemModal($id) {
        if($this->request->is('post')) {

            $this->rodada = $this->SocRodada->read(null, $id);
            $this->request->data['SocRodada']['id'] = $id;
            unset($this->SocRodada->validate);
            $this->SocRodada->create(false);
            //die(var_dump($this->request->data));
            if($this->uploadFileImagemModal($_FILES['imagem_modal'], $id)) {
                $this->SocRodada->save($this->request->data);
                die(json_encode(true));
            }
            die(json_encode(false));
        } else {
            $dados = $this->SocRodada->read(null, $id);
            $this->set('dados', $dados);
        }
    }

    private function uploadFileImagemModal($parametros = null, $id){

        $parts = pathinfo($parametros['name']);

        $newFileName = $id . '.' . strtolower($parts['extension']);


        $targetFile = 'files/Soccer_Expert_Rodadas_Imagem_Modal/'. $newFileName;

        if(!is_dir('files/Soccer_Expert_Rodadas_Imagem_Modal')){
            mkdir('files/Soccer_Expert_Rodadas_Imagem_Modal', 0777);
        }

        if(file_exists(WWW_ROOT.$this->rodada['SocRodada']['imagem_modal']) && $this->rodada['SocRodada']['imagem_modal'] != null) {
            unlink(WWW_ROOT.$this->rodada['SocRodada']['imagem_modal']);
        }

        if(@move_uploaded_file($parametros['tmp_name'], $targetFile)){
            $this->request->data['SocRodada']['imagem_modal'] = $targetFile;
            return true;
        }

        return false;
    }

    private function uploadFile($parametros = null, $id){

        $parts = pathinfo($parametros['name']);

        $newFileName = $id . '.' . strtolower($parts['extension']);

        $targetFile = 'files/Soccer_Expert_Rodadas/'. $newFileName;

        if(!is_dir('files/Soccer_Expert_Rodadas')){
            mkdir('files/Soccer_Expert_Rodadas', 0777);
        }

        if(@move_uploaded_file($parametros['tmp_name'], $targetFile)){
            $this->request->data['SocRodada']['imagem_capa'] = $targetFile;
            return true;
        }

        return false;
    }

    public function add() {

        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel('SocBolao');
        $optionsBoloes = $this->SocBolao->find('list');
        $this->loadModel('SocCategoria');
        $this->SocCategoria->recursive = -1;
        $optionsCategorias = $this->SocCategoria->find('list');

        $this->loadModel('SocCiclo');
        $this->SocCiclo->recursive = -1;
        $optionsCiclos = $this->SocCiclo->find('list');

        $this->set(compact('optionsBoloes', 'optionsCategorias', 'optionsCiclos'));
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SocRodada']['valor'] = $this->App->formataValorDouble($this->request->data['SocRodada']['valor']);
            if ($this->SocRodada->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel('SocBolao');
        $optionsBoloes = $this->SocBolao->find('list');

        $this->loadModel('SocCategoria');
        $optionsCategorias = $this->SocCategoria->find('list');

        $this->loadModel('SocCiclo');
        $this->SocCiclo->recursive = -1;
        $optionsCiclos = $this->SocCiclo->find('list');

        $this->set(compact('optionsBoloes', 'optionsCategorias', 'optionsCiclos'));

        $this->SocRodada->id = $id;
        if (!$this->SocRodada->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SocRodada']['id'] = $id;
            $this->request->data['SocRodada']['valor'] = $this->App->formataValorDouble($this->request->data['SocRodada']['valor']);
            if ($this->SocRodada->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }else{

            $this->request->data = $this->SocRodada->read(null, $id);
            $this->request->data['SocRodada']['fechada'] = $this->request->data['SocRodada']['fechada'] == 'Sim' ? 1 : 0;
        }
    }

    public function delete($id = null) {
        parent::_delete($id);
    }
}