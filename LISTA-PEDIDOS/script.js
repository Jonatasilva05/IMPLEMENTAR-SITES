function adicionarPedido() {
    var sabor1Selecionado = document.getElementById("sabor1").value;
    var quantidadeInput1 = document.getElementById("quantidadeInput1");
    var quantidadeCombo = document.getElementById("comboQuantidade").value;

    var quantidade1 = parseInt(quantidadeInput1.value);
    var quantidadeTotal = parseInt(quantidadeCombo);

    // Verificar se foi selecionado um combo
    if (quantidadeCombo !== "0") {
        // Definir a quantidade do primeiro produto como a quantidade escolhida pelo usuário
        var quantidadeProduto1 = quantidade1;
        var saboresAdicionais = document.getElementsByName("outroSabor");
        var quantidadeProduto2 = quantidadeTotal - quantidadeProduto1;
        var saborAdicionalSelecionado = "";

        // Verificar qual sabor adicional foi selecionado
        for (var i = 0; i < saboresAdicionais.length; i++) {
            if (saboresAdicionais[i].checked) {
                saborAdicionalSelecionado = saboresAdicionais[i].value;
                break;
            }
        }

        // Adicionar os pedidos
        var novoPedido1 = document.createElement("li");
        novoPedido1.textContent = quantidadeProduto1 + " x " + sabor1Selecionado + " (do combo)";
        document.getElementById("lista-pedidos").appendChild(novoPedido1);

        if (saborAdicionalSelecionado !== "") {
            var novoPedidoAdicional = document.createElement("li");
            novoPedidoAdicional.textContent = quantidadeProduto2 + " x " + saborAdicionalSelecionado + " (do combo)";
            document.getElementById("lista-pedidos").appendChild(novoPedidoAdicional);
        }
    } else {
        // Adicionar apenas o produto selecionado
        var novoPedido = document.createElement("li");
        novoPedido.textContent = quantidade1 + " x " + sabor1Selecionado;
        document.getElementById("lista-pedidos").appendChild(novoPedido);
    }
}

function atualizarTipoCompra() {
    var comboQuantidade = document.getElementById("comboQuantidade").value;
    var quantidade1Input = document.getElementById("quantidadeInput1");
    var outrosSaboresDiv = document.getElementById("outrosSabores");

    if (comboQuantidade !== "0") {
        quantidade1Input.disabled = false;
        outrosSaboresDiv.style.display = "block";
    } else {
        quantidade1Input.disabled = true;
        outrosSaboresDiv.style.display = "none";
    }

    // Desmarcar todos os radio buttons de sabores adicionais
    var saboresAdicionais = document.getElementsByName("outroSabor");
    for (var i = 0; i < saboresAdicionais.length; i++) {
        saboresAdicionais[i].checked = false;
    }
}
