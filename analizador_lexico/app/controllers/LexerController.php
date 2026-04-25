<?php

require_once __DIR__ . '/../models/LexerModel.php';

class LexerController
{
    private LexerModel $lexer;

    public function __construct(LexerModel $lexer)
    {
        $this->lexer = $lexer;
    }

    public function index(): void
    {
        $input = $_POST['input'] ?? '';
        $tokens = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tokens = $this->lexer->tokenize($input);
        }

        require __DIR__ . '/../views/lexer/index.php';
    }
}