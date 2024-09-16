<?php
// Caminho para o banco de dados SQLite
$database = __DIR__ . '/.sqlite'; // Ajuste o nome do arquivo, se necessário

try {
    $pdo = new PDO("sqlite:$database");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recebe o ID do dinossauro a partir da URL
    $dinoId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Consulta para obter o dinossauro
    $dinoQuery = 'SELECT * FROM dinossauros WHERE id_dinossauro = :id';
    $stmtDino = $pdo->prepare($dinoQuery);
    $stmtDino->bindParam(':id', $dinoId, PDO::PARAM_INT);
    $stmtDino->execute();
    $dino = $stmtDino->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    $dino = null; // Inicializa o dinossauro como null em caso de erro
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($dino['nome']); ?> - Mundo Animal</title>
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
        <?php if ($dino): ?>
            <div class="infos">
                <img decoding="async" src="./image/Dinossauros/<?php echo htmlspecialchars($dino['nome']); ?>.png" alt="Imagem de <?php echo htmlspecialchars($dino['nome']); ?>">
                <h2><?php echo htmlspecialchars($dino['nome']); ?></h2>
                <?php echo isset($dino['descricao']) ? htmlspecialchars_decode($dino['descricao']) : 'Descrição não disponível'; ?></p>
            </div>
        <?php else: ?>
            <p>Dinossauro não encontrado.</p>
        <?php endif; ?>
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
