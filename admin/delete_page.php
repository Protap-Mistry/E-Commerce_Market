<?php 
    include 'include/header.php'; 
    include 'include/sidebar.php';
?>


<?php 
    $format= new Format();

    if(!isset($_GET['delete_id']) || $_GET['delete_id']== null){
        echo "Ooops!!! no pages found.";
    }
    else
    {
        $id= $_GET['delete_id'];

        $delete_page= $format->deletePage($id);
        
        if($delete_page){
            echo $delete_page;
        }
    }
?>
