<?php

require_once __DIR__ . '/../models/LexerModel.php';
require_once __DIR__ . '/../models/SemanticAnalyzer.php'; // 1. Requerimos el nuevo modelo

class LexerController
{
    private LexerModel $lexer;
    private SemanticAnalyzer $semanticAnalyzer; // 2. Añadimos la propiedad

    // 3. Inyectamos el analizador semántico en el constructor
    public function __construct(LexerModel $lexer, SemanticAnalyzer $semanticAnalyzer)
    {
        $this->lexer = $lexer;
        $this->semanticAnalyzer = $semanticAnalyzer;
    }

    public function index(): void
    {
        $input = $_POST['input'] ?? '';
        $tokens = [];
        
        // Inicializamos las variables para la vista
        $semanticResult = [
            'success' => true,
            'errors' => [],
            'symbolTable' => []
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // A) Obtenemos los tokens del Lexer
            $tokens = $this->lexer->tokenize($input);
            
            // B) Corremos el Analizador Semántico usando esos tokens
            $semanticResult = $this->semanticAnalyzer->analyze($tokens);
        }

        // Al cargar la vista, tendrás disponibles: $tokens y $semanticResult
        require __DIR__ . '/../views/lexer/index.php';
    }
}