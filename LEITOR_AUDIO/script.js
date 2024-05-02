let utterance = null;

function iniciarLeitura(elemento) {
    const texto = elemento.textContent.trim();
    utterance = new SpeechSynthesisUtterance(texto);
    speechSynthesis.speak(utterance);
}

function pararLeitura() {
    if (utterance) {
        speechSynthesis.cancel();
    }
}
