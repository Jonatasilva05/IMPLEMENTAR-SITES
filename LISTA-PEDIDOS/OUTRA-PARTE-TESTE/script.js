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
        // Verificar se foi selecionado "Nenhum sabor adicional" para o primeiro produto
        var saborAdicional1 = document.querySelector('input[name="outroSabor1"]:checked');
        if (saborAdicional1 === null || saborAdicional1.value === "nenhum") {
            // Se nenhum sabor adicional foi selecionado, adicionar apenas o primeiro produto
            var novoPedido1 = document.createElement("li");
            novoPedido1.textContent = quantidade1 + " x " + sabor1Selecionado + " (do combo)";
            document.getElementById("lista-pedidos").appendChild(novoPedido1);
        } else {
            alert("Não é permitido selecionar um sabor adicional para o primeiro produto quando um combo é selecionado.");
            return;
        }

        // Adicionar o segundo produto adicional se um sabor e quantidade forem selecionados
        if (quantidade2 > 0) {
            var novoPedido2 = document.createElement("li");
            novoPedido2.textContent = quantidade2 + " x " + sabor2Selecionado;
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
