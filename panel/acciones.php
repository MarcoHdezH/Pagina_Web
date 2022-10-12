<?php

    require '../vendor/autoload.php';

    $pelicula = new kawschool\Pelicula;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if($_POST['accion'] === 'Registrar'){

            if(empty($_POST['titulo']))
                exit('Completar Titulo');
            
            if(empty($_POST['descripcion']))
                exit('Completar Descripcion');

            if(empty($_POST['categoria_id']))
                exit('seleccionar una categoria');

            if(!is_numeric($_POST['categoria_id']))
                exit('Seleccionar una categoria valida');

            $_params = array(
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'foto' => subirfoto(),
                'precio' => $_POST['precio'],
                'categoria_id' => $_POST['categoria_id'],
                'fecha' => date('Y-m-d'),
            );

            $rpt = $pelicula -> registrar($_params);

            if($rpt)
                header('Location: peliculas/index.php');
            else
                print 'Error de Registro unu';
        }

        if($_POST['accion'] === 'Actualizar'){

            if(empty($_POST['titulo']))
                exit('Completar Titulo');
            
            if(empty($_POST['descripcion']))
                exit('Completar Descripcion');

            if(empty($_POST['categoria_id']))
                exit('seleccionar una categoria');

            if(!is_numeric($_POST['categoria_id']))
                exit('Seleccionar una categoria valida');

            $_params = array(
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'precio' => $_POST['precio'],
                'categoria_id' => $_POST['categoria_id'],
                'fecha' => date('Y-m-d'),
                'id' => $_POST['id'],
                );

            if(!empty($_POST['foto_temp']))
                $_params['foto'] = $_POST['foto_temp'];

            if(!empty($_FILES['foto']['name']))
                $_params['foto'] = subirfoto();
    
            $rpt = $pelicula -> actualizar($_params);
    
            if($rpt)
                header('Location: peliculas/index.php');
            else
                print 'Error de Actualizacion unu';
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){

        $id = $_GET['id'];

        $rpt = $pelicula->eliminar($id);

        if($rpt)
            header('Location:peliculas/index.php');
        else
            print 'Error al eliminar';

    }

    function subirfoto(){

        $carpeta = __DIR__.'../../upload/';

        $archivo = $carpeta.$_FILES['foto']['name'];

        move_uploaded_file($_FILES['foto']['tmp_name'],$archivo);

        return $_FILES['foto']['name'];
    }
