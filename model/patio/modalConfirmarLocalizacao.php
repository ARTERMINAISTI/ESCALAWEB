<div class="modal fade" id="confirmarModal"  role="dialog" aria-spanledby="ConfirmarLocalizacaoModalspan">
  <div class="modal-dialog" role="document">
        <div class="modal-content">
      <form method="post" action="#">
            <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-span="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="ConfirmarLocalizacaoModalspan">Deseja confirmar a localização?</h4>
        </div>
        <div class="col-md-5">												
          <span>Localização</span>
            <select class="form-control" id="localizacaoSelect" name="localizacaoSelect[]" class="editou form-control pulaCampoEnter" required="required">
                <?php                        
                    foreach($ConfirmarLocalizacaoConteiner->getFiltro('LOCALIZACAO') as $localizacao) {                                 
                        echo "<option value=\"{$localizacao['HANDLE']}\">{$localizacao['C1']}</option>";
                    }                        
                ?>
            </select>		
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="botaoBrancoLg" data-dismiss="modal">Não</button>
          <button type="button" class="botaoBrancoLg" id="sim" onClick="ConfirmarLocalizacao()">Sim</button>
        </div>
          </form>
    </div>
      </div>
</div>

<script type="text/javascript" src="../tecnologia/js/scriptConfirmarLocalizacaoConteiner.js"></script>