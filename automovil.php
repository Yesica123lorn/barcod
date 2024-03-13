<?php
require_once("base/conexion.php");
$base = new Database();
$conectar = $base->conectar();
session_start();

require 'vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG; 

if (isset($_POST["btn-guardar"])){
    $placa = $_POST['placa'];
    $marca = $_POST['marca'];
    $dueno = $_POST['dueno'];  

    // Generar un código de barras único

    // Verificar si el automóvil ya está registrado
    $validar = $conectar->prepare("SELECT * FROM auto WHERE placa = ?");
    $validar->execute([$placa]);
    $fila1 = $validar->fetchAll(PDO::FETCH_ASSOC);

    if ($fila1) {
        echo '<script>alert("El automóvil ya está registrado.");</script>';
    } else {

        $codigo_barras = uniqid();

        $generator = new BarcodeGeneratorPNG();

        $codigo_barras_imagen = $generator->getBarcode($codigo_barras, $generator::TYPE_CODE_128);
    
       
        file_put_contents(__DIR__ . '/imagen/' . $codigo_barras . '.png', $codigo_imagen);
       
        $consulta3 = $conectar->prepare("INSERT INTO auto (placa, codio_barras, marca, dueno) VALUES (?, ?, ?, ?)");
        $consulta3->execute([$placa, $codigo_barras, $marca, $dueno]); 

        echo '<script>alert("Registro exitoso, gracias");</script>';
        echo '<script>window.location="automovil.php"</script>';
        exit();
    }
}
?>











<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>automovil</title>
  <link rel="stylesheet" href="">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
      background-image: url('img/carro.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }

    .contenedor {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .card {
      max-width: 400px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    }

    .card-body {
      padding: 40px;
    }

    .card-title {
      font-size: 24px;
      text-align: center;
      margin-bottom: 30px;
    }

    .input-form {
      position: relative;
      margin-bottom: 20px;
    }

    .input-form input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-bottom: 2px solid #ccc;
      outline: none;
      transition: border-color 0.3s;
    }

    .input-form input:focus {
      border-bottom-color: #007bff;
    }

    .btn-primary {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      border: none;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }
  </style>
<body>
  <div class="container">
    <div class="contenedor">
      <div class="card">
        <div class="card-body">
          <h1 class="card-title">Automovil</h1>
          <form method="post">
            <div class="input-form password-toggle">
              <input class="effect-1" name="placa" id="placa" type="placa" placeholder="placa">
            </div>
            <div class="input-form password-toggle">
              <input class="effect-1" name="marca" id="marca" type="marca" placeholder="marca">
            </div>
            <div class="input-form password-toggle">
              <input class="effect-1" name="dueno" id="dueno" type="dueno" placeholder="dueno">
            </div>
            <input type="submit" name="btn-guardar" class="btn btn-primary" value="enviar">
            <input type="hidden" name="btn-guardar" value="formreg">
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
