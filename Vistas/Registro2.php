<?php 

include '../DAO/MetodosDAO.php';

        if (isset($_REQUEST ['btnEnviar'])) {
            $nom=$_REQUEST['txtNom'];
            $cor=$_REQUEST['txtCor'];
            $pas=$_REQUEST['txtPas'];

            $objCli=new Cliente(0, $nom, $cor, $pas);

            $metodos=new MetodosDAO();
            $i=$metodos->RegistrarCliente ($objCli);

            if ($i==1)
          header ("location: Cesta.php");
          
            else
             header ("location: Catalogo.php?error=no se inserto el registro");

}

?>



