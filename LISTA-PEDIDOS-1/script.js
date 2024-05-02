function adicionarPedido() {
    var sabor1Selecionado = document.getElementById("sabor1").value;
    var sabor2Selecionado = document.getElementById("sabor2").value;
    var quantidadeInput1 = document.getElementById("quantidadeInput1");
    var quantidadeInput2 = document.getElementById("quantidadeInput2");
    var quantidadeCombo = document.getElementById("comboQuantidade").value;

    var quantidade1 = quantidadeInput1.value;
    var quantidade2 = quantidadeInput2.value;

    // Verificar se uma quantidade de combo foi selecionada
    if (quantidadeCombo !== "0") {
        var quantidadeTotal = parseInt(quantidadeCombo);
        var quantidadeProduto1 = quantidadeTotal;
        var quantidadeProduto2 = 0;

        // Verificar se foi selecionado "Nenhum sabor adicional" para o primeiro produto
        var saborAdicional1 = document.querySelector('input[name="outroSabor1"]:checked');
        if (saborAdicional1 === null || saborAdicional1.value === "nenhum") {
            // Adicionar apenas o primeiro produto
            var novoPedido1 = document.createElement("li");
            novoPedido1.textContent = quantidadeProduto1 + " x " + sabor1Selecionado + " (do combo)";
            document.getElementById("lista-pedidos").appendChild(novoPedido1);
        } else {
            alert("Não é permitido selecionar um sabor adicional para o primeiro produto quando um combo é selecionado.");
            return;
        }

        // Se um segundo produto for escolhido, calcular a quantidade
        if (quantidade2 > 0) {
            quantidadeProduto2 = quantidadeTotal - quantidadeProduto1;
            if (quantidadeProduto2 <= 0) {
                alert("A quantidade selecionada do segundo produto excede a quantidade total do combo. Por favor, ajuste a quantidade.");
                return;
            }
            var novoPedido2 = document.createElement("li");
            novoPedido2.textContent = quantidadeProduto2 + " x " + sabor2Selecionado + " (do combo)";
            document.getElementById("lista-pedidos").appendChild(novoPedido2);
        }
    } else {
        // Se não for um combo, adicionar apenas o primeiro produto
        var novoPedido1 = document.createElement("li");
        novoPedido1.textContent = quantidade1 + " x " + sabor1Selecionado;
        document.getElementById("lista-pedidos").appendChild(novoPedido1);

        // Adicionar o segundo produto adicional se um sabor e quantidade forem selecionados
        if (quantidade2 > 0) {
            var novoPedido2 = document.createElement("li");
            novoPedido2.textContent = quantidade2 + " x " + sabor2Selecionado;
            document.getElementById("lista-pedidos").appendChild(novoPedido2);
        }
    }
}

function atualizarQuantidadeCombo() {
    var comboQuantidade = document.getElementById("comboQuantidade").value;
    var outrosSaboresDiv1 = document.getElementById("outrosSabores1");
    var produto2Div = document.getElementById("produto2");

    if (comboQuantidade !== "0") {
        outrosSaboresDiv1.style.display = "block";
        produto2Div.style.display = "block";
    } else {
        outrosSaboresDiv1.style.display = "none";
        produto2Div.style.display = "none";
    }

    // Desmarcar todos os radio buttons de sabores adicionais para o primeiro produto
    var saboresAdicionais1 = document.getElementsByName("outroSabor1");
    for (var i = 0; i < saboresAdicionais1.length; i++) {
        saboresAdicionais1[i].checked = false;
    }
}
