<?php
function caminhoDocumentos(array $camposConfig): array {
  $caminhos = [];

  foreach ($camposConfig as $nomeCampo => $config) {
    if (!isset($_FILES[$nomeCampo])) {
      throw new RuntimeException("Campo de upload '$nomeCampo' não encontrado.");
    }

    $ficheiro = $_FILES[$nomeCampo];
    $tipos = $config['tipos'] ?? ['pdf'];
    $pasta = $config['destino'] ?? 'outros';
    $maxMB = $config['max'] ?? 10;

    $extensao = strtolower(pathinfo($ficheiro['name'], PATHINFO_EXTENSION));
    if (!in_array($extensao, $tipos)) {
      throw new RuntimeException("O ficheiro '$nomeCampo' tem tipo inválido. Permitido: " . implode(', ', $tipos));
    }

    if ($ficheiro['error'] !== 0) {
      throw new RuntimeException("Erro ao carregar o ficheiro '$nomeCampo'.");
    }

    if ($ficheiro['size'] > $maxMB * 1024 * 1024) {
      throw new RuntimeException("O ficheiro '$nomeCampo' excede o tamanho máximo de $maxMB MB.");
    }

    $nomeFinal = uniqid($nomeCampo . '_', true) . '.' . $extensao;
    $destinoFinal = __DIR__ . "/../documentos/$pasta/" . $nomeFinal;

    if (!move_uploaded_file($ficheiro['tmp_name'], $destinoFinal)) {
      throw new RuntimeException("Falha ao mover o ficheiro '$nomeCampo'.");
    }

    $caminhos[$nomeCampo] = "documentos/$pasta/" . $nomeFinal;
  }

  return $caminhos; // ex: ['doc_cc' => 'documentos/cc/abc123.pdf', ...]
}

?>