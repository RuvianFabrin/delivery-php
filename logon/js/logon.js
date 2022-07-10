    var caminho = "logon/logon.control.php";
    var caminhoe = "logon/e.php";
    $(document).ready(function() {
        inicilization();
    });
    $(document).keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            //alert('You pressed a "enter" key in somewhere');    
            $('#btn_logon').click();
        }
    });

    function inicilization() {
        submit_form();
        
        $(document).on("click", "#btn_logon", function() {
            //Validando se tem algo escrito no login e na senha para continuar o login
            if (Number($("#login").val().length) > 0 && Number($("#senha").val().length) > 0) {
                $('#frm_logon').submit();
            } else {
                msgNoty("Informe login & senha!", "warning", "", 8000);
            }
        });
    }

    function submit_form() {
        $('#frm_logon').form({
            url: caminhoe,
            ajax: 'true',
            iframe: false,
            onSubmit: function(param) {
                param.op = 'g';
                param.action = 'frm_logon';
            },
            success: function(dados) {
                var data = JSON.parse(dados);
                if (data.retorno == "success") {
                    logon_sistem();
                    //unidadeLogon(data);
                } else if (data.retorno == "user-warning") {
                    msgNoty("Entre em contato com o administrador.<br> Em breve sua conta será bloqueada.", "warning", "", 8000);
                    //unidadeLogon(data);
                    
                } else if (data.retorno == "no-access") {
                    msgNoty("Você esta sem acesso ao sistema. Entre em contato com o R.H. de sua empresa!", "warnong", "", 8000);
                } else if (data.retorno == "no-company") {
                    msgNoty("Sua empresa nao consta mais em nosso sistema!", "error", "", 8000);
                } else if (data.retorno == "no-user") {
                    msgNoty("Usuario ou senha invalidos!", "warning", "", 8000);
                }
            }
        });
    }

    function logon_sistem() {
        window.location.href = $('#server').val();
        console.log($('#server').val());
        /*console.log(window.history.back())*/
    }

    function unidadeLogon(data) {
        //abrir uma janela para perguntar a unidade que quer logar
        if(data.solicita_unidade=="1"){
            $('#cbx_unidade').combobox({
                url: caminho + '?op=COMBOBOX&element=cbx_unidade&ide='+data.ide
            });
           $('#window_unidade').window('open');
        }else{
            logon_sistem();
        }
        
    }
    function btn_logarComUnidade(){
        var idEmp =  $('#cbx_unidade').combobox("getValue");
        $.post(caminho+ '?op=POST&element=cbx_unidade&ide='+idEmp,function(e){
            logon_sistem();
        });
    }
    
