<script>
    var caminhoLogon = "logon/logon.control.php";    
       
    function verificarLogonxyz(){
        //Validando se tem algo escrito no login e na senha para continuar o login
        if (Number($("#login").val().length) > 0 && Number($("#senha").val().length) > 0) {
            enviar_formulario_logon();
        } else {
            msgNoty("Informe login & senha!", "warning", "", 8000);
        }
    }

    function enviar_formulario_logon() {
        var login = $("#login").val().toLowerCase();
        var senha = $("#senha").val();
        var unidade = $("#unidade_logada").val();
        $.post(caminhoLogon, {op: 'submit_form',element:'frm_logon',login:login,senha:senha}, function(dados, textStatus, xhr) {
            var data = JSON.parse(dados);
                if (data.retorno == "success") {
                    $('#modalLogon').modal("hide");
                } else if (data.retorno == "user-warning") {
                    msgNoty("Entre em contato com a quality.<br> Em breve sua conta será bloqueada.", "warning", "", 8000);
                    //unidadeLogon(data);
                } else if (data.retorno == "no-access") {
                    msgNoty("Você esta sem acesso ao sistema. Entre em contato com o R.H. de sua empresa!", "warnong", "", 8000);
                } else if (data.retorno == "no-company") {
                    msgNoty("Sua empresa nao consta mais em nosso sistema!", "error", "", 8000);
                } else if (data.retorno == "no-user") {
                    msgNoty("Usuario ou senha invalidos!", "warning", "", 8000);
                }
        });
        $.post(caminhoLogon, {op: 'POST',element:'cbx_unidade',ide:unidade}, function(dados, textStatus, xhr) {});

    }
</script>