<?php
require 'config/database.php';
require 'config/config.php';

$db = new Database();
$con = $db->conectar();
$total = 0;

//session_destroy();

$procutos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

//print_r($_SESSION);

$lista_carrito = array();

if($procutos != null)
{
    foreach($procutos as $clave => $cantidad)
    {
        $sql = $con->prepare("SELECT id,nombre,precio,descuento, $cantidad AS cantidad FROM productos WHERE id = ? AND activo = 1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}
else
{
    header('Location:index.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles\style_pago.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                <li><a href="#" class="carro"><img src="images\carrito.png" alt="" class="carrito"> Carrito(<span id="carrito"><?php echo $num_cart?></span>)</a></li>
            </ul>
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <div class="about">
        <div class="box uno">
            <form action="" class="form" method="post">

                <label for="">Nombre Completo</label>
                <input type="text" class="form_input" name="nombre" id="dnombre" placeholder="e.g. Heily Isabel Solis Davila">
                <div class="form_Nombre--error error"></div>

                <label for="">Direccion</label>
                <input type="text" class="form_input" name="direccion" id="direccion" placeholder="e.g. Villa sol casa F-8-2">
                <div class="form_Direction--error error"></div>

                <label for="">Numero de telefono</label>
                <input type="text" class="form_input" name="Number" id="Number" maxlength="8" placeholder="e.g. 83873579">
                <div class="form_Number--error error"></div>

                <label for="">Correo Electronico</label>
                <input type="email" class="form_input" name="email" id="email">
                <div class="form_Email--error error"></div>

                <label for="cardholder">Nombre del titular</label>
                <input type="text" class="form_input" name="cardholder" id="cardholder" placeholder="e.g. Heily Solis">
                <div class="form_cardholder--error error" id="holderError"></div>

                <label for="cardNumber">Numero de tarjeta</label>
                <input type="text" class="form_input" name="cardNumber" id="cardNumber" maxlength="19" placeholder="e.g. 1234 5678 9123 0000">
                <div class="form_cardNumber--error error" id="cardNumberError"></div>

                <div class="form-cev-date">
                    <label for="cardMonth">Ej. Fecha (MM/YY)</label>
                    <label for="cardCVC">CVC</label>
                    <div>
                        <input type="text" class="form_input" id="cardMonth" maxlength="2" name="cardMonth" placeholder="MM">
                        <input type="text" class="form_input" id="cardYear" maxlength="2" name="cardYear" placeholder="YY">
                    </div>
                    <input type="text" maxlength="3" id="cardCVC" name="cardCVC" placeholder="e.g. 123" class="form_input">
                    <div class="form_errorcontainer">
                        <div class="form_input-mm--error error" id="monthErrorDiv"></div>
                        <div class="form_input-yy--error error" id="yearErrorDiv"></div>
                    </div>

                    <div class="form_input-cev-error error" id="cvcErrorDiv"></div>
                </div>
            </form>
            <button onclick="Enviar()" class="boton_pagar">Realizar pago</button>
        </div>
        <div class="box dos">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php if($lista_carrito == null)
                    {
                        echo '<tr><td colspan="3"><h2 class="sincarro"><b>¡Aun no has añadido nada al carrito :c!</b></h2></td></tr>';
                    }
                    else{
                        
                        foreach($lista_carrito as $producto)
                        {
                            $id = $producto['id'];
                            $nombre = $producto['nombre'];
                            $precio = $producto['precio'];
                            $descuento = $producto['descuento'];
                            $cantidad= $producto['cantidad'];
                            $precio_desc = $precio -(($precio * $descuento)/100);
                            $subtotal = $cantidad * $precio_desc;
                            $total += $subtotal;
                       ?>
                    <tr>
                        <td><?php echo $nombre;?></td>
                        <?php
                            if($descuento > 0)
                            {?>
                            <td ><span style="color: rgb(83, 201, 15);"><?php echo MONEDA. number_format($precio_desc,2,'.',',');?></span></td>
                        <?php
                        }else{
                        ?>
                            <td class=""><?php echo MONEDA. number_format($precio_desc,2,'.',',');?></td>
                        <?php
                        }
                        ?>
                        
                        <td>
                            <div id="subtotal_<?php echo $id;?>" name="subtotal[]"><?php echo MONEDA. number_format($subtotal,2,'.',',');?></div>
                        </td>
                    </tr>
                <?php
                    }
                }?>

                <tr>
                    <td colspan="2"></td>
                    <td colspan="1"> <h3 id="total"><?php echo MONEDA . number_format($total,2,'.',',');?></h3></td>
                </tr>
                </tbody>
            </table>
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

    <script>
        function actualizaCantidad(cantidad,id)
        {
            let url = 'clases/actualizar.php';
            let formData = new FormData();
            formData.append('action','agregar')
            formData.append('id',id)
            formData.append('cantidad',cantidad)

            fetch(url,{
                method:'POST',
                body: formData,
                mode:'cors'
            }).then(response => response.json())
            .then(data =>{
                if(data.ok)
                {
                    let elemento = document.getElementById("subtotal_"+id)
                    elemento.innerHTML = data.sub

                    let total = 0.00
                    let list = document.getElementsByName('subtotal[]')
                    for(let i = 0; i < list.length; i++)
                    {
                        total+= parseFloat(list[i].innerHTML.replace(/[C$,]/g, ''))
                    }

                    total = new Intl.NumberFormat('en-US',{
                        minimumFractionDigits: 2
                    }).format(total)

                    document.getElementById('total').innerHTML = '<?php echo MONEDA;?>' + total
                }
            })
            .catch(error => console.log(error))
        }

        function eliminar(id)
        {
            let url = 'clases/eliminar.php';
            let formData = new FormData();
            formData.append('id',id)

            fetch(url,{
                method:'POST',
                body: formData,
                mode:'cors'
            }).then(response=> response.json())
            .then(data =>{
                if(data.ok)
                {
                    location.reload();
                }
            })
            .catch(error => console.log(error))

        }
    </script>

    <script src="js/main.js"></script>
</body>
</html>