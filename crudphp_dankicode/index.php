<?php
    // Configurando a conexão com o banco de dados
    $pdo = new PDO('mysql:host=localhost;dbname=crudphp', 'root', 'toor');
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Função para deletar dados
    if(isset($_GET['delete'])){
        $id = (int)$_GET['delete'];
        $pdo->exec("DELETE FROM clientes WHERE id=$id");
        echo 'Deletado com sucesso!!!';
      
    }

    if(isset($_POST['nome'])){
        $sql = $pdo->prepare("INSERT INTO clientes VALUES (null,?,?)");
        $sql->execute(array($_POST['nome'],$_POST['email']));
        echo 'Inserido com sucesso no BD';
    } else {
        echo 'Erro ao inserir no BD';
    }
?>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome">
    <input type="text" name="email" placeholder="Email">
    <input type="submit" value="Enviar">
</form>

<?php
// Ler dados do banco de dados
$sql = $pdo->prepare("SELECT * FROM clientes");
$sql->execute();

$fetchClientes = $sql->fetchAll();

foreach ($fetchClientes as $key => $value) {
    echo '<a href="?delete='.$value['id'].'">(Dell)</a>'.$value['nome'].' | '.$value['email'].'<br>';
    echo '<hr>';
}
?>

