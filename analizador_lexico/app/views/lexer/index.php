<?php
function e(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analizador Léxico</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f7f7f7; }
        .container { max-width: 1000px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        textarea { width: 100%; height: 120px; padding: 10px; font-size: 16px; }
        button { padding: 10px 18px; font-size: 16px; margin-top: 10px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #222; color: #fff; }
        tr:nth-child(even) { background: #f2f2f2; }
    </style>
</head>
<body>
<div class="container">
    <h1>Analizador Léxico en PHP (MVC)</h1>

    <form method="POST">
        <label for="input">Escribe tu flujo de caracteres:</label>
        <textarea name="input" id="input"><?= e($input ?? '') ?></textarea>
        <br>
        <button type="submit">Analizar</button>
    </form>

    <?php if (!empty($tokens)): ?>
        <h2>Salida de tokens</h2>
        <table>
            <thead>
                <tr>
                    <th>Token</th>
                    <th>Descripción informal</th>
                    <th>Lexema</th>
                    <th>Atributo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tokens as $t): ?>
                    <tr>
                        <td><?= e($t['token']) ?></td>
                        <td><?= e($t['descripcion']) ?></td>
                        <td><?= e($t['lexema']) ?></td>
                        <td><?= e((string)($t['atributo'] ?? '')) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>