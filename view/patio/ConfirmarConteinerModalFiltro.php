<div class="modal fade" id="FiltroModal" role="dialog" aria-spanledby="FiltroModalspan">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="get" action="ConfirmarLocalizacaoConteiner.php">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-span="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="FiltroModalspan">Filtrar contêiner</h4>
            </div>
            <div class="modal-body">
				<div class="col-xs-12 col-md-12 pullBottom">
                    <span>Filial</span>
                    <select name="filial[]" multiple id="filial">
                        <?php                        
                            foreach($ConfirmarLocalizacaoConteiner->getFiltro('FILIAL') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">{$filtro['C2']} - {$filtro['C1']}</option>";
                            }                        
                        ?>
                    </select>
                </div>
				<div class="col-xs-12 col-md-12 pullBottom">
                    <span>Cliente</span>
                    <select name="cliente[]" multiple id="cliente">
                        <?php                        
                            foreach($ConfirmarLocalizacaoConteiner->getFiltro('CLIENTE') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">    {$filtro['C2']} - {$filtro['C1']}</option>";
                            }                        
                        ?>
                    </select>
                </div> 					
                <div class="col-xs-12 col-md-6 pullBottom">
                    <span>Contêiner</span>
                    <select name="conteiner[]" multiple id="conteiner">
                        <?php                        
                            foreach($ConfirmarLocalizacaoConteiner->getFiltro('CONTEINER') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">{$filtro['C1']}</option>";
                            }                        
                        ?>
                    </select>
                </div>		
				<div class="col-xs-12 col-md-6 pullBottom">
                    <span>Localização</span>
                    <select name="localizacao[]" multiple id="localizacao">
                        <?php                        
                            foreach($ConfirmarLocalizacaoConteiner->getFiltro('LOCALIZACAO') as $filtro) {                                 
                                echo "<option value=\"{$filtro['HANDLE']}\">{$filtro['C1']}</option>";
                            }                        
                        ?>
                    </select>
                </div>
				<div class="col-xs-6 col-md-6 pullBottom">
					<span>Data</span>
					<input type="datetime-local" id="dataOrdem"  class="form-control" name="dataOrdem">
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