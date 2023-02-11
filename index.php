<?php
session_start();
/**
 * Author : Zénas M. MOMONZO
 * Email : zenasmomonzo@gmail.com
 * GitHub : https://github.com/mHanash/
 * @Copyright 2023
 */
require_once './FeistelCipher/generateKeys.php';
require_once './FeistelCipher/encryption.php';
require_once './FeistelCipher/decryption.php';


if (isset($_POST['decryptSend'])) {

    if (isset($_SESSION['keys'])) {
        $keys = $_SESSION['keys'];
        $decrypt = [];
        for ($i = 0; $i < 8; $i++) {
            $index = "decrypt-" . $i;
            $decrypt[] = $_POST[$index];
        }

        $decryptPermute = [];
        for ($i = 0; $i < 8; $i++) {
            $index = "decryptPermute-" . $i;
            $decryptPermute[] = $_POST[$index];
        }
        $error = false;
        $decryption = decryption($decrypt, $decryptPermute, [2, 0, 1, 3], $keys['keyOne'], $keys['keyTwo']);
        $stringDecrypt = "";
        foreach ($decryption as $key => $value) {
            if ($key === 'erreur') {
                $error = true;
            }
            $stringDecrypt .= $value;
        }
    }
}
if (isset($_SESSION['keys'])) {
    $keys = $_SESSION['keys'];
    $stringKeysOne = '';
    foreach ($keys['keyOne'] as $key => $value) {
        if ($key === 'erreur') {
            $error = true;
        }
        $stringKeysOne .= $value;
    }
    $stringKeysTwo = '';
    foreach ($keys['keyTwo'] as $key => $value) {
        if ($key === 'erreur') {
            $error = true;
        }
        $stringKeysTwo .= $value;
    }
}
if (isset($_POST['keySubmit'])) {
    $keys = [];
    session_unset();
    $inputKeys = [];
    for ($i = 0; $i < 8; $i++) {
        $index = "key-" . $i;
        $inputKeys[] = $_POST[$index];
    }

    $keyPermute = [];
    for ($i = 0; $i < 8; $i++) {
        $index = "keyPermute-" . $i;
        $keyPermute[] = $_POST[$index];
    }
    $keys = (generateKeys($inputKeys, $keyPermute));
    $_SESSION['keys'] = $keys;
    $stringKeysOne = '';
    foreach ($keys['keyOne'] as $key => $value) {
        if ($key === 'erreur') {
            $error = true;
        }
        $stringKeysOne .= $value;
    }
    $stringKeysTwo = '';
    foreach ($keys['keyTwo'] as $key => $value) {
        if ($key === 'erreur') {
            $error = true;
        }
        $stringKeysTwo .= $value;
    }
}
if (isset($_POST['encryptSubmit'])) {
    if (isset($_SESSION['keys'])) {
        $keys = $_SESSION['keys'];
        $error = false;
        $data = [];
        for ($i = 0; $i < 8; $i++) {
            $index = "data-" . $i;
            $data[] = $_POST[$index];
        }

        $dataPermute = [];
        for ($i = 0; $i < 8; $i++) {
            $index = "dataPermute-" . $i;
            $dataPermute[] = $_POST[$index];
        }

        $encryption = encryption($data, $dataPermute, [2, 0, 1, 3], $keys['keyOne'], $keys['keyTwo']);

        $stringData = "";
        foreach ($encryption as $key => $value) {
            if ($key === 'erreur') {
                $error = true;
            }
            $stringData .= $value;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/code.css">
    <title>Algo Sécurité</title>
    <script src="/js/vue.js"></script>
</head>

<body>
    <div id="app">
        <nav class="navbar justify-content-center navbar-dark bg-dark">
            <a class="navbar-brand" href="#">
                Sécurité : Travail pratique
            </a>
            <a class="nav-link" target="_blank" href="https://github.com/mHanash" style="float:right">Par MOMONZO MUSONGI Zénas</a>
        </nav>
        <div class="container">
            <div class="card mt-1">
                <div class="card-body">
                    <h5 class="card-title">Feistel Cipher</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form" action="" method="post">
                                <h6 class="card-title">Générations des clés</h6>
                                <fieldset class='number-code'>
                                    <legend>Bloc d'entré</legend>
                                    <div>
                                        <input @keyup="verify" type="number" name='key-0' class='code-input g1' required />
                                        <input @keyup="verify" type="number" name='key-1' class='code-input g1' required />
                                        <input @keyup="verify" type="number" name='key-2' class='code-input g1' required />
                                        <input @keyup="verify" type="number" name='key-3' class='code-input g1' required />
                                        <input @keyup="verify" type="number" name='key-4' class='code-input g1' required />
                                        <input @keyup="verify" type="number" name='key-5' class='code-input g1' required />
                                        <input @keyup="verify" type="number" name='key-6' class='code-input g1' required />
                                        <input @keyup="verify" type="number" name='key-7' class='code-input g1' required />
                                    </div>
                                    <p v-if="error1" class="text-danger" style="font-size: 10px">{{message1}}</p>
                                </fieldset>
                                <fieldset class='number-code'>
                                    <legend>La permutation</legend>
                                    <div>
                                        <input @keyup="verifyKeyPermute" type="number" name='keyPermute-0' class='code-input g2' required />
                                        <input @keyup="verifyKeyPermute" type="number" name='keyPermute-1' class='code-input g2' required />
                                        <input @keyup="verifyKeyPermute" type="number" name='keyPermute-2' class='code-input g2' required />
                                        <input @keyup="verifyKeyPermute" type="number" name='keyPermute-3' class='code-input g2' required />
                                        <input @keyup="verifyKeyPermute" type="number" name='keyPermute-4' class='code-input g2' required />
                                        <input @keyup="verifyKeyPermute" type="number" name='keyPermute-5' class='code-input g2' required />
                                        <input @keyup="verifyKeyPermute" type="number" name='keyPermute-6' class='code-input g2' required />
                                        <input @keyup="verifyKeyPermute" type="number" name='keyPermute-7' class='code-input g2' required />
                                    </div>
                                    <p v-if="error2" class="text-danger" style="font-size: 10px">{{message2}}</p>
                                </fieldset>
                                <span class="text-primary">RESULTAT : <?= (isset($stringKeysOne)) ? "Prémière clé = " . $stringKeysOne : '' ?> <?= (isset($stringKeysTwo)) ? "Clé deuxième = " . $stringKeysTwo : '' ?></span><br />
                                <button name="keySubmit" type="submit" class="btn-sm btn btn-primary">Générer</button>
                            </form>
                            <form class="form" action="" method="post">
                                <h6 class="card-title mt-3">Chiffrement</h6>
                                <fieldset class='number-code'>
                                    <legend>Bloc d'entré</legend>
                                    <div>
                                        <input @keyup="verifyData" type="number" name='data-0' class='code-input g3' required />
                                        <input @keyup="verifyData" type="number" name='data-1' class='code-input g3' required />
                                        <input @keyup="verifyData" type="number" name='data-2' class='code-input g3' required />
                                        <input @keyup="verifyData" type="number" name='data-3' class='code-input g3' required />
                                        <input @keyup="verifyData" type="number" name='data-4' class='code-input g3' required />
                                        <input @keyup="verifyData" type="number" name='data-5' class='code-input g3' required />
                                        <input @keyup="verifyData" type="number" name='data-6' class='code-input g3' required />
                                        <input @keyup="verifyData" type="number" name='data-7' class='code-input g3' required />
                                    </div>
                                    <p v-if="error3" class="text-danger" style="font-size: 10px">{{message1}}</p>
                                </fieldset>
                                <fieldset class='number-code'>
                                    <legend>La permutation</legend>
                                    <div>
                                        <input @keyup="verifyDataPermute" type="number" name='dataPermute-0' class='code-input g4' required />
                                        <input @keyup="verifyDataPermute" type="number" name='dataPermute-1' class='code-input g4' required />
                                        <input @keyup="verifyDataPermute" type="number" name='dataPermute-2' class='code-input g4' required />
                                        <input @keyup="verifyDataPermute" type="number" name='dataPermute-3' class='code-input g4' required />
                                        <input @keyup="verifyDataPermute" type="number" name='dataPermute-4' class='code-input g4' required />
                                        <input @keyup="verifyDataPermute" type="number" name='dataPermute-5' class='code-input g4' required />
                                        <input @keyup="verifyDataPermute" type="number" name='dataPermute-6' class='code-input g4' required />
                                        <input @keyup="verifyDataPermute" type="number" name='dataPermute-7' class='code-input g4' required />
                                    </div>
                                    <p v-if="error4" class="text-danger" style="font-size: 10px">{{message2}}</p>
                                </fieldset>
                                <span class="text-primary">RESULTAT : <?= isset($_POST['encryptSubmit']) ? 'La valeur chiffrer est : ' . $stringData : '' ?></span><br />
                                <button name="encryptSubmit" type="submit" <?= (isset($_SESSION['keys']) ? '' : 'disabled') ?> class="btn-sm btn btn-primary">Chiffrement</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="" method="post">
                                <h6 class="card-title">Déchiffrement</h6>
                                <fieldset class='number-code'>
                                    <legend>Bloc d'entré</legend>
                                    <div>
                                        <input @keyup="verifyDecrypt" type="number" name='decrypt-0' class='code-input g5' required />
                                        <input @keyup="verifyDecrypt" type="number" name='decrypt-1' class='code-input g5' required />
                                        <input @keyup="verifyDecrypt" type="number" name='decrypt-2' class='code-input g5' required />
                                        <input @keyup="verifyDecrypt" type="number" name='decrypt-3' class='code-input g5' required />
                                        <input @keyup="verifyDecrypt" type="number" name='decrypt-4' class='code-input g5' required />
                                        <input @keyup="verifyDecrypt" type="number" name='decrypt-5' class='code-input g5' required />
                                        <input @keyup="verifyDecrypt" type="number" name='decrypt-6' class='code-input g5' required />
                                        <input @keyup="verifyDecrypt" type="number" name='decrypt-7' class='code-input g5' required />
                                    </div>
                                    <p v-if="error5" class="text-danger" style="font-size: 10px">{{message1}}</p>
                                </fieldset>
                                <fieldset class='number-code'>
                                    <legend>La permutation</legend>
                                    <div>
                                        <input @keyup="verifyDecryptPermute" type="number" name='decryptPermute-0' class='code-input g6' required />
                                        <input @keyup="verifyDecryptPermute" type="number" name='decryptPermute-1' class='code-input g6' required />
                                        <input @keyup="verifyDecryptPermute" type="number" name='decryptPermute-2' class='code-input g6' required />
                                        <input @keyup="verifyDecryptPermute" type="number" name='decryptPermute-3' class='code-input g6' required />
                                        <input @keyup="verifyDecryptPermute" type="number" name='decryptPermute-4' class='code-input g6' required />
                                        <input @keyup="verifyDecryptPermute" type="number" name='decryptPermute-5' class='code-input g6' required />
                                        <input @keyup="verifyDecryptPermute" type="number" name='decryptPermute-6' class='code-input g6' required />
                                        <input @keyup="verifyDecryptPermute" type="number" name='decryptPermute-7' class='code-input g6' required />
                                    </div>
                                    <p v-if="error6" class="text-danger" style="font-size: 10px">{{message2}}</p>
                                </fieldset>
                                <span class="text-primary">RESULTAT : <?= isset($_POST['decryptSend']) ? 'La valeur déchiffrer est : ' . $stringDecrypt : '' ?></span><br />
                                <button <?= (isset($_SESSION['keys']) ? '' : 'disabled') ?> name="decryptSend" type="submit" class="btn-sm btn btn-primary">Déchiffrer</button>
                            </form>

                            <div class=" mt-3 p-2 card">
                                Note : Pour utiliser ce programme, veuillez suivre ces étapes :
                                <ul>
                                    <li>Entrez la valeur de l'entrée pour générer les clés,</li>
                                    <li>Entrez la valeur de la permutation,</li>
                                    <li>Entrez la valeurs du message à chiffer ou déchiffrer ( en binaire ),</li>
                                    <li>Renseigner la permutation,</li>
                                </ul>
                                <p>Pour la permutation interne au calcul des bloc, on a fixé la valeur à 2013.</p>
                            </div>
                            @Copyright 2023 Zén's
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/bootstrap.min.js"></script>
    <!-- <script src="/js/code.js"></script> -->
    <script src="/js/style.js"></script>
</body>

</html>