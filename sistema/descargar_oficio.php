<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $lugar = $_POST['lugar'] ?? '';
        $fecha = $_POST['fecha'] ?? '';
        $dirigidoA = $_POST['dirigidoA'] ?? '';
        $cargo = $_POST['cargo'] ?? '';
        $contenido = $_POST['contenido'] ?? '';

        // Verificar si las claves existen en $_POST, de lo contrario inicializarlas como arrays vacíos
        $puestos = isset($_POST['puesto']) ? $_POST['puesto'] : [];
        $nombres = isset($_POST['nombre']) ? $_POST['nombre'] : [];
        $firmas = isset($_POST['firma']) ? $_POST['firma'] : [];

        // Crear un nuevo objeto de PHPWord
        $phpWord = new PhpWord();

        // Añadir una sección
        $section = $phpWord->addSection();

        // Añadir contenido al documento
        $section->addText($lugar, ['bold' => true]);
        $section->addText($fecha);
        $section->addTextBreak(2); // Saltos de línea
        $section->addText('OFICIO ACEPTACIÓN DE LA CARGA ACADÉMICA TOTAL', ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $section->addTextBreak(1);
        $section->addText('Dirigido a: ' . $dirigidoA);
        $section->addText('Cargo: ' . $cargo);
        $section->addTextBreak(2);
        $section->addText($contenido);
        $section->addTextBreak(2);
        $section->addText('ATENTAMENTE', ['bold' => true]);

        // Añadir la tabla de firmas
        $table = $section->addTable();

        // Solo agregar filas a la tabla si hay datos en los arrays
        if (!empty($puestos) && !empty($nombres) && !empty($firmas)) {
            for ($i = 0; $i < count($puestos); $i++) {
                $table->addRow();
                $table->addCell(2000)->addText($puestos[$i]);
                $table->addCell(5000)->addText($nombres[$i]);
                $table->addCell(3000)->addText($firmas[$i]);
            }
        }

        // Guardar el archivo
        $fileName = "oficio.docx";
        $temp_file = tempnam(sys_get_temp_dir(), 'phpword_');
        $phpWord->save($temp_file, 'Word2007');

        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        readfile($temp_file);
        unlink($temp_file);
        exit;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
