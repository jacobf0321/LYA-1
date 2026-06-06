<?php

// 1. Requerimos los dos modelos y el controlador
require_once __DIR__ . '/../app/models/LexerModel.php';
require_once __DIR__ . '/../app/models/SemanticAnalyzer.php';
require_once __DIR__ . '/../app/controllers/LexerController.php';

// 2. Cargamos el catálogo de tokens necesario para el Lexer
$catalog = require __DIR__ . '/../app/config/tokenCatalog.php';

// 3. Instanciamos ambos analizadores por separado
$lexer = new LexerModel($catalog);
$semanticAnalyzer = new SemanticAnalyzer();

// 4. Pasamos AMBOS objetos al constructor del controlador (aquí se corrige tu error)
$controller = new LexerController($lexer, $semanticAnalyzer);

// 5. Ejecutamos la acción principal
$controller->index();