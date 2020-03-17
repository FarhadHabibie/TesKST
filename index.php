<?php
    function upload() {       
        $conn = mysqli_connect('localhost','root','','test'); //koneksi ke sql   
        if(!$conn)    //cek koneksi mysql
        {
            die(mysqli_error());
        }
        $open = fopen('unsorted-names-list.txt','r'); //read data.txt
        while (!feof($open)) 
            {
                $getTextLine = fgets($open); 
                $explodeLine = array_pad(explode(" ",$getTextLine),4,null); //explode string yg ada di txt 
                list($str1,$str2,$str3,$str4) = $explodeLine;         
                $qry = "insert into kata (`str1`,`str2`,`str3`,`str4`) values('".$str1."','".$str2."','".$str3."','".$str4."')";  //insert to db
                mysqli_query($conn,$qry);
            }

        fclose($open);
    }
 
    function tampil(){
        $conn = mysqli_connect('localhost','root','','test'); //koneksi ke sql   
        if(!$conn)    //cek koneksi mysql
        {
            die(mysqli_error());
        }
        $sql="SELECT * FROM `kata` ORDER BY `kata`.`str4` ASC ,`kata`.`str2` ASC ,`kata`.`str3` DESC " ;
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) 
            {
                $isi = $row['str1']." ".$row['str2']." ".$row['str3']." ".$row['str4']; 
                echo $isi;
                echo "<br>";
            } 
        return $result;
        
    }

    function export(){
        $db =  mysqli_connect('localhost','root','','test');
        if ($stmt = $db->prepare('SELECT * FROM `kata` ORDER BY `kata`.`str4` ASC ,`kata`.`str2` ASC ,`kata`.`str3` DESC ')){

        
            header('Content-type: text/plain');
            header('Content-Disposition: attachment; filename=sorted-names-list.txt');
        
            //Export values to file download
            while ($stmt->fetch()) {
                echo $field;
            }
            $stmt->close();
        }
    }


    upload();// panggil fungsi upload
    tampil();// panggil fungsi tampilkan data
    export();// panggil fungsi export

?>