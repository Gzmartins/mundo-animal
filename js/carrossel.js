const contorno = document.querySelector(".contorno"); // Seleciona o elemento com a classe "contorno"
const carrossel = document.querySelector(".carrossel"); // Seleciona o elemento com a classe "carrossel"
const larguraPrimeiroCartao = carrossel.querySelector(".cartao").offsetWidth; // Obtém a largura do primeiro cartão
const botoesSeta = document.querySelectorAll(".contorno i"); // Seleciona todos os botões de seta dentro do "contorno"
const filhosCarrossel = [...carrossel.children]; // Cria um array com os filhos do "carrossel"
let estaArrastando = false, estaAutoPlay = true, inicioX, inicioScrollEsquerda, idTimeout;
// Calcula o número de cartões que cabem no carrossel de uma vez
let cartoesPorVisao = Math.round(carrossel.offsetWidth / larguraPrimeiroCartao);

// Insere cópias dos últimos cartões no início do carrossel para rolagem infinita
filhosCarrossel.slice(-cartoesPorVisao).reverse().forEach(cartao => {
    carrossel.insertAdjacentHTML("afterbegin", cartao.outerHTML);
});

// Insere cópias dos primeiros cartões no final do carrossel para rolagem infinita
filhosCarrossel.slice(0, cartoesPorVisao).forEach(cartao => {
    carrossel.insertAdjacentHTML("beforeend", cartao.outerHTML);
});

// Desloca o carrossel para a posição adequada para ocultar os primeiros cartões duplicados no Firefox
carrossel.classList.add("sem-transicao");
carrossel.scrollLeft = carrossel.offsetWidth;
carrossel.classList.remove("sem-transicao");

// Adiciona ouvintes de eventos para os botões de seta para rolar o carrossel para a esquerda e direita
botoesSeta.forEach(botao => {
    botao.addEventListener("click", () => {
        carrossel.scrollLeft += botao.id == "esquerda" ? -larguraPrimeiroCartao : larguraPrimeiroCartao;
    });
});

const inicioArraste = (e) => {
    estaArrastando = true;
    carrossel.classList.add("arrastando");
    // Registra a posição inicial do cursor e do scroll do carrossel
    inicioX = e.pageX;
    inicioScrollEsquerda = carrossel.scrollLeft;
}

const arrastando = (e) => {
    if(!estaArrastando) return; // Se estaArrastando for falso, sai daqui
    // Atualiza a posição do scroll do carrossel com base no movimento do cursor
    carrossel.scrollLeft = inicioScrollEsquerda - (e.pageX - inicioX);
}

const pararArraste = () => {
    estaArrastando = false;
    carrossel.classList.remove("arrastando");
}

const rolagemInfinita = () => {
    // Se o carrossel estiver no início, rola para o final
    if(carrossel.scrollLeft === 0) {
        carrossel.classList.add("sem-transicao");
        carrossel.scrollLeft = carrossel.scrollWidth - (2 * carrossel.offsetWidth);
        carrossel.classList.remove("sem-transicao");
    }
    // Se o carrossel estiver no final, rola para o início
    else if(Math.ceil(carrossel.scrollLeft) === carrossel.scrollWidth - carrossel.offsetWidth) {
        carrossel.classList.add("sem-transicao");
        carrossel.scrollLeft = carrossel.offsetWidth;
        carrossel.classList.remove("sem-transicao");
    }
    // Limpa o timeout existente e inicia o autoplay se o mouse não estiver sobre o carrossel
    clearTimeout(idTimeout);
    if(!contorno.matches(":hover")) autoPlay();
}

const autoPlay = () => {
    if(window.innerWidth < 800 || !estaAutoPlay) return; // Sai se a janela for menor que 800 ou se estaAutoPlay for falso
    // Autoplay do carrossel a cada 2500 ms
    idTimeout = setTimeout(() => carrossel.scrollLeft += larguraPrimeiroCartao, 2500);
}

autoPlay();
carrossel.addEventListener("mousedown", inicioArraste);
carrossel.addEventListener("mousemove", arrastando);
document.addEventListener("mouseup", pararArraste);
carrossel.addEventListener("scroll", rolagemInfinita);
contorno.addEventListener("mouseenter", () => clearTimeout(idTimeout));
contorno.addEventListener("mouseleave", autoPlay);
