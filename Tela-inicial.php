<?php
// index.php

// Produtos cadastrados via PHP
$produtos = [
    [
        "nome" => "iPhone 15 Pro",
        "preco" => "R$ 8.999,00",
        "img" => "fotos/547.png"
    ],
    [
        "nome" => "Samsung Galaxy S23",
        "preco" => "R$ 5.499,00",
        "img" => "fotos/s23.png"
    ],
    [
        "nome" => "Macbook Air M3",
        "preco" => "R$ 11.999,00",
        "img" => "fotos/mac.webp"
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartPoint - Tecnologia de Ponta</title>
  <link rel="shortcut icon" href="fotos/logo2.jpg" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    /* RESET e Estilos gerais */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; color: #111; background-color: #fafafa; overflow-x: hidden; }
    a { text-decoration: none; }

    /* HEADER */
    header { background: rgba(255,255,255,0.95); height: 80px; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; border-bottom: 1px solid #e0e0e0; backdrop-filter: blur(10px); position: sticky; top: 0; z-index: 1000; }
    .logo { display: flex; align-items: center; gap: 15px; font-size: 28px; font-weight: 700; color: #111; transition: transform 0.3s; }
    .logo img { width: 60px; height: 60px; object-fit: contain; border-radius: 12px; transition: transform 0.3s; }
    .logo:hover img { transform: scale(1.1); }
    .menu { display: flex; gap: 20px; }
    .menu a { color: #333; font-weight: 500; transition: 0.3s; }
    .menu a:hover { color: #0071e3; transform: translateY(-3px); }
    .header-actions { display: flex; align-items: center; gap: 15px; }
    .search-bar { display: flex; align-items: center; background: rgba(240,240,240,0.8); border-radius: 30px; padding: 0 10px; }
    .search-bar input { border: none; background: transparent; padding: 8px; outline: none; width: 150px; }
    .search-bar button { border: none; background: none; cursor: pointer; color: #555; transition: 0.3s; }
    .search-bar button:hover { transform: scale(1.1); }
    .auth-buttons a { background: #0071e3; color: #fff; padding: 8px 18px; border-radius: 25px; font-weight: 600; transition: 0.3s; }
    .auth-buttons a:hover { background: #005bb5; transform: scale(1.05); }
    .icons a { color: #333; font-size: 18px; margin-left: 10px; transition: 0.3s; }
    .icons a:hover { color: #0071e3; transform: scale(1.2); }

    /* HERO */
    .hero { position: relative; height: 85vh; display: flex; align-items: center; justify-content: center; text-align: center; color: white; overflow: hidden; }
    .hero-img { position: absolute; top:0; left:0; width:100%; height:100%; object-fit: cover; z-index:0; transition:0.5s; }
    .hero:hover .hero-img { transform: scale(1.05); }
    .hero::before { content:""; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.35); z-index:1; }
    .hero-content { position: relative; z-index: 2; animation: fadeIn 1s ease forwards; }
    .hero h1 { font-size:50px; margin-bottom:15px; text-shadow:0 0 10px rgba(0,0,0,0.5); animation: slideUp 1s ease forwards; }
    .hero p { font-size:18px; margin-bottom:25px; color:#ddd; animation: slideUp 1.2s ease forwards; }
    .btn { background:#0071e3; color:#fff; padding:12px 28px; border-radius:30px; font-weight:600; transition:0.3s; animation: fadeIn 1.4s ease forwards; }
    .btn:hover { background:#005bb5; transform: scale(1.05); }

    /* PRODUTOS */
    .produtos { text-align:center; padding:50px 20px; background: rgba(255,255,255,0.95); }
    .produtos h2 { font-size:32px; margin-bottom:40px; color:#111; }
    .container { display:flex; flex-wrap:wrap; justify-content:center; gap:30px; }
    .card { background: rgba(255,255,255,0.95); border-radius:16px; box-shadow:0 4px 12px rgba(0,0,0,0.08); width:260px; padding:20px; text-align:center; backdrop-filter:blur(6px); transition:0.4s; opacity:0; transform:translateY(20px); animation: fadeUp 0.6s forwards; }
    .card:nth-child(1){animation-delay:0.2s;} .card:nth-child(2){animation-delay:0.4s;} .card:nth-child(3){animation-delay:0.6s;}
    .card:hover { transform: translateY(-10px) scale(1.03); box-shadow:0 6px 18px rgba(0,0,0,0.12); }
    .card img { width:100%; border-radius:12px; margin-bottom:15px; transition:0.3s; }
    .card img:hover { transform: scale(1.05); }
    .card h3{font-size:18px;margin-bottom:5px;} .card p{color:#0071e3;font-weight:600;margin-bottom:15px;}
    .card button{background:#0071e3;color:#fff;border:none;border-radius:30px;padding:10px 25px;cursor:pointer;font-weight:600;transition:0.3s;}
    .card button:hover{background:#005bb5; transform: scale(1.05);}

    /* FOOTER */
    footer { background:#111;color:#ccc;text-align:center;padding:20px;font-size:14px; }

    /* RESPONSIVO */
    @media (max-width:768px){
      header { flex-wrap:wrap; height:auto; padding:10px; }
      .menu { display:none; }
      .search-bar input{width:120px;}
      .hero h1{font-size:34px;}
    }

    /* ANIMAÇÕES */
    @keyframes fadeIn { 0%{opacity:0;}100%{opacity:1;} }
    @keyframes slideUp {0%{opacity:0; transform:translateY(20px);}100%{opacity:1; transform:translateY(0);} }
    @keyframes fadeUp {0%{opacity:0; transform:translateY(20px);}100%{opacity:1; transform:translateY(0);} }
  </style>
</head>
<body>

<header>
  <a href="#" class="logo">
    <img src="fotos/logo2.jpg" alt="Logo SmartPoint">
    <span>SmartPoint</span>
  </a>
  <nav class="menu">
    <a href="#">iPhone</a>
    <a href="#">Samsung</a>
    <a href="#">Notebooks</a>
    <a href="#">Acessórios</a>
    <a href="#">Promoções</a>
  </nav>
  <div class="header-actions">
    <div class="search-bar">
      <input type="text" placeholder="Buscar produtos...">
      <button><i class="fas fa-search"></i></button>
    </div>
    <div class="auth-buttons">
      <a href="#">Login</a>
      <a href="#">Cadastro</a>
    </div>
    <div class="icons">
      <a href="#" class="cart"><i class="fas fa-shopping-cart"></i></a>
    </div>
  </div>
</header>

<section class="hero">
  <img src="fotos/funo.jpg" alt="Fundo SmartPoint" class="hero-img">
  <div class="hero-content">
    <h1>SmartPoint - Tecnologia de Ponta</h1>
    <p>Os melhores celulares e eletrônicos com preços imbatíveis e garantia total.</p>
    <a href="#" class="btn">Ver Ofertas</a>
  </div>
</section>

<section class="produtos">
  <h2>Destaques</h2>
  <div class="container">
    <?php foreach($produtos as $produto): ?>
      <div class="card">
        <img src="<?php echo $produto['img']; ?>" alt="<?php echo $produto['nome']; ?>">
        <h3><?php echo $produto['nome']; ?></h3>
        <p><?php echo $produto['preco']; ?></p>
        <button>Comprar</button>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<footer>
  <p>© 202
