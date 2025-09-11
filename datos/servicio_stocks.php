<?php

    /* comprobamos que el usuario nos viene como un parametro */
    if(isset($_GET['referencia'])) {

        /* utilizar la variable que nos viene o establecerla nosotros */
        $referencia = $_GET['referencia']; //10 es por defecto
        if($referencia != ""){
            $consulta_referencia = "AND AL.CODBARRAS = '$referencia'";
        }
        else{
            $consulta_referencia = "";
        }
        $format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml'; //xml es por defecto
        //$user_id = intval($_GET['user']); 

        /* conectamos a la bd */
        $serverName = "localhost"; //serverName\instanceName
        $connectionInfo = array( "Database"=>"NOVOMODE", "UID"=>"sa", "PWD"=>"N0v0m043");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);		

        /* sacamos los posts de bd */
        $query = "SELECT
                    SUM(S.STOCK) AS STOCK,
                    AL.CODBARRAS
                FROM 
                    STOCKS S,
                    ARTICULOSLIN AL
                WHERE
                    (AL.CODARTICULO = S.CODARTICULO AND AL.COLOR = S.COLOR AND AL.TALLA = S.TALLA)
                    $consulta_referencia
                    AND S.STOCK > 0
                GROUP BY AL.CODBARRAS
                ORDER BY AL.CODBARRAS";
        // echo $query;
        // exit;
        $res=sqlsrv_query($conn,$query);	

        /* creamos el array con los datos */
        $posts = array();
        if(sqlsrv_has_rows($res) === true) {
            while($row=sqlsrv_fetch_array($res)) {
                        $posts[] = array('post'=>$row);
                }
        }

        /* formateamos el resultado */
        if($format == 'json') {
                header('Content-type: application/json');
                echo json_encode(array('posts'=>$posts));
        }
        else {
                header('Content-type: text/xml');
                echo '<datos>';
                foreach($posts as $index => $post) {
                        if(is_array($post)) {
                                foreach($post as $key => $value) {
                                        echo '<',$key,'>';
                                        if(is_array($value)) {
                                                foreach($value as $tag => $val) {
                                                        echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
                                                }
                                        }
                                        echo '</',$key,'>';
                                }
                        }
                }
                echo '</datos>';
        }
    }

?>