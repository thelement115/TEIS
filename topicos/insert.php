<?php
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    if (!empty($Name) || !empty($Email)){
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "topicos1";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
        if(mysqli_connect_error()){
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        } else{
            /*preparo la consulta y me fijo que no se este insertando información repetida*/
            $SELECT = "SELECT Email From php1 Where Email = ? Limit 1";
            $INSERT = "INSERT Into php1 (Name, Email) values(?, ?)";
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s",$Email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum= $stmt-> num_rows();
            /* si no esta repetida, guardo la información*/
            if($rnum==0){
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ss",$Name, $Email);
                $stmt->execute();
                echo "New record inserted sucessfully";
            }else{
                echo "someone already register with this email";
            }
            $stmt->close();
            $conn->close();
        }
    } 
    else{
        echo "All fields are required";
        die();
    }
?>