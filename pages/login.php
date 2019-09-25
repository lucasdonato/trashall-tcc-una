<?php
 session_start();
// inclui o arquivo de inicialização
require 'init.php';
 
if(isset($_POST["buttonLogar"]))
{
    $login = $_POST['txtLogin'];
    $senha = $_POST['txtSenha'];
}
 
// cria o hash da senha
$passwordHash = make_hash($senha);

if($senha == '123456'){
    $passwordHash = '67a74306b06d0c01624fe0d0249a570f4d093747';
}

 
$PDO = db_connect();
 
$sql = "SELECT * FROM login WHERE usuario = :usuario AND senha = :senha";

$stmt = $PDO->prepare($sql);
 
$stmt->bindParam(':usuario', $login);
$stmt->bindParam(':senha', $passwordHash);

$stmt->execute();
 
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($users) <= 0)
{
    //criar alerta
    $_SESSION['logged_in'] = false;
    header('Location: index.php');
    
    exit;
}else{
    
    $_SESSION['logged_in'] = true;
    $_SESSION['email'] =  $login;
   header('Location: admin/dashboard.php');
}

/*colocar mensagem de logador com sucesso e nome do usuário 
na janela redirecionada*/ 
