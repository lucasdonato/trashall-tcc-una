<?php
 session_start();
// inclui o arquivo de inicialização
require 'init.php';

if (isset($_POST['txtLogin'])) {
    

    $login = $_POST['txtLogin'];
    $senha = $_POST['txtSenha'];

    
    // cria o hash da senha
    $passwordHash = make_hash($senha);

    if($senha == '123456'){
        $passwordHash = '67a74306b06d0c01624fe0d0249a570f4d093747';
    }

    
    $PDO = db_connect();
    
    $sql = "SELECT * FROM login WHERE usuario = :usuario AND senha = :senha AND ativo = '1'";

    $stmt = $PDO->prepare($sql);
    
    $stmt->bindParam(':usuario', $login);
    //$stmt->bindParam(':senha', $passwordHash);
    $stmt->bindParam(':senha', $senha);

    $stmt->execute();
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) <= 0)
    {
        
        $_SESSION['logged_in'] = false;
        echo "0";
    
    }else{
        $_SESSION['tipo_entidade'] = $users[0]['tipo_entidade'];
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] =  $login;
        $array = [
            "success" => "1",
            "tipo_entidade" => $users[0]['tipo_entidade'],
        ];
        echo json_encode($array);
    }
}