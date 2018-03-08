
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>FamilyTwi</title>
    <link href='//fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
</head>
<body>
<h1>FamTwi</h1>
<div>新規登録</div>
<form class="register" method="post" action="/register">
    <div>
        <span>FamilyName</span>
        <input type="text" class="famName">
    </div>
    <div>
        <span>Password</span>
        <input type="text" class="famPass">
    </div>
    <div>
        <input type="submit" value="登録">
    </div>
    <div>
        <?php

        $gobackURL="/register";

        $famName=$_POST['famName'];
        $famPass=$_POST['famPass'];


        $error=[];
        if(!isset($_POST["famName"])||($_POST["famName"]===" ")){
            $error[]="家族名が入っていません";
        }
        if(!isset($_POST["famPass"])||($_POST["famPass"]===" ")){
            $error[]="パスワードが入っていません";
        }

        if(count($error)>0){
            echo '<ol class="error">';
            foreach($error as $value){
                echo "<li>", $value,"</li>";
            }
            echo "</ol>";
            echo "<hr>";
            echo "<a href=",$gobackURL,">戻る</a>";
            exit();
        }

        $user='twitter';
        $password='twitter';
        $dbName='Twitter';
        $host='localhost:8889';
        $dsn="mysql:host={$host};dbname={$dbName};charset=utf8";

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected Database Success!!";

//        フォーム入力の値をDBに入れる
            $sql="INSERT INTO family(name, password) VALUES(:famName, :famPass)";
//        プリペアドステートメントを作る
            $stm= $pdo->prepare($sql);
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

        ?>

    </div>
</form>
</body>
</html>
