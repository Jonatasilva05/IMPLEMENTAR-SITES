function adicionarPedido() {
    var saborSelecionado = document.getElementById("sabor").value;
    var quantidadeInput = document.getElementById("quantidadeInput");
    var quantidadeCombo = document.getElementById("comboQuantidade").value;

    var quantidade = quantidadeInput.value;
    // Verificar se uma quantidade de combo foi selecionada
    if (quantidadeCombo !== "0") {
        quantidade = quantidadeCombo;
        // Verificar se foi selecionado "Nenhum sabor adicional"
        var saborAdicional = document.querySelector('input[name="outroSabor"]:checked');
        if (saborAdicional === null || saborAdicional.value === "nenhum") {
            // Se nenhum sabor adicional foi selecionado, adicionar apenas o sabor principal
            var novoPedido = document.createElement("li");
            novoPedido.textContent = quantidade + " x " + saborSelecionado + " (do combo)";
            document.getElementById("lista-pedidos").appendChild(novoPedido);
        } else {
            // Calcular a quantidade de cada sabor com base na quantidade total e no combo selecionado
            var quantidadeSaborPrincipal = parseInt(quantidade) * 0.5; // Por exemplo, metade para o sabor principal
            var quantidadeSaborAdicional = parseInt(quantidade) * 0.5; // E metade para o sabor adicional

            // Adicionar os pedidos à lista de pedidos
            var novoPedidoPrincipal = document.createElement("li");
            novoPedidoPrincipal.textContent = quantidadeSaborPrincipal + " x " + saborSelecionado + " (do combo)";
            document.getElementById("lista-pedidos").appendChild(novoPedidoPrincipal);

            var novoPedidoAdicional = document.createElement("li");
            novoPedidoAdicional.textContent = quantidadeSaborAdicional + " x " + saborAdicional.value + " (do combo)";
            document.getElementById("lista-pedidos").appendChild(novoPedidoAdicional);
        }
    } else {
        // Validar se a quantidade é maior que 0
        if (quantidade <= 0) {
            alert("A quantidade deve ser maior que zero.");
            return;
        }
        // Se não for um combo, adicionar apenas um pedido com o sabor principal
        var novoPedido = document.createElement("li");
        novoPedido.textContent = quantidade + " x " + saborSelecionado;
        document.getElementById("lista-pedidos").appendChild(novoPedido);
    }
}

function atualizarQuantidadeCombo() {
    var comboQuantidade = document.getElementById("comboQuantidade").value;
    var outrosSaboresDiv = document.getElementById("outrosSabores");
    if (comboQuantidade !== "0") {
        outrosSaboresDiv.style.display = "block";
    } else {
        outrosSaboresDiv.style.display = "none";
    }

    // Desmarcar todos os radio buttons de sabores adicionais
    var saboresAdicionais = document.getElementsByName("outroSabor");
    for (var i = 0; i < saboresAdicionais.length; i++) {
        saboresAdicionais[i].checked = false;
    }
}
