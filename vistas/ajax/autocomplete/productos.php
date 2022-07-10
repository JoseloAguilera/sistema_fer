<?php
if (isset($_GET['term'])) {
    include "../../db.php";
    include "../../php_conexion.php";
    $return_arr = array();
/* If connection to database, run sql statement. */
    if ($conexion) {

        $fetch = mysqli_query($conexion, "SELECT * FROM productos where nombre_producto like '%" . mysqli_real_escape_string($conexion, ($_GET['term'])) . "%' LIMIT 0 ,50");

        /* Retrieve and store in array the results of the query.*/
        while ($row = mysqli_fetch_array($fetch)) {
            $id_producto                  = $row['id_producto'];
            $row_array['value']           = $row['nombre_producto'];
            $row_array['id_producto']     = $id_producto;
            $row_array['nombre_producto'] = $row['nombre_producto'];
            array_push($return_arr, $row_array);
        }

    }

/* Free connection resources. */
    mysqli_close($conexion);

/* Toss back results as json encoded array. */
    echo json_encode($return_arr);

}
