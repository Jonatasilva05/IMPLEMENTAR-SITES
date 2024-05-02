function addToCart() {
    var flavor1 = document.getElementById("flavor1").value;
    var flavor2 = document.getElementById("flavor2").value;
    var quantity = parseInt(document.getElementById("quantity").value);

    if (quantity <= 0 || isNaN(quantity)) {
        alert("Por favor, insira uma quantidade válida.");
        return;
    }

    var listItem = document.createElement("li");
    if (flavor2 !== "") {
        listItem.textContent = quantity + "x " + flavor1 + " + " + flavor2;
    } else {
        listItem.textContent = quantity + "x " + flavor1;
    }
    document.getElementById("cart").appendChild(listItem);

    // Limpar os campos após adicionar ao carrinho
    document.getElementById("flavor1").selectedIndex = 0;
    document.getElementById("flavor2").selectedIndex = 0;
    document.getElementById("quantity").value = 1;

    // Ocultar o segundo sabor se nenhum combo estiver selecionado
    if (document.getElementById("combo").value === "") {
        document.getElementById("flavor2").style.display = "none";
        document.querySelector('label[for="flavor2"]').style.display = "none";
    }
}

function showComboOptions() {
    var comboOptions = document.getElementById("comboOptions");
    var comboSelect = document.getElementById("combo");
    
    // Exibir ou ocultar opções de combo
    if (comboOptions.style.display === "none") {
        comboOptions.style.display = "block";
        
        // Ocultar o segundo sabor quando opções de combo estiverem visíveis
        document.getElementById("flavor2").style.display = "none";
        document.querySelector('label[for="flavor2"]').style.display = "none";
    } else {
        comboOptions.style.display = "none";
        
        // Exibir o segundo sabor quando opções de combo estiverem ocultas
        document.getElementById("flavor2").style.display = "block";
        document.querySelector('label[for="flavor2"]').style.display = "block";
    }
}

document.getElementById("combo").addEventListener("change", function() {
    var selectedCombo = this.value;
    if (selectedCombo === "") {
        // Se nenhum combo estiver selecionado, exibir o segundo sabor opcional
        document.getElementById("flavor2").style.display = "block";
        document.querySelector('label[for="flavor2"]').style.display = "block";
    } else {
        // Se um combo estiver selecionado, ocultar o segundo sabor opcional
        document.getElementById("flavor2").style.display = "none";
        document.querySelector('label[for="flavor2"]').style.display = "none";
    }
});
