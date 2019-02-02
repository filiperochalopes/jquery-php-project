<?php

require ("functions.php");
require ("config-db.php");

include "parts/structure/head.php";
?>
<body>
    
    <?php
    include "parts/structure/body.php";
    include "parts/structure/header.php";
    include "parts/structure/nav.php";

    $idusuario = $_SESSION["id_usuario"];

    $perfil = get_object_perfil($idusuario);
    if($perfil){
        console_log($perfil);
    }
    ?>
    
<div class="page">    
    <div class="container-fluid">
        <div class="row">
            <?php
            include "parts/structure/aside.php";
            ?>
            <div class="col-sm-10 col-md-9 pt-5">
                <div class="container">
                <h1 class="pageTitle">Perfil</h1>
                <section>
                    <header class="row">
                        <h2 class="col-12 pageSubtitle"><span class="oi oi-person"></span> Edite seus dados</h2>
                    </header>
                    <section id="form-perfil" class="row">
                        <fieldset class="col-md-6 col-lg-4 mb-5">
                        <div class="container">
                            <input type="text" id="nome" name="nome" class="form-control top" placeholder="Nome" data-id="<?=$perfil->id?>" data-col="nome" value="<?=$perfil->nome?>"/>
                            <input type="text" id="cpf" name="cpf" class="cpf form-control middle" placeholder="CPF" data-id="<?=$perfil->id?>" data-col="cpf" value="<?=$perfil->cpf?>" />
                            <input type="email" id="email" name="email" class="form-control middle" placeholder="Email" data-id="<?=$perfil->id?>" data-col="email" value="<?=$perfil->email?>" />
                            <input type="text" id="celular" name="celular" class="celular form-control bottom mb-4" placeholder="Celular" data-id="<?=$perfil->id?>" data-col="celular" value="<?=$perfil->celular?>"/>
                        </div>
                        </fieldset>
                        <fieldset class="col-md-6 col-lg-4">
                        <div class="container">
                            <input type="text" id="cep" name="cep" class="form-control top" placeholder="CEP" data-id="<?=$perfil->id?>" data-col="cep" value="<?=$perfil->cep?>" />
                            <input type="text" id="auto_rua" name="rua" class="form-control middle" placeholder="Rua" data-id="<?=$perfil->id?>" data-col="rua" value="<?=$perfil->rua?>" />
                            <input type="number" id="numero" name="numero" class="form-control middle" placeholder="Número" data-id="<?=$perfil->id?>" data-col="numero" value="<?=$perfil->numero?>" />
                            <input type="text" id="complemento" name="complemento" class="form-control middle" placeholder="Complemento" data-id="<?=$perfil->id?>" data-col="complemento" value="<?=$perfil->complemento?>"/>
                            <input type="text" id="auto_bairro" name="bairro" class="form-control middle" placeholder="Bairro" data-id="<?=$perfil->id?>" data-col="bairro" value="<?=$perfil->bairro?>" />
                            <input type="text" id="auto_cidade" name="cidade" class="form-control middle" placeholder="Cidade" data-id="<?=$perfil->id?>" data-col="cidade" value="<?=$perfil->cidade?>" />
                            <input type="text" id="auto_estado" name="estado" class="form-control bottom mb-4" placeholder="Estado" data-id="<?=$perfil->id?>" data-col="estado" value="<?=$perfil->estado?>" />
                            <button type="button" class="btn btn-block btn-primary mt-3">Alterar</button>
                        </div>
                        </fieldset>
                        <?php
                        if($perfil->funcao == "dentista"){
                        ?>
                        <fieldset class="col-md-6 col-lg-4 mb-5">
                            <input type="number" id="cro" name="cro" class="form-control top" placeholder="CRO" data-id="<?=$perfil->id?>" data-col="cro" value="<?=$perfil->cro?>" disabled/>
                            <input type="text" id="especialidade" name="especialidade" class="form-control mb-4" class="bottom" placeholder="Especialidade" data-id="<?=$perfil->id?>" data-col="especialidade" value="<?=$perfil->especialidade?>" disabled/>
                        </fieldset>
                        <?php
                        }
                        ?>
                    </section>
                </section>
        </div>
        <?php
        include "parts/structure/footer.php";
        ?>        
                </div>
            </div>
        </div>            
    </div>        
</div>
</body>