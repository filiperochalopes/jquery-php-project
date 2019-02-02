<?php

// require('models/perfil.php');
// require('models/guia.php');
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

function checkPaciente($nome) {
    global $mydb;

    $pesquisapaciente = $mydb->query("SELECT * FROM pacientes WHERE nome = '$nome' ");
    return $pesquisapaciente->num_rows > 0;
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

?>