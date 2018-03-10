<?php

    require_once "dbConnect.php";
    $goBackURL = "/register";
    $goLoginURL = "/login";

    session_start();

    $famName=$_POST['famName'];
    $famPass=$_POST['famPass'];

//    DB接続の際のglobal変数、dbConnect.php参照
    $db =getDb();

    try {

    //        フォーム入力の値をDBに入れる
        $stm= $db->prepare("INSERT INTO family(name, password) VALUES(:famName, :famPass)");
    //        プリペアドステートメントを作る
//        $stm= $pdo->prepare($sql);
    //        プレースホルダを作る
        $stm->bindValue(':famName', $famName,PDO::PARAM_STR);
        $stm->bindValue(':famPass', $famPass,PDO::PARAM_INT);

    //        sql文を実行
        if($stm->execute()){
            $sql="select * from Family";
    //          プリペアドステートメントを作る
            $stm=$pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $row){
                echo $row["name"];
    //                    echo $row[""];
            }

        }else{
            echo '<span class="error">エラーがありました。 </span><br>';
        }
        $pdo = NULL;
    } catch(Exception $e){
        echo '<span class="error">エラーがありました。 </span><br>';
        echo $e->getMessage();
    }

    $error=[];
    if(!isset($_POST["famName"])||($_POST["famName"]===" ")){
        $error[]="家族名が入っていません";
    }
    if(!isset($_POST["famPass"])||($_POST["famPass"]===" ")){
        $error[]="パスワードが入っていません";
    }

    if(count($error)>0){
        echo '<ol class="error">';
        foreach($error as $value) {
            echo "<li>", $value, "</li>";
        }
        echo "</ol>";
        echo "<hr>";
        echo "<a href=",$goBackURL,">戻る</a>";
        exit();
    }
?>

    ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>ok</title>
</head>
<body>

<a href = ",$goBackURL,">登録完了！</a>
</body>
</html>

