<?php

    include_once('../../controller/tecnologia/Sistema.php');
    date_default_timezone_set('America/Sao_Paulo');
    include_once('../../controller/tecnologia/WS.php');

    class Pedido {
        
        private $handle;
        private $numero;
        private $filial;
        private $status;
        private $statusNome;
        private $connect;
        private $documentoHandle;

        function __construct() {
            $this->connect = Sistema::getConexao(false);
        }
        
        public function setHandle($prHandle){
            $this->handle = $prHandle;

            $query = $this->connect->prepare("SELECT A.NUMERO,
                                                     A.FILIAL,
                                                     A.STATUS,
                                                     B.NOME STATUSNOME
                                                FROM RA_PEDIDO A
                                                LEFT JOIN RA_STATUSPEDIDO B ON B.HANDLE = A.STATUS
                                               WHERE A.HANDLE = '$prHandle' ");
            $query->execute();
            $dataSet = $query->fetch(PDO::FETCH_ASSOC);

            $this->filial = $dataSet['FILIAL'];
            $this->numero = $dataSet['NUMERO'];
            $this->status = $dataSet['STATUS'];
            $this->statusNome = $dataSet['STATUSNOME'];
        }        

        public function setDocumentoHandle($prDocumentoHandle){
            $this->documentoHandle = $prDocumentoHandle;
        }

        public function getDocumentoHandle(){
            return $this->documentoHandle;
        }

        public function getHandle(){
            return $this->handle;
        }

        public function getNumero(){
            return $this->numero;
        }

        public function getHandlePorRastreamento($prRastreamento){
            $query = $this->connect->prepare("SELECT HANDLE FROM RA_PEDIDO WHERE RASTREAMENTO = '" . $prRastreamento . "'");

            $query->execute();

            $dataSet = $query->fetch(PDO::FETCH_OBJ);
            
            echo json_encode($dataSet);
        }
        
        public function getPrimeiraEmpresa(){
            $query = $this->connect->prepare("SELECT COALESCE(B.APELIDO, A.NOME) APELIDOPRIMEIRAEMPRESA
                                                FROM MS_EMPRESA A
                                                LEFT JOIN MS_PESSOA B ON B.HANDLE = A.PESSOA
                                               WHERE A.STATUS = 4
                                                 AND NOT EXISTS (SELECT X.HANDLE
                                                                   FROM MS_EMPRESA X
                                                                  WHERE X.STATUS = 4
                                                                    AND X.HANDLE < A.HANDLE) ");

            $query->execute();

            $dataSet = $query->fetch(PDO::FETCH_OBJ);
            
            echo json_encode($dataSet);
        }

        public function getRastreamentoClienteFinal() {
            $query = $this->connect->prepare("SELECT B.VALOR CLIENTEFINAL
                                                FROM MS_PARAMETRO A 
                                               INNER JOIN MS_PARAMETROVALOR B ON B.PARAMETRO = A.HANDLE 
                                               WHERE A.NOME = 'RASTREAMENTOPEDIDOCLIENTEFINAL' ");

            $query->execute();

            $dataSet = $query->fetch(PDO::FETCH_OBJ);

            echo json_encode($dataSet);    
        }

        public function getEtapaEvento(){            
            $query = $this->connect->prepare("SELECT HANDLE, 
                                                    DATA, 
	                                                SEQUENCIAL,
                                                    ETAPA, 
                                                    LOWER(REPLACE(ETAPAIMAGEMSTATUS, '_', '/')) ETAPAIMAGEMSTATUS, 
                                                    COALESCE(OBSERVACAO, '') OBSERVACAO, 
	                                                EVENTOHANDLE,
                                                    EVENTODATA, 
                                                    TIPOEVENTO, 
                                                    COALESCE(EVENTOOBSERVACAO, '') EVENTOOBSERVACAO,
                                                    LOWER(REPLACE(EVENTOIMAGEMSTATUS, '_', '/')) EVENTOIMAGEMSTATUS
                                            FROM (
                                                SELECT A.HANDLE HANDLE, 
                                                        1 SUB,
                                                        A.DATA DATA, 
		                                                A.SEQUENCIAL,
                                                        B01.RESOURCENAME ETAPAIMAGEMSTATUS,
                                                        A.TITULO ETAPA, 
                                                        A.OBSERVACAO OBSERVACAO,
		                                                COALESCE(C.HANDLE, 0) EVENTOHANDLE,
                                                        C.DATA EVENTODATA,
                                                        A.OBSERVACAO EVENTOOBSERVACAO,
                                                        D.NOME TIPOEVENTO,
                                                        F.RESOURCENAME EVENTOIMAGEMSTATUS
                                                FROM RA_PEDIDOETAPA A  
                                                LEFT JOIN MS_STATUS B0 ON A.STATUS = B0.HANDLE 
                                                LEFT JOIN MD_IMAGEM B01 ON B01.HANDLE = B0.IMAGEM
                                                LEFT JOIN RA_TIPOETAPA B1 ON A.ETAPA = B1.HANDLE 
                                                LEFT JOIN RA_PEDIDOETAPAEVENTO C ON C.PEDIDOETAPA = A.HANDLE AND C.STATUS <> 6
                                                LEFT JOIN RA_TIPOEVENTO D ON D.HANDLE = C.TIPO
                                                LEFT JOIN MS_STATUS E ON E.HANDLE = C.STATUS
                                                LEFT JOIN MD_IMAGEM F ON F.HANDLE = E.IMAGEM
                                                WHERE A.PEDIDO = '" . $this->handle . "'
                                                  AND A.STATUS = 9
                                            
                                                UNION ALL
                                            
                                                SELECT A.HANDLE HANDLE, 
                                                        2 SUB,
                                                        A.DATA DATA,  
		                                                A.NUMERO SEQUENCIAL,
                                                        NULL ETAPAIMAGEMSTATUS,
                                                        B3.NOME ETAPA, 
                                                        A.OBSERVACAO OBSERVACAO,
                                                        0 EVENTOHANDLE,
                                                        NULL EVENTODATA,
                                                        NULL EVENTOOBSERVACAO,
                                                        NULL TIPOEVENTO,
                                                        NULL EVENTOIMAGEMSTATUS
                                                FROM OP_OCORRENCIA A  
                                                LEFT JOIN OP_STATUSOCORRENCIA B0 ON A.STATUS = B0.HANDLE 
                                                LEFT JOIN MS_FILIAL B1 ON A.FILIAL = B1.HANDLE 
                                                LEFT JOIN OP_TIPOOCORRENCIA B2 ON A.TIPO = B2.HANDLE 
                                                LEFT JOIN OP_ACAOOCORRENCIA B3 ON A.ACAO = B3.HANDLE 
                                                WHERE A.EMPRESA IN (1)
                                                AND A.STATUS = 4
                                                AND EXISTS(SELECT X.HANDLE           
                                                            FROM RA_PEDIDOMOVIMENTACAO X          
                                                            INNER JOIN GD_DOCUMENTO  X1 ON X1.HANDLE = X.DOCUMENTO          
                                                            WHERE X.PEDIDO = '" . $this->handle . "'
                                                            AND X1.DOCUMENTOTRANSPORTE = A.DOCUMENTOTRANSPORTE) 
                                            )
                                            AS ETAPAS
                                            ORDER BY DATA DESC, SUB, SEQUENCIAL DESC, HANDLE, EVENTODATA DESC");
            $query->execute();

            $retorno = [];

            while($dataSet = $query->fetch(PDO::FETCH_OBJ)){
                array_push($retorno, $dataSet);
            }

            echo json_encode($retorno);
        }

        public function getDocumentoPdf(){
            WebService::setupCURL("/rastreio/pedido/baixarDocumentoPdf", ["DOCUMENTO" => $this->GetDocumentoHandle()]);
            
            WebService::execute();

            $body = WebService::getBody();

            $dados = json_decode($body);

            //-- QUANDO O DATATYPE É JSON, PRECISA RETORNAR UM JSON VÁLIDO PRA CAIR NO SUCESS
            if (isset($dados->Arquivo)) {
                echo $body;
            } else {
                echo Sistema::retornoJson(500, $body);
            }
        }

        public function getDocumentoXml(){
            WebService::setupCURL("/rastreio/pedido/baixarDocumentoXml", ["DOCUMENTO" => $this->GetDocumentoHandle()]);
            
            WebService::execute();

            $body = WebService::getBody();
            
            $dados = json_decode($body);

            //-- QUANDO O DATATYPE É JSON, PRECISA RETORNAR UM JSON VÁLIDO PRA CAIR NO SUCESS
            if (isset($dados->Arquivo)) {
                echo $body;
            } else {
                echo Sistema::retornoJson(500, $body);
            }
        }

        public function getConsultaGenericaMalFeita(){
            $usuario = $_SESSION['handleUsuario'];
            $empresa = $_SESSION['empresa'];

            $pessoaUsuarioFiltro = Sistema::getPessoaUsuarioToStr($this->connect);

            if ($pessoaUsuarioFiltro == '') {

                $vFromPessoaUsuario = " ";
                $vfiltroPessoaUsuario = " ";
            } else {
                $vFromPessoaUsuario = " LEFT JOIN MS_PESSOA O (NOLOCK) ON O.HANDLE IN ($pessoaUsuarioFiltro) ";
                $vfiltroPessoaUsuario = " AND CASE WHEN O.CNPJCPF = A.CNPJCPFDESTINATARIO THEN 'S' 
                                                WHEN O.CNPJCPF = A.CNPJCPFREMETENTE THEN 'S' 
                                                WHEN O.CNPJCPF = G.CNPJCPF THEN 'S' 
                                            ELSE 'N' END  = 'S' ";
            }
            $vFiltro = "";
            $bFiltro = false;

            if ((Sistema::getFiltroPostLookupArray("filtroCliente", "A.CLIENTE") != '') and (Sistema::getFiltroPostLookupArray("filtroUnidadenegocio", "A.UNIDADENEGOCIOCLIENTE") == '')) {
                $vFiltroUnidadeNegocio = " AND (A.UNIDADENEGOCIOCLIENTE IN (SELECT X.UNIDADENEGOCIOCLIENTE
                                                                            FROM MS_PESSOACLIENTEUNIDADE X (NOLOCK) 
                                                                            INNER JOIN MS_PESSOACLIENTE Y  (NOLOCK)  ON Y.HANDLE = X.CLIENTE
                                                                            WHERE Y.PESSOA = A.CLIENTE) or A.UNIDADENEGOCIOCLIENTE IS NULL)";
                $bFiltro = true;
            } else {
                $vFiltroUnidadeNegocio = Sistema::getFiltroPostLookupArray("unidadenegocio", "A.UNIDADENEGOCIOCLIENTE");
            }

            if (Sistema::getFiltroPostTexto("filtroDocumento", "Y.NUMERO") == '') {
                $vFitroDocumento = "";
            } else {
                $vFitroDocumento = " AND EXISTS (SELECT 1 
                                                    FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                                INNER JOIN GD_ORIGINARIO Y  (NOLOCK)  ON Y.HANDLE = X.HANDLEORIGEM
                                                WHERE X.PEDIDO = A.HANDLE 
                                                    AND X.ORIGEM = 1890
                                                " . Sistema::getFiltroPostTexto("filtroDocumento", "Y.NUMERO") ."
                                                
                                                UNION ALL

                                                SELECT 1 
                                                    FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                                INNER JOIN GD_DOCUMENTO Y  (NOLOCK)  ON Y.DOCUMENTOTRANSPORTE = X.HANDLEORIGEM
                                                INNER JOIN GD_DOCUMENTOORIGINARIO Y1 (NOLOCK)  ON Y1.DOCUMENTO = Y.HANDLE
                                                INNER JOIN GD_ORIGINARIO Y2 (NOLOCK)  ON Y2.HANDLE = Y1.ORIGINARIO
                                                WHERE X.PEDIDO = A.HANDLE 
                                                    AND X.ORIGEM = 2042 " . Sistema::getFiltroPostTexto("filtroDocumento", "Y2.NUMERO") . ")";                                     
                $bFiltro = true;                                     
            }

            if (Sistema::getFiltroPostTexto("filtroCte", "Y.NUMERO") == '') {
                $vFiltroCte = "";
            } else {
                $vFiltroCte = " AND EXISTS (SELECT 1 
                                            FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                            INNER JOIN GD_DOCUMENTO Y (NOLOCK)  ON Y.DOCUMENTOTRANSPORTE = X.HANDLEORIGEM
                                            WHERE X.PEDIDO = A.HANDLE 
                                            AND X.ORIGEM = 2042
                                        " . Sistema::getFiltroPostTexto("filtroCte", "Y.NUMERO") . ")";
                $bFiltro = true;                                     
            }

            if ($_POST["filtroObservacao"] == '') {
                $vFiltroDocumentoObservacao = "";
            } else {
                $vFiltroDocumentoObservacao = " 
                                                AND EXISTS (SELECT 1 
                                                            FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                                            INNER JOIN GD_ORIGINARIO Y (NOLOCK)  ON Y.HANDLE = X.HANDLEORIGEM
                                                            WHERE X.PEDIDO = A.HANDLE 
                                                            AND X.ORIGEM = 1890
                                                        " . Sistema::getFiltroPostLike("filtroObservacao", "Y.OBSERVACAO") . ")";
                $bFiltro = true;                                     
            }

            if (Sistema::getPost('filtroTransporteProprio') <> 'S') {
                $vFiltroTransporteProprio = '';
            } else { $vFiltroTransporteProprio = "AND A.TRANSPORTADORA IN (SELECT X.PESSOA
                                                                            FROM MS_FILIAL X (NOLOCK) 
                                                                            WHERE X.EMPRESA = A.EMPRESA
                                                                            AND X.STATUS = 4)"; 
                $bFiltro = true;
            }       

            if ((sistema::getFiltroPostTexto("filtroTransportadora", "A.TRANSPORTADORA") == '') || (Sistema::getPost('filtroTransporteProprio') == 'S')) {
                $vFiltroTransportadora = "";
            } else {
                # Só irá retornar registro se a Transportadora estiver ativa ou se o Transporte próprio não estiver marcado.
            $vFiltroTransportadora = " AND A.TRANSPORTADORA IN (SELECT X.HANDLE
                                                                    FROM MS_PESSOA X (NOLOCK) 
                                                                    WHERE X.STATUS = 4
                                                                    " . Sistema::getFiltroPostLike("filtroTransportadora", "X.APELIDO") .")";
            }

            if (Sistema::getPost('filtroEmTransporte') <> 'S') {
                $vFiltroEmTransporte = "";
            } else {
                $vFiltroEmTransporte = "AND M.DATAEMISSAO <> 0";
            }

            foreach($_POST as $key => $value) {
                if (($value <> "") && ($key <> "pendente") && ($key <> "ehpendente")) {
                    $bFiltro = true;
                    break;
                }
            }

            if (Sistema::getPost('filtroPendente') == '') {
                $vFiltroPendente = '';

            } else {
                $vFiltroPendente = $_POST["filtroPendente"];
            }

            if ($_POST['filtroDocumento'] == '') {
                $vFiltroDocumento = "";
            } else {
                $vFiltroDocumento = " AND EXISTS (SELECT 1 
                                                    FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                                INNER JOIN GD_ORIGINARIO Y (NOLOCK) ON Y.HANDLE = X.HANDLEORIGEM
                                                WHERE X.PEDIDO = A.HANDLE 
                                                    AND X.ORIGEM = 1890
                                                " . Sistema::getFiltroGetTexto("documento", "Y.NUMERO") ."
                                                
                                                UNION ALL

                                                SELECT 1 
                                                    FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                                INNER JOIN GD_DOCUMENTO Y (NOLOCK) ON Y.DOCUMENTOTRANSPORTE = X.HANDLEORIGEM
                                                INNER JOIN GD_DOCUMENTOORIGINARIO Y1 (NOLOCK) ON Y1.DOCUMENTO = Y.HANDLE
                                                INNER JOIN GD_ORIGINARIO Y2 (NOLOCK) ON Y2.HANDLE = Y1.ORIGINARIO
                                                WHERE X.PEDIDO = A.HANDLE 
                                                    AND X.ORIGEM = 2042 " . Sistema::getFiltroGetTexto("filtroDocumento", "Y2.NUMERO") . ")";                                     
                $bFiltro = true;                                     
            } 

            if (Sistema::getPost('filtroCliente') == '') {
                $vFiltroCliente = '';

            } else {
                $vFiltroCliente = Sistema::getFiltroPostLookupArray('filtroCliente', 'A.CLIENTE');
            };

            $queryCampos = "A.RASTREAMENTO RASTREAMENTO,
                            A.DATA DATA,
                            E.NOME STATUSNOME,
                            J.NOME TIPO,
                            A.NUMEROPEDIDO NUMEROPEDIDO,
                            A.NUMEROCONTROLE NUMEROCONTROLE,
                            A.DOCUMENTOORIGINARIO NUMERONOTAFISCAL,                
                            CASE WHEN A.VALORMERCADORIA > 0 THEN A.VALORMERCADORIA ELSE L.VALORMERCADORIA END VALORMERCADORIA,
                            M.NUMERO DOCUMENTOTRANSPORTE,
                            CONVERT(VARCHAR(10), M.DATAEMISSAO, 103) EMISSAODOCUMENTO,
                            L.PESO PESOREALDOCUMENTO,
                            L.PESOCUBADO PESOCUBADODOCUMENTO,
                            COALESCE(L.QUANTIDADEVOLUME, 0) QTDVOLUMEDOCUMENTO,
                            CONVERT(VARCHAR(10), A.DATAENTREGA, 103) DATAENTREGA,
                            M.VALORBRUTO VALORFRETE,
                            CONVERT(VARCHAR(10), L.PREVISAOENTREGA, 103) PREVISAOENTREGADOCUMENTO,
                            A.NOMEREMETENTE REMETENTE,
                            A.MUNICIPIOLOCALCOLETA MUNICIPIOCOLETA,
                            A.UFLOCALCOLETA ESTADOCOLETA,                
                            A.NOMEDESTINATARIO DESTINATARIO,               
                            A.MUNICIPIOLOCALENTREGA MUNICIPIOENTREGA,
                            A.UFLOCALENTREGA ESTADOENTREGA,                
                            N.TITULO ETAPAATUAL,
                            N.DATA ETAPADATA,
                            H.TITULO ETAPAEXECUCAO,
                            G.APELIDO CLIENTE
                            ";

            $queryFrom = "
                        FROM MD_SISTEMA ZZZZZ (NOLOCK)
                        INNER JOIN RA_PEDIDO A (NOLOCK) ON A.EMPRESA = $empresa 
                        LEFT JOIN MS_USUARIO D (NOLOCK) ON A.LOGUSUARIOCADASTRO = D.HANDLE
                        LEFT JOIN RA_STATUSPEDIDO E (NOLOCK) ON E.HANDLE = A.STATUS
                        LEFT JOIN MD_IMAGEM F (NOLOCK) ON F.HANDLE = E.IMAGEM
                        LEFT JOIN MS_PESSOA G (NOLOCK) ON G.HANDLE = A.CLIENTE                           
                        LEFT JOIN RA_PEDIDOETAPA H (NOLOCK) ON H.HANDLE = A.ETAPAATUAL
                        LEFT JOIN RA_TIPOETAPA I (NOLOCK) ON I.HANDLE = H.ETAPA
                        INNER JOIN RA_TIPOPEDIDO J (NOLOCK) ON J.HANDLE = A.TIPO
                        LEFT JOIN RA_PEDIDOMOVIMENTACAO K (NOLOCK) ON K.HANDLE = (SELECT MAX(X.HANDLE)
                                                                            FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK)                                                                             
                                                                            WHERE X.PEDIDO = A.HANDLE
                                                                            AND X.ORIGEM = 2042)                                                                                                                                                           
                        LEFT JOIN GD_DOCUMENTOTRANSPORTE L (NOLOCK) ON L.HANDLE = K.HANDLEORIGEM
                        LEFT JOIN GD_DOCUMENTO M (NOLOCK) ON M.HANDLE = L.DOCUMENTO
                        AND M.EHCANCELADO <> 'S'
                        AND M.EHCOMPLEMENTAR <> 'S' ";
                        
            $etapaAtualFrom = " LEFT JOIN RA_PEDIDOETAPA N (NOLOCK)  ON N.PEDIDO = A.HANDLE AND N.STATUS = 9 AND NOT EXISTS(SELECT Y.HANDLE 
                                                                                            FROM RA_PEDIDOETAPA Y (NOLOCK) 
                                                                                            WHERE Y.HANDLE > N.HANDLE
                                                                                            AND Y.PEDIDO = A.HANDLE
                                                                                            AND Y.STATUS = 9) ";

            $queryOrderBy = "ORDER BY A.HANDLE DESC";

            $queryPedido = "WITH ORDENS AS
                    ( SELECT ROW_NUMBER() OVER ($queryOrderBy) SEQ, "
                            . $queryCampos
                            . $queryFrom
                            . $etapaAtualFrom
                            . $vFromPessoaUsuario
                            
                            . " WHERE 1 = 1 " 
                            
                            . $vfiltroPessoaUsuario
                            . Sistema::getFiltroPostTexto("filtroNumeroPedido", "A.NUMEROPEDIDO ")  
                            . Sistema::getFiltroPostTexto("filtroRastreamento", "A.RASTREAMENTO ")  
                            . Sistema::getFiltroPostEntreData("filtroDataInicio", "filtroDataFinal", "A.DATA ")  
                            . Sistema::getFiltroPostLookupArray("filtroFilial", "A.FILIAL ") 
                            . Sistema::getFiltroPostLookupArray("filtroTipoPedido", "A.TIPO ") 
                            . Sistema::getFiltroPostLookupArray("filtroSituacao", "I.HANDLE ")  
                            . Sistema::getFiltroPostTexto("filtroRemetente", "A.NOMEREMETENTE ")  
                            . Sistema::getFiltroPostTexto("filtroDestinatario", "A.NOMEDESTINATARIO ") 
                            . Sistema::getFiltroPostTexto("filtroNumeroControle", "A.NUMEROCONTROLE ")  
                            . Sistema::getFiltroPostLookupArray("filtroCliente", "A.CLIENTE ")  
                            . $vFiltroUnidadeNegocio
                            . $vFiltroPendente
                            . $vFiltroDocumento
                            . $vFiltroDocumentoObservacao
                            . $vFiltroTransportadora 
                            . $vFiltroTransporteProprio 
                            . $vFiltroEmTransporte 
                            . $vFiltroCte   .")
                            SELECT * FROM ORDENS A ";

            $queryOrder = $this->connect->prepare($queryPedido);
            $queryOrder -> execute();

            $dadosPedido = [];

            while($dados = $queryOrder->fetch(PDO::FETCH_ASSOC)){
                $linha = [];
                $linha["RASTREAMENTO"]             = Sistema::formataTexto($dados["RASTREAMENTO"]);
                $linha["EMISSAODOCUMENTO"]         = $dados["EMISSAODOCUMENTO"];
                $linha["TIPO"]                     = Sistema::formataTexto($dados["TIPO"]);    
                $linha["DOCUMENTOTRANSPORTE"]      = Sistema::formataTexto($dados["DOCUMENTOTRANSPORTE"]);  
                $linha["NUMERONOTAFISCAL"]         = Sistema::formataTexto($dados["NUMERONOTAFISCAL"]);
                $linha["DESTINATARIO"]             = $dados["DESTINATARIO"];
                $linha["MUNICIPIOENTREGA"]         = $dados["MUNICIPIOENTREGA"];
                $linha["ESTADOENTREGA"]            = $dados["ESTADOENTREGA"];
                $linha["VALORMERCADORIA"]          = Sistema::formataValor($dados["VALORMERCADORIA"]);
                $linha["PESOREALDOCUMENTO"]        = Sistema::formataValor($dados["PESOREALDOCUMENTO"]);
                $linha["PESOCUBADODOCUMENTO"]      = Sistema::formataValor($dados["PESOCUBADODOCUMENTO"]);
                $linha["QTDVOLUMEDOCUMENTO"]       = $dados["QTDVOLUMEDOCUMENTO"];
                $linha["ETAPADATA"]                = $dados["ETAPADATA"];
                $linha["ETAPAATUAL"]               = $dados["ETAPAATUAL"];
                $linha["ETAPAEXECUCAO"]            = $dados["ETAPAEXECUCAO"];
                $linha["PREVISAOENTREGADOCUMENTO"] = $dados["PREVISAOENTREGADOCUMENTO"];
                $linha["DATAENTREGA"]              = $dados["DATAENTREGA"];
                $linha["REMETENTE"]                = $dados["REMETENTE"];
                $linha["MUNICIPIOCOLETA"]          = $dados["MUNICIPIOCOLETA"];
                $linha["ESTADOCOLETA"]             = $dados["ESTADOCOLETA"];
                $linha["NUMEROPEDIDO"]             = Sistema::formataTexto($dados["NUMEROPEDIDO"]);
                $linha["NUMEROCONTROLE"]           = Sistema::formataTexto($dados["NUMEROCONTROLE"]);  

                $dadosPedido[] = $linha;
            };

            echo json_encode($dadosPedido);
        }
    }

?>