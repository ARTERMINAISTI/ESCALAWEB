<div class="modal fade" id="FiltroModal" role="dialog" aria-spanledby="FiltroModalspan">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="get" action="ConsultaConteiner.php">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-span="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="FiltroModalspan">Filtrar contêiner</h4>
            </div>
            <div class="modal-body">
				<div class="col-xs-12 col-md-12 pullBottom">
                    <span>Filial</span>
                    <select name="filial[]" multiple id="filial">
                        <?php                        
                            foreach($ConsultaConteiner->getFiltro('FILIAL') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">{$filtro['C2']} - {$filtro['C1']}</option>";
                            }                        
                        ?>
                    </select>
                </div>
				<div class="col-xs-12 col-md-12 pullBottom">
                    <span>Cliente</span>
                    <select name="cliente[]" multiple id="cliente">
                        <?php                        
                            foreach($ConsultaConteiner->getFiltro('CLIENTE') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">    {$filtro['C2']} - {$filtro['C1']}</option>";
                            }                        
                        ?>
                    </select>
                </div> 
				<div class="col-xs-12 col-md-6 pullBottom">
                    <span>Situação</span>
                    <select name="situacao[]" multiple id="situacao">
                        <?php                        
                            foreach($ConsultaConteiner->getFiltro('SITUACAO') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">{$filtro['C1']}</option>";
                            }                        
                        ?>
                    </select>
                </div>	
				<div class="col-xs-12 col-md-6 pullBottom">
                    <span>Tipo de operação</span>
                    <select name="tipooperacao[]" multiple id="tipooperacao">
                        <?php                        
                            foreach($ConsultaConteiner->getFiltro('TIPOOPERACAO') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">{$filtro['C1']}</option>";
                            }                        
                        ?>
                    </select>
                </div>								
                <div class="col-xs-12 col-md-6 pullBottom">
                    <span>Contêiner</span>
					<input type="text" id="conteiner"  class="form-control" name="conteiner">
                </div>		
				<div class="col-xs-12 col-md-6 pullBottom">
                    <span>Tipo de contêiner</span>
                    <select name="tipoconteiner[]" multiple id="tipoconteiner">
                        <?php                        
                            foreach($ConsultaConteiner->getFiltro('TIPOCONTEINER') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">{$filtro['C1']} - {$filtro['C2']}</option>";
                            }                        
                        ?>
                    </select>
                </div>	
				<div class="col-xs-12 col-md-6 pullBottom">
                    <span>Localização</span>
                    <select name="localizacao[]" multiple id="localizacao">
                        <?php                        
                            foreach($ConsultaConteiner->getFiltro('LOCALIZACAO') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">{$filtro['C1']}</option>";
                            }                        
                        ?>
                    </select>
                </div>
				<div class="col-xs-12 col-md-6 pullBottom">
                    <span>Classificação ISO</span>
                    <select name="classificacaoiso[]" multiple id="classificacaoiso">
                        <?php                        
                            foreach($ConsultaConteiner->getFiltro('CLASSIFICACAOISO') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">{$filtro['C1']} - {$filtro['C2']}</option>";
                            }                        
                        ?>
                    </select>
                </div>			
				<div class="col-xs-6 col-md-6 pullBottom">
					<span>Dada de entrada</span>
					<input type="date" id="dataInicio"  class="form-control" name="dataInicio">
				</div>
				<div class="col-xs-6 col-md-6 pullBottom">
					<span>Dada de saída</span>
					<input type="date" id="dataFinal"  class="form-control" name="dataFinal">
				</div>	
				<div class="col-xs-12 col-md-6 pullBottom">
                    <span>Finalidade</span>
                    <select name="finalidade[]" multiple id="finalidade">
                        <?php                        
                            foreach($ConsultaConteiner->getFiltro('FINALIDADE') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">{$filtro['C1']}</option>";
                            }                        
                        ?>
                    </select>
                </div>		
				<div class="col-xs-6 col-md-6 pullBottom">
					<span>Data de demurrage</span>
					<input type="date" id="dataDemurrage"  class="form-control" name="dataDemurrage">
				</div>					
			</div>
            <div class="modal-footer">
                <button type="button" class="botaoBranco pullTop" data-dismiss="modal">Cancelar</button>
                <button type="button" class="botaoBranco pullTop" onclick="limparFiltro()">Limpar</button>
                <button type="button" class="botaoBranco pullTop" onclick="aplicarFiltro()">Aplicar</button>
            </div>       
         </form>     
        </div>
    </div>
</div>