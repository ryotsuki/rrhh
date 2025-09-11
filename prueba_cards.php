<?php 
    ini_set('display_errors', 'Off');
    include("conexion/conexion.php");

    $conn = conectate();

    $consulta = "SELECT * FROM ZAPATOS";
    $res=sqlsrv_query($conn,$consulta);
?>

<html>
<head>
<style>

    .filter-links {
    margin: 0;
    padding: 0;
    list-style: none;
    display: block;
    width: 100%;
    height:auto;
    overflow: hidden;
    background: white;
    border-bottom:1px solid #E4D7D7;
    }

    .filter-links li {
    display: inline;
    float: left;
    }

    .filter-links li a {
    display: block;
    color: black;
    padding: 1em 2em;
    text-decoration: none;
    }

    .filter-links li a:hover {
    color: red;
    }

    .filter-sections {
    width: 100%;
    display: block;
    overflow: hidden;
    }

    .filter-sections div {
    opacity: 0;
    display: none;
    /* min-height: 50px; */
    /* margin: 0.5em; */
    text-align: center;
    /* padding: 2em 1em; */
    float: left;
    transition: all 500s ease;
    }

    .view {
    display: block !important;
    opacity: 1 !important;
    /* transform: scale(1) rotate(0deg); */
    /* border-radius:4px; */
    /* animation: selected 300ms 1 ease-in-out; */
    }

    @keyframes selected {
    0% {
        border-radius:100%;
        transform: scale(0) rotate(-180deg);
    }
    }
</style>
</head>

<body>
<div class="container">

<ul class="filter-links">
  <li><a href="#">Todos</a></li>
  <li><a href="#">HOMBRE</a></li>
  <li><a href="#">MUJER</a></li>
  <li><a href="#">Css</a></li>
  <li><a href="#">Php</a></li>
</ul>

    <div class="row filter-sections" id="div_filtros">

        <?php
            while($row=sqlsrv_fetch_array($res)) {
                //echo $row["referencia"];
        ?>

            <div class="cell-4 <?php echo $row["categoria"]?>"><div>
                <div class="card">
                    <div class="card-header">
                        <div class="name">ZAPATO DE <?php echo $row["categoria"];?> <?php echo $row["referencia"];?></div>
                    </div>
                    <div class="card-content">
                        <img src="images/nb/<?php echo $row["referencia"];?>-1.jpg" style="width: 100%">
                    </div>
                    <div class="card-content p-2">
                        <?php echo utf8_encode($row["descripcion"]);?>
                    </div>
                    <hr>
                    <div class="card-content fg-gray" style="text-align: center;">
                        Ingrese la cantidad deseada por talla:
                        <input type="text" data-role="input" placeholder="5" style="text-align: center;width : 50px; heigth : 50px">
                        <input type="text" data-role="input" placeholder="5.5" style="text-align: center;width : 50px; heigth : 50px">
                        <input type="text" data-role="input" placeholder="6" style="text-align: center;width : 50px; heigth : 50px">
                        <input type="text" data-role="input" placeholder="6.5" style="text-align: center;width : 50px; heigth : 50px">
                        <input type="text" data-role="input" placeholder="7" style="text-align: center;width : 50px; heigth : 50px">
                        <input type="text" data-role="input" placeholder="7.5" style="text-align: center;width : 50px; heigth : 50px">
                    </div>
                    <div class="card-footer" style="text-align: center;">
                        <button class="mif-plus button success"></button>
                    </div>
                </div>
            </div></div>

        <?php
            }
        ?>

        <!--<div class="cell-4"><div>
            <div class="card">
                <div class="card-header">
                    <div class="name">Zapato de hombre ML574NE2</div>
                </div>
                <div class="card-content">
                    <img src="images/nb/ML574NE2-1.jpg" style="width: 100%">
                </div>
                <div class="card-content p-2">
                    El 574 de New Balance es un icono esencial y coleccionable, creadas en los 80's, combina ahora un estilo de vida con lo clásico de toda una herencia. Los New Balance 574, incluyen materiales premium en gamuzas, textiles en mallas y sintéticos.
                </div>
                <hr>
                <div class="card-content fg-gray" style="text-align: center;">
                    Ingrese la cantidad deseada por talla:
                    <input type="text" data-role="input" placeholder="5" style="text-align: center;width : 50px; heigth : 50px">
                    <input type="text" data-role="input" placeholder="5.5" style="text-align: center;width : 50px; heigth : 50px">
                    <input type="text" data-role="input" placeholder="6" style="text-align: center;width : 50px; heigth : 50px">
                    <input type="text" data-role="input" placeholder="6.5" style="text-align: center;width : 50px; heigth : 50px">
                    <input type="text" data-role="input" placeholder="7" style="text-align: center;width : 50px; heigth : 50px">
                    <input type="text" data-role="input" placeholder="7.5" style="text-align: center;width : 50px; heigth : 50px">
                </div>
                <div class="card-footer" style="text-align: center;">
                    <button class="mif-plus button success"></button>
                </div>
            </div>
        </div></div>-->

    </div>

    <div class="info-box" data-role="infobox" data-type="alert">
        <span class="button square closer"></span>
        <div class="info-box-content">
            <h3>What is Lorem Ipsum?</h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>
    </div>

    <div class="container" id="tabla_datos"></div>
</div>
</body>

<script>
    /*  Javascript filter
    ---------------------------------*/
    // animate divs on start
    var items = document.querySelectorAll('.filter-sections div');
    animate(items);

    // filter on click
    each('.filter-links li a', function(el) {
    el.addEventListener('click', function(e) {
        e.preventDefault();
        filterLinks(el);
    });
    });

    // filter links functions
    function filterLinks(element) {
    // get text 
    var el = element.textContent,
        // convert to lowercase
        linksTolowerCase = el.toLowerCase();
        alert(el);
    // if all remove all elements
    if (el === 'Todos') {
        // first show all view class
        each('.view', function(e) {
        e.classList.remove('view');
        });
        // no show init animation
        animate(items);
    } else {
        // if not click all remove all elements
        each('.view', function(e) {
        e.classList.remove('view');
        });
    }
    // show animation for current elements
    animate(document.querySelectorAll('.' + linksTolowerCase));
    };
    // forech arrays
    function each(el, callback) {
    var allDivs = document.querySelectorAll(el),
        alltoArr = Array.prototype.slice.call(allDivs);
    Array.prototype.forEach.call(alltoArr, function(selector, index) {
        if (callback) return callback(selector);
    });
    };
    // animate function
    function animate(item) {
    (function show(counter) {
        setTimeout(function() {
        item[counter].classList.add('view');
        counter++;
        if (counter < item.length) show(counter);
        },50);
    })(0);
    };
</script>
