<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title></title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <?php
      include_once("config.php");

      $sku = $_GET['sku'];
      $id = $_GET['id'];

      $skuArr = explode(",", $sku);

      $link = mysql_connect($host, $user, $password) or die("Не удалось подключится
      к MySQL".mysql_error());
      mysql_select_db($db, $link) or die("Не удлаось подключится к БД".mysql_error());
      mysql_set_charset (utf8);

      $linkAd = mysql_connect($hostAd, $userAd, $passwordAd) or die("Не удалось
        подключиться к MySQL ad" . mysql_error());
      mysql_select_db($dbAd, $linkAd) or die("Не удалось
        подключиться к MySQL ad" . mysql_error());
      mysql_set_charset (utf8);
      $ad = mysql_fetch_assoc(mysql_query("SELECT * FROM ads WHERE id
        = $id;", $linkAd));
      $nameAd = $ad['name'];
      $descriptionAd = $ad['description'];
    ?>
    <br>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <?php
            echo "<p>" . $nameAd . "</p>";
            foreach ($skuArr as $value) {
              $product = mysql_fetch_assoc(mysql_query("SELECT * FROM oc_product WHERE sku
                = $value;", $link));
              $price = round($product['price'], 2);
              $productId = $product['product_id'];
              $productDescription = mysql_fetch_assoc(mysql_query("SELECT * FROM
                oc_product_description WHERE product_id
                = $productId;", $link));
              $productName = $productDescription['name'];

              echo "<p>" . $productName . " - " . $price . " руб. </p>";
            }
            echo "<p>" . nl2br($descriptionAd) . "</p>";
          ?>
        </div>
      </div>
    </div>
    <?php
      mysql_close($link);
    ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
