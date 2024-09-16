<?php
// Caminho para o banco de dados SQLite
$database = __DIR__ . '/.sqlite';

try {
    $pdo = new PDO("sqlite:$database");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recebe o ID da categoria a partir da URL
    $categoriaId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Inicializa a variável $listaEspecies
    $listaEspecies = [];

    // Consulta para obter a categoria específica
    $categoria = 'SELECT * FROM categorias WHERE id_categoria = :id';
    $stmtCategoria = $pdo->prepare($categoria);
    $stmtCategoria->bindParam(':id', $categoriaId, PDO::PARAM_INT);
    $stmtCategoria->execute();
    $categoriaSelecionada = $stmtCategoria->fetch(PDO::FETCH_ASSOC);

    // Consulta para obter espécies da categoria
    $especies = 'SELECT * FROM especies WHERE id_categoria = :id';
    $stmtEspecies = $pdo->prepare($especies);
    $stmtEspecies->bindParam(':id', $categoriaId, PDO::PARAM_INT);
    $stmtEspecies->execute();
    $listaEspecies = $stmtEspecies->fetchAll(PDO::FETCH_ASSOC);

    // Debug: Verifique os resultados das espécies
    // var_dump($listaEspecies);

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
    <section id="tipos">
        <h2 class="titulo-paginas"><?php echo isset($categoriaSelecionada['nome']) ? htmlspecialchars($categoriaSelecionada['nome']) : 'Espécies'; ?></h2>
        <div class="container-animais" id="cardContainer">
            <?php 
            $cartoesParaCarregar = 20; // Quantidade inicial de cartões a serem exibidos
            for ($i = 0; $i < $cartoesParaCarregar && $i < count($listaEspecies); $i++): 
                $especie = $listaEspecies[$i];
            ?>
                <div class="cartao">
                    <img decoding="async" src="./image/<?php echo htmlspecialchars($categoriaSelecionada['nome']); ?>/<?php echo htmlspecialchars($especie['nome_comum']); ?>.png" alt="Imagem de <?php echo htmlspecialchars($especie['nome_comum']); ?>">
                    <hr>
                    <h2><?php echo htmlspecialchars($especie['nome_comum']); ?></h2>
                    <a href="info_especies.php?id=<?php echo $especie['id_especie']; ?>">Saiba mais</a>
                </div>
            <?php endfor; ?>
        </div>
    </section>
</main>
</body>
</html>
