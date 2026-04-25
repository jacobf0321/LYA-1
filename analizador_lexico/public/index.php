<?php

$catalog = require __DIR__ . '/../app/config/tokenCatalog.php';

require_once __DIR__ . '/../app/models/LexerModel.php';
require_once __DIR__ . '/../app/controllers/LexerController.php';

$lexer = new LexerModel($catalog);
$controller = new LexerController($lexer);
$controller->index();