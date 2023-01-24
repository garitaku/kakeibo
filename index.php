<?php
require('dbconnect.php');
//SQL文を準備
require('select.php');
?>

<!-- 
・id → 記録データの番号（オートインクリメント設定）
・date → 日付項目の保存カラム
・title → タイトル項目の保存カラム
・amount → 金額項目の保存カラム
・spending_category → 支出カテゴリー項目の保存カラム
・income_category → 収入カテゴリー項目の保存カラム
・type → 支出か収入かの保存カラム
・payment_method → 支払い方法項目の保存カラム
・credit → クレジットカード選択項目の保存カラム
・qr → QR決済選択項目の保存カラム
・memo → 登録フォーム最下のメモ欄の保存カラム
-->

<!-- メインインサート文の例 -->
<!-- INSERT INTO `main`(`date`, `title`, `amount`, `spending_category`, `type`, `memo`) VALUES ('2023/1/20','スーパー','5000','1','1','生活費'); -->
<!-- ジョインの例 -->
<!-- SELECT * FROM main LEFT JOIN in_out ON in_out.id = main.type LEFT JOIN income_category ON income_category.id = main.income_category LEFT JOIN spending_category ON spending_category.id = main.spending_category; -->

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $("#inout").change(function () {
                $("#category").empty();
                $("#category").append("<option selected>選択</option>");
                if (document.getElementById("inout").value === "1") {
                     //フォーマットした際にphp記述が崩れるので注意！！
                    <?php foreach ($spending as $value) { ?>
                        $("#category").append("<option value='<?php echo $value['id'] ?>'><?php echo $value['spending_name'] ?></option>");
                    <?php } ?>
                } else if (document.getElementById("inout").value === "2") {
                    <?php foreach ($income as $value) { ?>
                        $("#category").append("<option value='<?php echo $value['id'] ?>'><?php echo $value['income_name'] ?></option>");
                    <?php } ?>
                }
                // その他の場合の記載(自由入力できるようにしたいが、機能が複雑になるためいったんコメントアウト)
                // else if (document.getElementById("inout").value === "3") {
                //     $("#category").remove();
                //     $(".category").after('<input type="text" class="form-control" id="category" placeholder="自由入力">');
                // }
            });
            $("#delete").on("click",function () {
                alert("削除ボタンが押されました");                
            });
            $("#edit").on("click",function () {
                alert("編集ボタンが押されました");                
            });
        });
    </script>
    <title>家計簿アプリ</title>

</head>

<body>

    <div class="container">

        <h1>家計簿アプリ</h1>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">日付</th>
                    <th scope="col">タイトル</th>
                    <th scope="col">金額</th>
                    <th scope="col">出入</th>
                    <th scope="col">カテゴリ</th>
                    <th scope="col">Memo</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($main as $list) { ?>
                <tr>
                    <th scope="row"><?php echo $list['main_id']; ?></th>
                    <td><?php echo $list['date']; ?></td>
                    <td><?php echo $list['title']; ?></td>
                    <td><?php echo $list['amount']; ?></td>
                    <td><?php echo $list['in_out_name']; ?></td>
                    <td>
                        <?php
                            if ($list['type']==1) {
                                echo $list['spending_name'];
                            } else {
                                echo $list['income_name'];
                            } ?>
                    </td>
                    <td><?php echo $list['memo']; ?></td>
                    <td>
                        <form class="mb-0" action="delete.php">
                            <button type="submit" id="edit" class="btn btn-warning p-1">編集</button>
                        </form>
                    </td>
                    <td>
                        <form class="mb-0" action="delete.php" method="POST">
                            <button type="submit" id="delete" class="btn btn-danger p-1">削除</button>
                            <input type="hidden" name="main_id" value="<?php echo $list['main_id']; ?>">
                        </form>
                    </td>
                    <td>

                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>


        <form action="insert.php" method="POST">
            <div class="row">
                <div class="mb-3 col-xl-2 col-md-4">
                    <label for="date" class="form-label">日付</label>
                    <input type="text" name="date" class="form-control" id="date" placeholder="日付を入力" >
                </div>
                <div class="mb-3 col-xl-2 col-md-4">
                    <label for="title" class="form-label">タイトル</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="内容を入力" >
                </div>
                <div class="mb-3 col-xl-2 col-md-4">
                    <label for="amount" class="form-label">金額</label>
                    <input type="text" name="amount" class="form-control" id="amount" placeholder="金額を入力">
                </div>
                <div class="mb-3 col-xl-2 col-md-4">
                    <label for="inout" class="form-label">出入</label>
                    <select class="form-select" id="inout" name="inout">
                        <option selected>選択</option>
                        <?php foreach ($in_out as $value) { ?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['in_out_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3 col-xl-2 col-md-4">
                    <label for="category" class="form-label category">カテゴリ</label>
                    <select class="form-select" id="category" name="category">
                        <option selected>選択</option>
                    </select>
                </div>
                <div class="mb-3 col-xl-2 col-md-4">
                    <label for="memo" class="form-label">メモ</label>
                    <input type="text" name="memo" class="form-control" id="memo" placeholder="メモを入力">
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">送信</button>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    </div>

</body>

</html>