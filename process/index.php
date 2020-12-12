<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        input{
            padding:10px;
            margin-top:5px;
            width:500px;
            border-radius:5px;
        }
        button{
            padding:10px;
            background-color:green;
            color:white;
            font-size:14px;
            align:center;
            border-radius:5px;
            cursor:pointer;
        }
        </style>
</head>
<body>
    <form action="index.php" method="GET" style="padding:50px; background-color:grey; border-radius:10px">
        <span>Title</span>
        <input type="text" name="shayari_title"><br>
        <span>Author</span>
        <input type="text" name="shayari_author"><br>
        <span>Description</span>
        <input type="text" name="shayari_description"><br>
        <span>Category</span>
        <input type="text" name="shayari_category"><br> 

        <button name="submit" value="yes">Submit</button>

</form>


</body>
</html>

<?php


if($_GET['submit']=='yes'){

    $title=$_GET['shayari_title'];
    $author=$_GET['shayari_author'];
    $category=$_GET['shayari_category'];
    $description=$_GET['shayari_description'];

    dbConnect();
    $con=$GLOBALS['conObject'];
    insertData('shayari',$con, $title,$author,$category,$description);
    header('index.php');

    mysqli_close($con);



}

function insertData($tbname, $con, $title,$author,$category,$description){

    $sqlInsert="INSERT INTO $tbname(shayari_title, shayari_author, shayari_category, shayari_description) VALUES('".$title."','".$author."','".$category."','".$description."')";
    $result=mysqli_query($con, $sqlInsert);
    if($result){
        echo '<h2>Data inserted ..... sucesss....</h2>';
    }else{
        echo 'Error in inserting data';
    }

}

    function dbConnect(){

        $server="localhost";
        $port=3307;
        $dbname= "4ushayari";
        $password="root";
        $username="root";

        $conn= new mysqli($server,$username,$password,$dbname, $port);

        if($conn){
            $GLOBALS['conObject']=$conn;
        }else{
            echo 'Error in connectivity...';
        }

    }


    function fetchData($tbname){
        $con=$GLOBALS['conObject'];
        $sqlQuery= "SELECT * FROM $tbname";
        $result= mysqli_query($con,$sqlQuery);
        if($result){
            if(mysqli_num_rows($result)>0){
                echo 'data fetching....';
                $i=1;
                while($row=mysqli_fetch_assoc($result)){

                    echo '<br/>------------------------------------------------------------Data row '.$i.'-----------------------------------------------------------------------<br/>';
                    echo ' Author: '.$row['shayari_author'] .'<br/>';
                    echo ' Title: '.$row['shayari_title']. '<br/>';
                    echo ' Description: '.$row['shayari_description'].'<br/>';
                    echo ' Category: '.$row['shayari_category'].'<br/> ';
                    $i++;
                }

                mysqli_close($con);
            }else{
    
                echo 'No any data found..';
            }

        }else{
            echo 'Query execution failed...';
        }
      
    }

    function main(){

        if($_POST['submit']=='yes'){
            fetchData('shayari');
        }else{
            dbConnect();
            fetchData('shayari');
        }
       
    }



    // calling main() method
    main();
?>