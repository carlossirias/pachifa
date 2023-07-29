<?php 
require 'config/config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles\style.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <title>Pachifa</title>
</head>
<body>
    <nav class="navbar">
        <div class="content">
            <div class="logo"><a href="#"><img src="images\Logo.png" alt=""></a></div>
            <ul class="menu-list">
                <div class="icon cancel-btn">
                    <i class="fas fa-times"></i>
                </div>
                <li><a href="#">Inicio</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="checkout.php" class="carro"><img src="images\carrito.png" alt="" class="carrito"> Carrito(<span><span><?php echo $num_cart?></span></span>)</a></li>
            </ul>
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    
    <div class="banner">
        <div class="contenedor">
            <h2>¡Donde los útiles los eliges <span>Tú</span>! </h2>

            <br>
            <br>
            <a href="">Ver catálogo</a>
        </div>
    </div>

    <div class="about">
        <div class="content">
            <div class="box image"></div>
            <div class="box noimage">
                <div class="marco"></div>
                <h2>¿Quienes somos?</h2>
                <br>
                <p>Somos una empresa que brinda los mejores utiles, articulos a los mejores precios. <br><br> Esto nos diferencia con cualquier otra librería a nivel nacional.</b></p>
                <br>
                <span>¿Quieres conocer más de nosotros?</span>
                <br>
                <br>
                <a href="images\hola.txt" download="PACHIFA" title="Descargar">Conoce más</a>
            </div>
            
        </div>
    </div>

    <footer>
        <div class="footer-conteiner">
            <h3>PACHIFA</h3>
            <p>¡Donde los útiles los eliges tú!</p>
            <ul class="sociales">
                <li><a href=""><i class="fa fa-facebook"></i></a></li>
                <li><a href=""><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
        <div class="footer-bottom">
            <p>copyright &copy;2022 PACHIFA.</p>
        </div>
    </footer>

    <script>
        const body = document.querySelector("body");
        const navbar = document.querySelector(".navbar");
        const menu = document.querySelector(".menu-list");
        const menuBtn = document.querySelector(".menu-btn");
        const cancelBtn = document.querySelector(".cancel-btn");

        menuBtn.onclick = ()=>{
            menu.classList.add("active");
            menuBtn.classList.add("hide");
            body.classList.add("disbledScroll");
        }

        cancelBtn.onclick = ()=>{
            menu.classList.remove("active");
            menuBtn.classList.remove("hide");
            body.classList.remove("disbledScroll");
        }

        window.onscroll = ()=>{
            this.scrollY > 20 ? navbar.classList.add("sticky") : navbar.classList.remove("sticky");
        }
    </script>
</body>
</html>