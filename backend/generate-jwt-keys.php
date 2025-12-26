<?php

$keyDir = __DIR__ . '/config/jwt';

// Créer le dossier s'il n'existe pas
if (!is_dir($keyDir)) {
    mkdir($keyDir, 0755, true);
}

// Configuration
$config = [
    "private_key_bits" => 4096,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
];

// Générer la clé privée
$res = openssl_pkey_new($config);
openssl_pkey_export($res, $privateKey);

// Générer la clé publique
$publicKey = openssl_pkey_get_details($res);
$publicKey = $publicKey["key"];

// Sauvegarder les clés
file_put_contents($keyDir . '/private.pem', $privateKey);
file_put_contents($keyDir . '/public.pem', $publicKey);

echo "✅ Clés JWT générées avec succès !\n";
echo "📁 Emplacement : config/jwt/\n";