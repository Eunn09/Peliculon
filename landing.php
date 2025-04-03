<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing de Películas</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: black;
            color: white;
            padding: 20px;
        }

        h1 {
            font-size: 36px;
        }

        p {
            font-size: 18px;
        }

        .cta-button {
            background-color: black;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }

        .cta-button:hover {
            background-color: white;
            color: black;
        }

        nav {
            background-color: #941010fe;;
            padding: 20px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 10px;
        }

        nav a:hover {
            border-bottom: 2px solid white;
        }

        section {
            padding: 20px;
        }

        .movie {
            border: 1px solid white;
            margin: 10px;
            padding: 10px;
            display: inline-block;
        }

        footer {
            background-color: #941010fe;
            color: white;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <nav>
        <a href="Registrarse.php">Registrarse</a>
        <a href="inicio de sesion.php">Iniciar Sesión</a>
        <i class="bi bi-cart4"></i>
    </nav>

    <header>
        <h1>Bienvenido al Mundo del Cine</h1>
        <p>Explora nuestras últimas películas y descubre un mundo de emociones.</p>
    </header>

    <section id="destacadas">
        <h2>Destacadas</h2>
        <p>Descubre nuestras películas destacadas de la semana.</p>
        <div class="movie">
            <img src="imagenes/Kiki.jpg" alt="Película 1">
            <h3>Kiki entregas a Domicilio</h3>
            <p>Al cumplir los 13 años, la brujita Kiki debe, como manda la tradición...</p>
        </div>
        <div class="movie">
            <img src="imagenes/Chihiro.jpg" alt="Película 2">
            <h3>El viaje de Chihiro</h3>
            <p>Chihiro es una niña caprichosa que debe adentrarse en un mundo de fantasía...</p>
        </div>
    </section>

    <section id="proximos-estrenos">
        <h2>Próximos Estrenos</h2>
        <p>¡No te pierdas nuestras próximas películas!</p>
        <div class="movie">
            <img src="imagenes/Bajo la misma.jpg" alt="Próximo Estreno 1">
            <h3>Bajo la misma estrella</h3>
            <p>Dos adolescentes pacientes de cáncer inician un viaje para reafirmar sus vidas y visitar a un escritor solitario en Ámsterdam.</p>
        </div>
        <div class="movie">
            <img src="imagenes/En llamas.jpg" alt="Próximo Estreno 2">
            <h3>Los juegos del hambre: En llamas</h3>
            <p>Tras salir victoriosos en los juegos del hambre, Katniss Everdeen y Peeta Mellark emprenden el tour de la victoria. </p>
        </div>
    </section>

    <footer>
        <p>&copy; 2023 Peliculón</p>
    </footer>
</body>
</html>
