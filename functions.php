<?php

require('models/perfil.php');
require('models/guia.php');
require_once('config-db.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

function enviaremail($destinatario, $assunto, $mensagem){
    
    $email_envio = "paluana@filipelopes.me";
    $email_ad = "paluana@filipelopes.me";
    $Subject = $assunto;
    $Message = $mensagem;

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    // inicia a classe PHPMailer habilitando o disparo de exceções
    $mail = new PHPMailer(true);
    try
    {
        // habilita o debug
        // 0 = Sem mensagens de debug
        // 1 = mensagens do cliente SMTP
        // 2 = mensagens do cliente e do servidor SMTP
        // 3 = igual o 2, incluindo detalhes da conexão
        // 4 = igual o 3, inlcuindo mensagens de debug baixo-nível
        $mail->SMTPDebug = 0;

        // utilizar SMTP
        $mail->isSMTP();

        // habilita autenticação SMTP
        $mail->SMTPAuth = true;

        // servidor SMTP
        $mail->Host = 'mail.filipelopes.me';

        // usuário, senha e porta do SMTP
        $mail->Username = 'paluana@filipelopes.me';
        $mail->Password = 'senha';
        $mail->Port = 465;

        // tipo de criptografia: "tls" ou "ssl"
        $mail->SMTPSecure = 'ssl';

        // email e nome do remetente
        $mail->setFrom($email_ad, 'Qualité Ortodontia');

        // Email e nome do(s) destinatário(s)
        // você pode chamar addAddress quantas vezes quiser, para
        // incluir diversos destinatários
        $mail->addAddress($destinatario, 'Destinatário');

        // endereço que receberá as respostas
        $mail->addReplyTo($email_ad, 'AD');

        // com cópia (CC) e com cópia oculta (BCC)
        //$mail->addCC('copia@site.com');
        //$mail->addBCC('copia_oculta@site.com');

        // anexa um arquivo
        //$mail->addAttachment('composer.json');

        // define o formato como HTML
        $mail->isHTML(true);

        // codificação UTF-8
        $mail->CharSet = 'UTF-8';

        // assunto do email
        $mail->Subject = $Subject;

        // corpo do email em HTML
        $mail->Body    =  $Message;

        // corpo do email em texto
        $mail->AltBody = 'Mensagem em HTML não bem sucedida';

        // envia o email
        $mail->send();

        //echo 'Mensagem enviada com sucesso!' . PHP_EOL;
    }
    catch (Exception $e)
    {
        // echo 'Falha ao enviar email.' . PHP_EOL;
        // echo 'Erro: ' . $mail->ErrorInfo . PHP_EOL;
    }
    
}

/**
* Função para gerar senhas aleatórias
*
* @author    Thiago Belem <contato@thiagobelem.net>
*
* @param integer $tamanho Tamanho da senha a ser gerada
* @param boolean $maiusculas Se terá letras maiúsculas
* @param boolean $numeros Se terá números
* @param boolean $simbolos Se terá símbolos
*
* @return string A senha gerada
*/

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = true){
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $retorno = '';
    $caracteres = '';
    $caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros) $caracteres .= $num;
    if ($simbolos) $caracteres .= $simb;
    $len = strlen($caracteres);
    
    for ($n = 1; $n <= $tamanho; $n++) {
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand-1];
    }
    
    return $retorno;
}

function geraNum($digits){
    return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
}

function permissao($item) {
    global $mydb;

    $permissao = false;

    $pesquisausuario = $mydb->query("SELECT * FROM  usuarios WHERE id = ".$_SESSION["id_usuario"]);

    if($pesquisausuario->num_rows > 0){

        while ($row = $pesquisausuario->fetch_assoc()) {
            $permissoes = json_decode($row["permissoes"]);
        }
    }

    $permissao = isset($permissoes->$item) ? $permissoes->$item : false;

    return $permissao;
}

function get_info_perfil($id, $info) {
    global $mydb;

    if($id != NULL){
        $pesquisainfo = $mydb->query("SELECT * FROM perfis WHERE usuario = ".$id);

        if($pesquisainfo->num_rows > 0){
            while ($row = $pesquisainfo->fetch_assoc()) {
                return $row[$info];
            }
        }else{
            return null;
        }
    }else{
        return null;
    }
}

function get_atendimento($id) {
    global $mydb;

    if($id != NULL){
        $pesquisaatendimento = $mydb->query("SELECT * FROM atendimentos WHERE id = ".$id);

        if($pesquisaatendimento->num_rows > 0){
            while ($row = $pesquisaatendimento->fetch_assoc()) {
                return array( $row["atendimento"], $row["participacao"] );
            }
        }else{
            return null;
        }
    }else{
        return null;
    }
}

function get_convenio($id) {
    global $mydb;

    if($id != NULL){
        $pesquisaconvenios = $mydb->query("SELECT * FROM convenios WHERE id = ".$id);

        if($pesquisaconvenios->num_rows > 0){
            while ($row = $pesquisaconvenios->fetch_assoc()) {
                return $row["convenio"];
            }
        }else{
            return null;
        }
    }else{
        return null;
    }
}

function get_object_perfil($id) { //idusuario
    global $mydb;

    if($id != NULL){
        $pesquisainfo = $mydb->query("SELECT * FROM perfis WHERE usuario = ".$id);

        if($pesquisainfo->num_rows > 0){
            while ($row = $pesquisainfo->fetch_assoc()) {
                return new Perfil(
                    $row["id"],
                    $row["usuario"],
                    $row["nome"],
                    $row["funcao"],
                    $row["cpf"],
                    $row["email"],
                    $row["celular"],
                    $row["cep"],
                    $row["rua"],
                    $row["numero"],
                    $row["complemento"],
                    $row["bairro"],
                    $row["cidade"],
                    $row["estado"],
                    $row["cro"],
                    $row["especialidade"]
                );
            }
        }else{
            return null;
        }
    }else{
        return null;
    }
}

function get_object_guia($id) {
    global $mydb;
    return true;
}

function checkEmail($email) {
    global $mydb;

    $pesquisausuario = $mydb->query("SELECT * FROM usuarios WHERE email = '$email' ");
    return $pesquisausuario->num_rows > 0;
}

function checkGuia($numero) {
    global $mydb;

    $pesquisaguia = $mydb->query("SELECT * FROM guias WHERE numero = '$numero' ");
    return $pesquisaguia->num_rows > 0;
}

function checkPaciente($nome) {
    global $mydb;

    $pesquisapaciente = $mydb->query("SELECT * FROM pacientes WHERE nome = '$nome' ");
    return $pesquisapaciente->num_rows > 0;
}

function checkConvenio($nome) {
    global $mydb;

    $pesquisaconvenios = $mydb->query("SELECT * FROM convenios WHERE convenio = '$nome' ");
    return $pesquisaconvenios->num_rows > 0;
}

function isFuncao($id, $funcao) {
    global $mydb;

    $pesquisaperfil = $mydb->query("SELECT * FROM perfis WHERE usuario = $id ");

    while($row = $pesquisaperfil->fetch_assoc()){
        return $row["funcao"] == $funcao;
    }
}

function num_clientes($especialidade) {
    global $mydb;

    $pesquisaclientes = $mydb->query("SELECT * FROM especialidades WHERE id = $especialidade");

    return $pesquisaclientes->num_rows;
}

function num_dentistas(){
    global $mydb;

    $pesquisadentistas = $mydb->query("SELECT * FROM perfis WHERE funcao = 'dentista' ");
    $num_naovalidados = 0;

    while($row = $pesquisadentistas->fetch_assoc()){
        $usuario_id = $row["usuario"];
        $pesquisavalidacao = $mydb->query("SELECT * FROM usuarios WHERE id = $usuario_id AND validacao = 0 AND b_del=0");
        if($pesquisavalidacao->num_rows){
            $num_naovalidados++;
        }
    }

    return array($pesquisadentistas->num_rows, $num_naovalidados);
}

function converter_year_month($str){
    $meses = array(
        "", "Janeiro",
        "Fevereiro",
        "Março",
        "Março",
        "Maio",
        "Junho",
        "Julho",
        "Agosto",
        "Setembro",
        "Outubro",
        "Novembro",
        "Dezembro"
    );

    $visivel = $meses[substr($str, 4, 2)]." de ".substr($str, 0, 4);
    $formatado = substr($str, 0, 4)."-".substr($str, 4, 2);
    return [$visivel, $formatado];
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

function cut($string, $num){
    return substr($string, 0, $num);
}

function highlight($query, $string){
    $newstring = "<span class='highlight'>".$query."</span>";
    $string = str_ireplace($query, $newstring, $string);
    return $string;
}

function configuracoes($chave, $n_valores){
    global $mydb;
    
     $pesquisaconf = $mydb->query("SELECT * FROM  configuracoes WHERE chave = '$chave'");
                                
    if($pesquisaconf->num_rows > 0){


        while ($row = $pesquisaconf->fetch_assoc()) {

            return $row["valor1"];

        }

    }else{
        return "Configuração não encontrada";
    }
}

?>