<?php
require 'config/database.php';
require 'config/config.php';

$db = new Database();
$con = $db->conectar();

//session_destroy();

$sql = $con->prepare("SELECT id,nombre,precio FROM productos WHERE activo = 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles\style_cata.css">
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
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#">Catálogo</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="checkout.php" class="carro"><img src="images\carrito.png" alt="" class="carrito"> Carrito(<span id="carrito"><?php echo $num_cart?></span>)</a></li>
            </ul>
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <div class="banner">
        <div class="slider">
            <ul>
                <li><img src="images\carousel2.png" alt=""></li>
                <li><img src="images\carousel1.png" alt=""></li>
            </ul>
        </div>
    </div>

    <div class="descuento">
        <h2>¡DESCUENTO DE 15% EN TUS COMPRAS!</h2>
    </div>

    <div class="about">

        <?php foreach($resultado as $row){?>
            <div class="box">
                <div class="imagen_box">
                    <?php 
                        $id = $row['id'];
                        $imagen = "productos/".$id."/principal.jpeg";
                        if(!file_exists($imagen))
                        {
                            $imagen = "productos/no-photo.jpg";
                        }
                    ?>
                    <img src="<?php  echo $imagen;?>" alt="" class="imagen_principal">
                </div>
                <div class="text_box">
                    <h3><?php  echo $row['nombre'];?></h3>
                    <p> <?php  echo MONEDA . number_format($row['precio'],2,'.',',') ;?></p>
                </div>
                <div class="botones_box">
                    <a href="detalles.php?id=<?php echo $row['id'];?>&token=<?php echo hash_hmac('sha1',$row['id'],KEY_TOKEN); ?>"><button class="boton_1">Ver detalles</button></a>
                    <button class="botonuno" onclick="addProducto(<?php echo $row['id'];?>,'<?php echo hash_hmac('sha1',$row['id'],KEY_TOKEN);?>')">Agregar al carrito</button>
                </div>
            </div>
        <?php }?>
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

    <script>
        
        function addProducto(id,token)
        {
            console.log(id)
            console.log(token)
            let url = 'clases/carrito.php';
            let formData = new FormData();
            formData.append('id',id)
            formData.append('token',token)

            fetch(url,{
                method:'POST',
                body: formData,
                mode:'cors'
            }).then(response=> response.json())
            .then(data =>{
                if(data.ok)
                {
                    let elemento = document.getElementById("carrito")
                    elemento.innerHTML = data.numero
                }
            })
        }
    </script>
</body>
</html>