
var btnAdd = document.querySelector('#image-add-diaria');
    
var retorno_adcional = document.querySelector('#retorno_adicional');

var cont = 0;

$('#image-add-diaria').on('click', function() {
    var datas_retorno = [];
    cont ++;

    // ######### data de retorno adcional ###########
    if(cont <= 5) {
        // criacao de espacamento
        var br2 = document.createElement('br');

        // criacao de um label
        var data_retorno_label = document.createElement('label');

        // atributo do label
        data_retorno_label.setAttribute('for', 'data_retorno');

        // node do label
        var node_label = document.createTextNode('Data de Retorno');

        // acresentando o node no label
        data_retorno_label.appendChild(node_label);
        
        retorno_adicional.appendChild(data_retorno_label);

        var data_retorno_input = document.createElement('input');
        data_retorno_input.setAttribute('type', 'datetime-local');
        data_retorno_input.setAttribute('name', 'data_retorno'+cont);
        data_retorno_input.setAttribute('class', 'form-control');

        retorno_adicional.appendChild(data_retorno_input);
        retorno_adicional.appendChild(br2);

        




        
        // ######### data de retorno adcional ###########
        
        // criacao de espacamento
        var br3 = document.createElement('br');

        // criacao de um label
        var data_saida_label = document.createElement('label');

        // atributo do label
        data_saida_label.setAttribute('for', 'data_saida');

        // node do label
        var node_label = document.createTextNode('Data de Saída');

        // acresentando o node no label
        data_saida_label.appendChild(node_label);
        
        saida_adicional.appendChild(data_saida_label);
        
        var data_saida_input = document.createElement('input');
        data_saida_input.setAttribute('type', 'datetime-local');
        data_saida_input.setAttribute('name', 'data_saida'+cont);
        data_saida_input.setAttribute('class', 'form-control');

        saida_adicional.appendChild(data_saida_input);
        saida_adicional.appendChild(br3);
    }
    if(cont > 5) {
        document.querySelector('#msg').innerHTML = 'SOMENTE CINCO DATAS ADICIONAIS SÂO PERMITIDAS';
    }
    
});