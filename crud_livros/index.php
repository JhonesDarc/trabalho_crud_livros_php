    <?php
        session_start();
        if (!isset($_SESSION['pessoas'])){
            $_SESSION['pessoas'] = [];
        }
        if (empty($_SESSION['pessoas'])){
            $dados = json_decode(file_get_contents("pessoas.json"), true);
            $_SESSION['pessoas'] = $dados;
        }
        $id_edicao = null;
        $nome_edicao = '';
        $livro_edicao = '';
        $genero_edicao = ['Romance','Suspense','Drama','Comedia','Aventura','Fantasia','Ficcão','poesia','cordel','quadreinhos','manga'];
        $nota_edicao = [1,2,3,4,5,6,7,8,9,10];
        $modo_edicao = false;
        //coração do CRUD
        //DELETE via GET
        if(isset($_GET['acao']) && $_GET['acao'] == 'deletar' && isset($_GET['id'])) {
            $id_para_deletar = $_GET['id'];   
        }foreach ($_SESSION['pessoas'] as $indice => $pessoa){
            if($pessoa['id'] == $id_para_deletar){
                    unset($_SESSION['pessoas'][$indice]);
                    break;
                }
            }
            header('Location: index.php');
            exit;
            //Preparar a edição
            if(isset($_GET['acao']) && $_GET['acao'] == 'editar' && isset($_GET['id'])){
            $id_para_editar = $_GET['id'];
            foreach ($_SESSION['pessoas'] as $pessoa){
                if ($pessoa['id'] == $id_para_editar){
                    $id_edicao = $pessoa['id'];
                    $nome_edicao = $pessoa['nome'];
                    $livro_edicao = $pessoa['livro'];
                    $nota_edicao =$pessoa['nota'];
                    $genero_edicao = $pessoa['genero'];
                    $modo_edicao = true; //ativa a edicao no form
                    break;
                }
            }
        }
        //criar e atualizar via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $livro = $_POST['livro'];
            $genero =$_POST['genero'];
            $nota = $_POST['nota'];
            //atualizar
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $id_para_atualizar = $_POST['id'];
                foreach ($_SESSION['pessoas'] as $indice => $pessoa) {
                    if ($pessoa['id'] == $id_para_atualizar) {
                        $_SESSION['pessoas'][$indice]['nome'] = $nome;
                        $_SESSION['pessoas'][$indice]['livro'] = $livro;
                        $_SESSION['pessoas'][$indice]['genero'] = $genero;
                        $_SESSION['pessoas'][$indice]['nota'] = $nota;
                        break;
                    }
                }
            }
            //criar    
            else {
                $nova_pessoa = [
                    'id' => uniqid(),
                    'nome' => $nome,
                    'livro' => $livro,
                    'genero' => $genero,
                    'nota' => $nota
                ];
                $_SESSION['pessoas'][] = $nova_pessoa;
            }
            header('Location: index.php');
            exit;
        }
    ?>
    