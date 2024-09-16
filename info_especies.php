<?php
// Caminho para o banco de dados SQLite
$database = __DIR__ . '/.sqlite';

try {
    $pdo = new PDO("sqlite:$database");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recebe o ID da espécie a partir da URL
    $especieId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Consulta para obter a categoria da espécie
    $categoria = 'SELECT c.nome AS categoria FROM categorias c INNER JOIN especies e ON c.id_categoria = e.id_categoria WHERE e.id_especie = :id';
    $stmtCategoria = $pdo->prepare($categoria);
    $stmtCategoria->bindParam(':id', $especieId, PDO::PARAM_INT);
    $stmtCategoria->execute();
    $categoriaSelecionada = $stmtCategoria->fetch(PDO::FETCH_ASSOC);

    // Consulta para obter a espécie
    $especies = 'SELECT * FROM especies WHERE id_especie = :id';
    $stmtEspecies = $pdo->prepare($especies);
    $stmtEspecies->bindParam(':id', $especieId, PDO::PARAM_INT);
    $stmtEspecies->execute();
    $especieSelecionada = $stmtEspecies->fetch(PDO::FETCH_ASSOC);

    // Debug: Verifique os resultados
    // var_dump($especieSelecionada);
    // var_dump($categoriaSelecionada);

    if (!$especieSelecionada) {
        echo 'Espécie não encontrada.';
        exit;
    }

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundo Animal</title>
    <link rel="shortcut icon" href="./image/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./styles/header.css">
    <link rel="stylesheet" href="./styles/tipos.css">
    <link rel="stylesheet" href="./styles/footer.css">
    <link rel="stylesheet" href="./styles/infos.css">
</head>
<body>
<header>
    <div class="container">
        <img src="./image/Outros/logo.jpg" alt="Logo">
        <h1>Mundo Animal</h1>
        <div class="header-input">
            <label class="radio" id="radio-ongs">
                <input type="radio" name="radio">
                <span class="name">
                    <a href="https://celcash.celcoin.com.br/landingpage1427809/ajudar">ONGS</a>
                </span>
            </label>
            <label class="radio" id="radio-animais">
                <input type="radio" name="radio">
                <span class="name">
                    <a href="./animais.html">Animais</a>
                </span>
            </label>
        </div>
        <div class="search">
            <input type="text" class="search__input" name="search-query" placeholder="Pesquisa">
            <button class="search__button">
                <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                    <g>
                        <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                    </g>
                </svg>
            </button>
        </div>
        <div class="header-input">
            <label class="radio" id="radio-dinossauros">
                <input type="radio" name="radio" checked="">
                <span class="name">
                    <a href="./dinos.php">Dinossauros</a>
                </span>
            </label>
        </div>
    </div>
</header>

<main>
    <section id="info_especies">
        <div class="infos">
            <img decoding="async" src="./image/<?php echo isset($categoriaSelecionada['categoria']) ? htmlspecialchars($categoriaSelecionada['categoria']) : 'outros'; ?>/<?php echo isset($especieSelecionada['nome_comum']) ? htmlspecialchars($especieSelecionada['nome_comum']) : 'imagem_nao_disponivel'; ?>.png" alt="Imagem de <?php echo isset($especieSelecionada['nome_comum']) ? htmlspecialchars($especieSelecionada['nome_comum']) : 'Espécie'; ?>">
            <h1><?php echo isset($especieSelecionada['nome_comum']) ? htmlspecialchars($especieSelecionada['nome_comum']) : 'Espécie'; ?></h1>
            <p><?php echo isset($especieSelecionada['descricao']) ? $especieSelecionada['descricao'] : 'Descrição não disponível'; ?></p>

        </div>

        <div class="ficha">
            <h1><?php echo isset($especieSelecionada['nome_comum']) ? htmlspecialchars($especieSelecionada['nome_comum']) : 'Espécie'; ?></h1>
            <img decoding="async" src="./image/<?php echo isset($categoriaSelecionada['categoria']) ? htmlspecialchars($categoriaSelecionada['categoria']) : 'outros'; ?>/<?php echo isset($especieSelecionada['nome_comum']) ? htmlspecialchars($especieSelecionada['nome_comum']) : 'imagem_nao_disponivel'; ?>.png" alt="Imagem de <?php echo isset($especieSelecionada['nome_comum']) ? htmlspecialchars($especieSelecionada['nome_comum']) : 'Espécie'; ?>">
            <p><span class="label">Dieta:</span> <?php echo isset($especieSelecionada['dieta']) ? htmlspecialchars($especieSelecionada['dieta']) : 'Não disponível'; ?></p>
            <p><span class="label">Nome do Grupo:</span> <?php echo isset($especieSelecionada['grupo']) ? htmlspecialchars($especieSelecionada['grupo']) : 'Não disponível'; ?></p>
            <p><span class="label">Expectativa de Vida na Natureza:</span> <?php echo isset($especieSelecionada['tempo_vida']) ? htmlspecialchars($especieSelecionada['tempo_vida']) : 'Não disponível'; ?></p>
            <p><span class="label">Tamanho:</span> <?php echo isset($especieSelecionada['tamanho']) ? htmlspecialchars($especieSelecionada['tamanho']) : 'Não disponível'; ?></p>
            <p><span class="label">Peso:</span> <?php echo isset($especieSelecionada['peso']) ? htmlspecialchars($especieSelecionada['peso']) : 'Não disponível'; ?></p>
        </div>
        <div class="detalhes">
            <p><?php echo isset($especieSelecionada['detalhes_especificos']) ? htmlspecialchars_decode($especieSelecionada['detalhes_especificos']) : 'Descrição não disponível'; ?></p>
        </div>
    </section>

</main>

<footer>
    <p>Desenvolvido por Guilherme Martins.<br> Projeto fictício sem fins comerciais, porém doe é importante</p>
    <ul>
        <li>Minhas Redes</li>
        <li class="lista__rodape__item">
            <img class="lista__rodape__imagem" src="./image/Outros/github.png" alt="Logo github">
            <a class="lista__rodape__link" href="https://github.com/Gzmartins">Gzmartins</a>
        </li>
        <li class="lista__rodape__item">
            <img class="lista__rodape__imagem" src="./image/Outros/linkedin.png" alt="Logo linkedin">
            <a class="lista__rodape__link" href="https://www.linkedin.com/in/guilherme-martins-8a3b7a2b5/">Guilherme Martins</a>
        </li>
    </ul>
</footer>
</body>
</html>
