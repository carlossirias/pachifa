<?php
require 'config/database.php';
require 'config/config.php';

$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == '')
{
    echo "ERROR AL PROCESAR LA PETICION";
    exit;
}
else
{
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    if($token_tmp == $token)
    {
        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id = ? AND activo = 1");
        $sql->execute([$id]);

        if($sql->fetchColumn() > 0)
        {
            $sql = $con->prepare("SELECT id,nombre,precio,descripcion,descuento FROM productos WHERE id = ? AND activo = 1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            $precio = $row['precio'];
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento)/100);

            $dir_images = "productos/".$id."/principal.jpeg";
            
            if(!file_exists($dir_images))
            {
                $dir_images = "productos/no-photo.jpeg";
            }
        }
    }
    else
    {
        echo "ERROR AL PROCESAR LA PETICION ";
        exit;
    }
}

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
    <link rel="stylesheet" href="styles\style_detalles.css">
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
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="checkout.php" class="carro"><img src="images\carrito.png" alt="" class="carrito"> Carrito(<span id="carrito"><?php echo $num_cart?></span>)</a></li>
            </ul>
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
    <div class="about">
        <div class="box uno">
            <img src="<?php echo $dir_images;?>" alt="" class="imagen_boxuno">
        </div>
        <div class="box dos">
            <div class="textBox">
                <h2><?php echo $nombre;?></h2>

                <?php if($descuento > 0) {?>
                    <h3><del><?php  echo MONEDA . number_format($precio,2,'.',',') ;?></del></h3>
                    <h4 class="desc"><?php  echo MONEDA . number_format($precio_desc,2,'.',',') ;?></del></h4>
                    <small class="small">¡<?php echo $descuento;?>% de descuento!</small>
                    <br>
                <?php } else{?>
                    <h3><?php  echo MONEDA . number_format($row['precio'],2,'.',',') ;?></h3>
                <?php }?>
                <br>
                <p><?php echo $descripcion;?></p>
            </div>
            <div class="buttonBox">
                <button class="boton_1" onclick="addProducto(<?php echo $id?>, '<?php echo $token_tmp?>')">Agregar a carrito</button>
                <button class="boton_2">Comprar ahora</button>
            </div>
        </div>
    </div>

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