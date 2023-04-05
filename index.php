<?php
require (__DIR__ . '../XLSXReader.php');

class CRUDEscola {
    
    public function __construct() {

    }
    public function montar(){
        $xlsx = new XLSXReader('archive.xlsx');
        $this->corpo();    
    }

    public function corpo() { 
        if(empty($_REQUEST['acao'])) echo "<div><a href='home.php' class='voltar'>Voltar para a tela inicial</a></div><br/>";
        
        if($_REQUEST['acao'] == 'importar'){
            $this->importar($_FILES['arquivo']);
        }
        else{
            $this->importar();
        }
    }
    public function importar($file){
        //formulario
        echo "<form action='index.php' method='POST' enctype='multipart/form-data'>";
        echo "<input type='hidden' name='acao' value='importar' />";
        echo "<p>O arquivo CSV, separado por ; (ponto-e-virgula), a ser enviado deve ter exatamente e na mesma ordem como cabeçalho os seguintes dados:<br/>
            <font size='2'><i>Restrição de Atendimento;Escola;Código INEP;UF;Município;Localização;Localidade Diferenciada;Categoria Administrativa;Endereço;Telefone;Dependência Administrativa;Categoria Escola Privada;Conveniada Poder Público;Regulamentação pelo Conselho de Educação;Porte da Escola;Etapas e Modalidade de Ensino Oferecidas;Outras Ofertas Educacionais;Latitude;Longitude</i></font><br/>
            Exemplo:<br/><font size='1'>
            Restrição de Atendimento;Escola;Código INEP;UF;Município;Localização;Localidade Diferenciada;Categoria Administrativa;Endereço;Telefone;Dependência Administrativa;Categoria Escola Privada;Conveniada Poder Público;Regulamentação pelo Conselho de Educação;Porte da Escola;Etapas e Modalidade de Ensino Oferecidas;Outras Ofertas Educacionais;Latitude;Longitude<br/>
            ESCOLA ATENDE EXCLUSIVAMENTE ALUNOS COM DEFICIÊNCIA;EEEE ABNAEL MACHADO DE LIMA - CENE;11000023;RO;Porto Velho;Urbana;A escola não está em área de localização diferenciada;Pública;AVENIDA AMAZONAS, 6492 ZONA LESTE. TIRADENTES. 76824-556 Porto Velho - RO.;(69) 992083054;Estadual;Não Informado;Não;Não;Entre 51 e 200 matrículas de escolarização;Ensino Fundamental;Atendimento Educacional Especializado;-8.758459;-63.8540109
            ESCOLA EM FUNCIONAMENTO E SEM RESTRIÇÃO DE ATENDIMENTO;EMEIEF PEQUENOS TALENTOS;11000040;RO;Porto Velho;Urbana;A escola não está em área de localização diferenciada;Pública;RUA CAETANO, 3256 PREDIO. CALADINHO. 76808-108 Porto Velho - RO.;(69) 32135237;Municipal;Não Informado;Não;Sim;Entre 201 e 500 matrículas de escolarização;Educação Infantil;;-8.79373016;-63.88391863
            ESCOLA EM FUNCIONAMENTO E SEM RESTRIÇÃO DE ATENDIMENTO;CENTRO DE ENSINO CLASSE A;11000058;RO;Porto Velho;Urbana;A escola não está em área de localização diferenciada;Privada;AVENIDA CARLOS GOMES, 1135 CENTRO. 76801-123 Porto Velho - RO.;(69) 32244473;Privada;Particular;Não;Sim;Mais de 1000 matrículas de escolarização;Educação Infantil, Ensino Fundamental, Ensino Médio;;-8.7607343;-63.9019859
            </font></p>";
        echo "<b>Arquivo CSV:</b><input type='file' name='arquivo' required accept='.xlsx' />";
        echo "<input type='submit' value='Processar Importação do Arquivo' />";
        echo "</form>";
        
        //processamento do arquivo
        if(!empty($file['tmp_name'])){
            

            
            $linhas = file($file['tmp_name']);
            //cabecalho
            $cabecalho = $linhas[0];
            unset($linhas[0]);
            
            $separadordadosarquivo = ',';
            $i = $erros = 0;
            foreach($linhas as $linha){
                //cada linha: 
                //0=>restricaoatendimento;
                //1=>nome;
                //2=>codigoinep;
                //3=>uf;
                //...
                $dados = explode($separadordadosarquivo, $linha);
                if(!empty($dados[1])){
                    echo $linha;
                }
            }
            
            echo "<br/><hr/><br/>";
            echo "Processados $i escolas.<br/>";
            if(!empty($erros)){
                echo "Total de erros: $erros<br/>";
                foreach($_SESSION[erros] as $erro){
                    echo "$erro<br/>";
                }
                unset($_SESSION[erros]);
            }

            echo "<script type='text/javascript'>window.opener.location.reload();</script>";
        
        echo "<br/>";
        echo "<div align='center'>";
        echo "<input type='button' name='fechar' value='Fechar' onclick=\"window.close();\" class='' />";
        echo "</div>";
        }
    }
}

$pagina = new CRUDEscola();
$pagina->montar();
