<section id="AppGelCadastros">
    <div class="section-body">
        <div class="card">
            <div class="card-head card-head-sm style-primary">
                <header>
                    <i class="md md-apps" style="margin-bottom:0;"></i> Cadastros 
                </header>
            </div>

            <div class="card-body" style="min-height:500px;">
                <h4 class="pull-left" style="padding-right:5px;">SOCCER EXPERT</h4>
                <hr style="margin-top:21px" />
                <div class="row">
                    <?php if ($this->Session->read("Auth.User.group_id") == 1) { ?>
                        <div class="col-sm-2">
                            <div id="gelClubes" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciamento dos Clubes">
                                <i class="md md-store" style="font-size:24px;display:block;"></i>
                                Clubes
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-sm-2">
                        <div id="socBoloes" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciamento dos Gêneros">
                            <i class="md md-security" style="font-size:24px;display:block;"></i> 
                            Gênero
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div id="socCategorias" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciar Categorias">
                            <i class="md md-security" style="font-size:24px;display:block;"></i> 
                            Categoria
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div id="socRodadas" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciar Rodadas">
                            <i class="md md-security" style="font-size:24px;display:block;"></i> 
                            Cartela
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div id="socCiclos" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciar Ciclos">
                            <i class="md md-security" style="font-size:24px;display:block;"></i> 
                            Ciclos
                        </div>
                    </div>
                </div>

                <br/>
                <h4 class="pull-left" style="padding-right:5px;">LOTERIA</h4>
                <hr style="margin-top:21px" />
                <div class="row">
                    <div class="col-sm-2">
                        <div id="lotCategorias" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciamento de Categoria">
                            <i class="md md-language" style="font-size:24px; display:block;"></i> 
                            Gerenciar Categorias
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div id="lotJogos" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciamento de jogos da loteria">
                            <i class="md md-language" style="font-size:24px; display:block;"></i> 
                            Gerenciar Sorteios
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div id="lotJogosResultados" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="">
                            <i class="md md-language" style="font-size:24px; display:block;"></i> 
                            Visualizar Resultados
                        </div>
                    </div>

                </div>
                <h4 class="pull-left" style="padding-right:5px;">RASPADINHAS</h4>
                <hr style="margin-top:21px" />
                <div class="row">
                    <div class="col-sm-2">
                        <div id="temasRaspadinhas" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Criação de Temas de Raspadinha">
                            <i class="md md-view-quilt" style="font-size:24px; display:block;"></i> 
                            Temas Raspadinhas
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div id="rasLotes" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciar os lotes das Raspadinhas">
                            <i class="md md-view-quilt" style="font-size:24px; display:block;"></i> 
                            Lotes
                        </div>
                    </div>    
                    <div class="col-sm-2">
                        <div id="rasTabelasDescontos" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciar Tabela de Preços e Descontos das Raspadinhas">
                            <i class="md md-view-quilt" style="font-size:24px; display:block;"></i> 
                            Tabelas de Preços e Descontos
                        </div>
                    </div>  
                    <div class="col-sm-2">
                        <div id="rasTabelasPremios" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciar Tabela de Prêmios das Raspadinhas">
                            <i class="md md-view-quilt" style="font-size:24px; display:block;"></i> 
                            Tabelas de Prêmios
                        </div>
                    </div> 
                    <!-- <div class="col-sm-2">
                        <div id="rasDemos" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciar Demos das Raspadinhas">
                            <i class="md md-view-quilt" style="font-size:24px;display:block;"></i> 
                            Demos das Raspadinhas
                        </div>
                    </div>   -->              
                </div>


                <h4 class="pull-left" style="padding-right:5px;">Relatórios</h4>
                <hr style="margin-top:21px" />
                <div class="row">
                    <div class="col-sm-2">
                        <div id="relatorioItens" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Relatórios de Itens comprados">
                            <i class="md md-view-quilt" style="font-size:24px; display:block;"></i>
                            Itens Comprados
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div id="relatorioPagSeguroDepositos" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Relatórios de Depósitos Pagseguro">
                            <i class="md md-view-quilt" style="font-size:24px; display:block;"></i>
                            Depósitos Pagseguro
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div id="relatorioPaypalDepositos" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Relatórios de Depósitos Paypal">
                            <i class="md md-view-quilt" style="font-size:24px; display:block;"></i>
                            Depósitos PayPal
                        </div>
                    </div>
                    <!-- <div class="col-sm-2">
                        <div id="rasDemos" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciar Demos das Raspadinhas">
                            <i class="md md-view-quilt" style="font-size:24px;display:block;"></i>
                            Demos das Raspadinhas
                        </div>
                    </div>   -->
                </div>

                <h4 class="pull-left" style="padding-right:5px;">Saque</h4>
                <hr style="margin-top:21px" />
                <div class="row">
                    <div class="col-sm-2">
                        <div id="retiradaAgentes" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciamento de retiradas">
                            <i class="md md-view-quilt" style="font-size:24px; display:block;"></i>
                            Agente de pagamento
                        </div>
                    </div>
                    <!-- <div class="col-sm-2">
                        <div id="rasDemos" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciar Demos das Raspadinhas">
                            <i class="md md-view-quilt" style="font-size:24px;display:block;"></i>
                            Demos das Raspadinhas
                        </div>
                    </div>   -->
                </div>

                <h4 class="pull-left" style="padding-right:5px;">Contatos</h4>
                <hr style="margin-top:21px" />
                <div class="row">
                    <div class="col-sm-2">
                        <div id="contatos" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciamento de contatos">
                            <i class="md md-view-quilt" style="font-size:24px; display:block;"></i>
                            Contatos
                        </div>
                    </div>
                    <!-- <div class="col-sm-2">
                        <div id="rasDemos" class="text-center hover" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="Gerenciar Demos das Raspadinhas">
                            <i class="md md-view-quilt" style="font-size:24px;display:block;"></i>
                            Demos das Raspadinhas
                        </div>
                    </div>   -->
                </div>



                <?php if ($this->Session->read("Auth.User.group_id") == 1) { ?>                  

                    <h4 class="pull-left" style="padding-right:5px;">Segurança</h4>
                    <hr style="margin-top:21px" />
                    <div class="row">
                        <div class="col-sm-2">
                            <div id="users" class="text-center hover" style="cursor:pointer;">
                                <i class="md md-person" style="font-size:24px;display:block;"></i> 
                                Usuários
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div id="groups" class="text-center hover" style="cursor:pointer;">
                                <i class="md md-people" style="font-size:24px;display:block;"></i> 
                                Grupos
                            </div>
                        </div
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>