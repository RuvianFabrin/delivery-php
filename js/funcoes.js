function msgNoty(msg = "", type = "", layout = "", timeout = "", validation = "default") {
    msg = (msg == "") ? 'Sucesso' : msg;
    type = (type == "") ? 'info' : type;
    //Types: alert, success, warning, error, info/information
    layout = (layout == "") ? 'topCenter' : layout;
    //Layouts: top, topLeft, topCenter, topRight, center, centerLeft, centerRight, bottom, bottomLeft, bottomCenter, bottomRight
    timeout = (timeout == 0) ? 8000 : timeout;
    if (validation == "non_op"){
        msg = "A operação nao foi encontrada";
        type = "warning";
    }
    else if (validation == "non_session"){
        msg = "Sessão expirada! faça login novamente.";
        type = "error";
        timeout = "16000";
    }
    var n = noty({
        text: msg,
        type: type,
        layout: layout,
        timeout: timeout,
        theme: 'relax',
        animation: {
            open: {height: 'toggle'},
            close: {height: 'toggle'},
            easing: 'swing',
            speed: 500
        }/*,
        buttons: [
            {addClass: 'btn btn-primary', text: 'Salvar', onClick: function($n) {
                $n.close();
                noty({
                    text: 'Salvo com sucesso!',
                    type: 'success',
                    layout: 'bottomRight',
                    timeout: 1000,
                });
            }},
            {addClass: 'btn btn-danger', text: 'Cancelar', onClick: function($n) {
                $n.close();
            }}
        ]*/
    });
}