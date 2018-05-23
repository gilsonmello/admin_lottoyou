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

        $this->Balance->save($saldo);

        $historico['HistoricBalance']['soccer_expert_bet_id'] = $dado['SocAposta']['id'];
        $historico['HistoricBalance']['amount'] = $grupo['SocRodadasGrupo']['arrecadado'] * $porcentagem / 100;
        $historico['HistoricBalance']['to'] = $saldo['Balance']['value'];
        $historico['HistoricBalance']['type'] = 1;
        $historico['HistoricBalance']['description'] = 'awards';
        $this->HistoricBalance->create();
        $this->HistoricBalance->save($historico);

        //$historico_soccer['HistoricBalanceSoccer']['historic_balance_id'] = $this->HistoricBalance->id;
        //$historico_soccer['HistoricBalanceSoccer']['soc_aposta_id'] = $dado['SocAposta']['id'];
        //$historico_soccer['HistoricBalanceSoccer']['soc_rodada_grupo_id'] = $grupo['SocRodadasGrupo']['id'];
        //$historico_soccer['HistoricBalanceSoccer']['value'] = $grupo['SocRodadasGrupo']['arrecadado'] * $porcentagem / 100;
        //$this->HistoricBalanceSoccer->create();
        //$this->HistoricBalanceSoccer->save($historico_soccer);
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
                    'SocAposta.posicao =' => 1
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);

            $prc_maxima = 77;
            if(count($primeiros) >= 20) {
                foreach ($primeiros as $key => $primeiro) {
                    $this->salvarPremiacao($grupo, $primeiro, count($primeiros) / $prc_maxima);
                }   
                continue;
            } else if(count($primeiros) == 0) {
                continue;
            }

            $primeiro_pct = 0;
            
            $pos_disponivel = 0;

            for ($i = 0; $i < count($primeiros); $i++) { 
                if(!isset($prc[$i])) {
                    $primeiro_pct = 77;
                    break;
                }
                $primeiro_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($primeiros as $key => $primeiro) {
                $this->salvarPremiacao($grupo, $primeiro, $primeiro_pct / count($primeiros));
            }

            if($primeiro_pct == 77) {
                continue;
            }


            $segundos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 2,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $segundos_pct = 0; 
            $prc_maxima = 28;

            for ($i = $pos_disponivel; $i < count($primeiros) + count($segundos); $i++) { 
                if(!isset($prc[$i])) {
                    $segundos_pct = 28;
                    break;
                }
                $segundos_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($segundos as $key => $segundo) {
                $this->salvarPremiacao($grupo, $primeiro, $segundos_pct / count($segundos));
            }

            if($segundos_pct == 28) {
                continue;
            }


            $terceiros = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao =' => 3,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $terceiros_pct = 0;
            $prc_maxima = 18;


            for ($i = $pos_disponivel; $i < count($primeiros) + count($segundos) + count($terceiros); $i++) { 
                if(!isset($prc[$i])) {
                    $terceiros_pct = 18;
                    break;
                }
                $terceiros_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($terceiros as $key => $terceiro) {
                $this->salvarPremiacao($grupo, $primeiro, $terceiros_pct / count($terceiros));
            }
            if($terceiros_pct == 18) {
                continue;
            }

            $quartos = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao >=' => 4,
                    'SocAposta.posicao <=' => 10,
                ],
                'order' => 'SocAposta.posicao DESC'
            ]);
            $quartos_pct = 0;    
            $prc_maxima = 11;     

            $end = count($primeiros) + count($segundos) + count($terceiros) + count($quartos);
            for ($i = $pos_disponivel; $i < $end; $i++) {
                if(!isset($prc[$i])) {
                    $quartos_pct = 11;
                    break;
                }
                $quartos_pct += $prc[$i]['prc'];
                $prc[$i]['status'] = 0;
                $pos_disponivel = $i + 1;
            }

            foreach ($quartos as $key => $quarto) {
                $this->salvarPremiacao($grupo, $primeiro, $quartos_pct / count($quartos));
            }

            if($quartos_pct == 11) {
                continue;
            }


            $decimo_primeiros = $this->SocAposta->find('all', [
                'conditions' => [
                    'SocAposta.soc_rodada_grupo_id' => $grupo['SocRodadasGrupo']['id'],
                    'SocAposta.posicao >=' => 11,
                    'SocAposta.posicao <=' => 20,
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

            foreach ($decimo_primeiros as $key => $decimo_primeiro) {
                $this->salvarPremiacao($grupo, $primeiro, $decimo_primeiro_pct / count($decimo_primeiros));
            }

            if($decimo_primeiro_pct == 6) {
                continue;
            }

            //$this->salvarPremiacao($grupo, $apostas);
        }


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

                $this->Balance->save($saldo);

                $historico['HistoricBalance']['soccer_expert_bet_id'] = $aposta['SocAposta']['id'];
                $historico['HistoricBalance']['type'] = 1;
                $historico['HistoricBalance']['devolution'] = 1;
                $historico['HistoricBalance']['amount'] = $rodada['SocRodada']['valor'];
                $historico['HistoricBalance']['description'] = 'soccer_expert';
                $historico['HistoricBalance']['to'] = $saldo['Balance']['value'];
                $this->HistoricBalance->create();
                $this->HistoricBalance->save($historico);

                //$historico_soccer['HistoricBalanceDevolution']['historic_balance_id'] = $this->HistoricBalance->id;
                //$historico_soccer['HistoricBalanceDevolution']['soc_aposta_id'] = $aposta['SocAposta']['id'];
                //$historico_soccer['HistoricBalanceDevolution']['soc_rodada_grupo_id'] = $grupo['SocRodadasGrupo']['id'];
                //$historico_soccer['HistoricBalanceDevolution']['value'] = $rodada['SocRodada']['valor'];
                //$this->HistoricBalanceSoccer->create();
                //$this->HistoricBalanceSoccer->save($historico_soccer);




            }


        }

        $rodada['SocRodada']['active'] = 0;
        $this->SocRodada->save($rodada);

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

        $this->render = false;

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

                //Percorrendo os jogos da cartela
                foreach ($aposta_jogos as $ap => $aposta_jogo) {

                    //Pesquisando resultado do jogo
                    $jogo = $this->SocJogo->find('first', [
                        'conditions' => [
                            'id' => $aposta_jogo['SocApostasJogo']['soc_jogo_id']
                        ]
                    ]);

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

                    /*
                     * Acertou o empate sem exatidão, ex: 1x1 mas o jogo foi 2x2
                     */
                    if($this->empateSemExatidao($jogo, $aposta_jogo)) {
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $config_rodada['SocConfRodada']['acertar_empate_sem_exatidao'];
                    }

                    /*
                     * Acertou vecendor e diferença de gols
                     */
                    if($this->acertouDiferenca($jogo, $aposta_jogo) && $this->acertouVencedor($jogo, $aposta_jogo)) {
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $config_rodada['SocConfRodada']['acertar_jogo_e_diferenca_gols'];
                    }

                    /*
                     * Acertou o placar
                     */
                    if($this->acertouPlacar($jogo, $aposta_jogo)) {
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $config_rodada['SocConfRodada']['acertar_placar'];
                    }

                    if($aposta_jogo['SocApostasJogo']['bola_ouro'] == 1) {
                        $aposta_jogo['SocApostasJogo']['pontuacao'] = $aposta_jogo['SocApostasJogo']['pontuacao'] * 2;
                    }


                    $pontuacao += $aposta_jogo['SocApostasJogo']['pontuacao'];

                    $this->SocApostasJogo->save($aposta_jogo);
                }

                $aposta['SocAposta']['pontuacao'] = $pontuacao;
                $this->SocAposta->save($aposta);
            }

            $grupos = $this->SocRodadasGrupo->find('all', [
                'conditions' => [
                    'SocRodadasGrupo.soc_rodada_id =' => $id
                ]
            ]);



            $t = 1;
            $grupo_cont = 1;
            foreach ($grupos as $key => $grupo) {
                $pontuacoes = $this->SocAposta->find('all', [
                    'fields' => 'SocAposta.pontuacao',
                    'conditions' => [
                        'SocAposta.soc_rodada_grupo_id =' => $grupo['SocRodadasGrupo']['id'],
                        'SocAposta.soc_rodada_id' => $grupo['SocRodadasGrupo']['soc_rodada_id']
                    ],
                    'order' => 'SocAposta.pontuacao DESC',
                    'group' => [
                        'SocAposta.pontuacao'
                    ]
                ]);

                foreach ($pontuacoes as $p => $pontuacao) {
                    $apostas = $this->SocAposta->find('all', [
                        'conditions' => [
                            'SocAposta.soc_rodada_grupo_id =' => $grupo['SocRodadasGrupo']['id'],
                            'SocAposta.soc_rodada_id =' => $grupo['SocRodadasGrupo']['soc_rodada_id'],
                            'SocAposta.pontuacao =' => $pontuacao['SocAposta']['pontuacao']
                        ],
                    ]);

                    foreach ($apostas as $ap => $aposta) {
                        $aposta['SocAposta']['posicao'] = $p + 1;
                        $aposta['SocAposta']['ordem'] = $grupo_cont;
                        $grupo_cont++;
                        $this->SocAposta->save($aposta);
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
        }
    }

    public function delete($id = null) {
        parent::_delete($id);
    }
}