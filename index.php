<!DOCTYPE html>
<html lang="et">
   <head>
      <title>Hinnapakkumine</title>
      
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      
      <!-- JQuery -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

      <!-- Own CSS file -->
      <link rel="stylesheet" type="text/css" href="assets/css/native.css">

      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      
      <!-- Own javascript file -->
      <script src="assets/js/functions.js"></script>

      <!-- Google ReCaptcha -->
      <script src='https://www.google.com/recaptcha/api.js'></script>
   </head>
   <?php
      //PHPMailer
      include('assets/PHPMailer/PHPMailerAutoload.php');
      
      //developer options
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
      //var_dump($_POST);
      
      $uploaddir = 'uploads/'; //upload directory
      $uploaddomain = "http://hinnaparing.ee.dev.kreative.ee/uploads/"; //sama path, but via domain name
      
      //array for storing uploaded picture URL's
      $pildid = array();

      //if form submitted
      if(isset($_POST['nimi'])) {
      
      // let's load resources
      $curl = curl_init();
      
      // Google reCaptcha definitions.
      curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => array(
        'secret' => '6Lc5lxEUAAAAAJvFF5FvtcnELGTXAWPEEECbRrdJ',
        'response' => $_POST['g-recaptcha-response']
      )
      ));
      
      // let's send stuff
      $resp = curl_exec($curl);
      
      // free memory
      curl_close($curl);
      
      // let's check status of captcha
      if(strpos($resp, '"success": true') !== FALSE) {
      
      //reCaptcha solved successfully
      
      //vehicle details
      $mark = htmlspecialchars($_POST['mark']);
      $mudel = htmlspecialchars($_POST['mudel']);
      $aasta = htmlspecialchars($_POST['aasta']);
      $mootor = htmlspecialchars($_POST['mootor']);
      $kytus = htmlspecialchars($_POST['kytus']);
      $ulevaatus = htmlspecialchars($_POST['ulevaatus']);
      
      //contact details
      $nimi = htmlspecialchars($_POST['nimi']);
      $email = htmlspecialchars($_POST['email']);
      $telefon = htmlspecialchars($_POST['telefon']);
      
      //comments
      $kommentaarid = htmlspecialchars($_POST['muu']);
      
      //desired price
      $hind = htmlspecialchars($_POST['price']);
      
      //crafting file upload link
      $today = date("Ymd");
      $uploadlocation = $uploaddir . $today . "_" . $telefon . "_";
      
      
      //uploading image files
      if(isset($_FILES['image1'])) {
        $uploadfile = $uploadlocation . basename($_FILES['image1']['name']);
        if (move_uploaded_file($_FILES['image1']['tmp_name'], $uploadfile)) {
          //ok
          $uploadfile = $uploaddomain . $today . "_" . $telefon . "_" . basename($_FILES['image1']['name']);
          array_push($pildid, $uploadfile);
        } else {
          //echo("image1_err");
        }
      }
        if(isset($_FILES['image2'])) {
          $uploadfile = $uploadlocation . basename($_FILES['image2']['name']);
          if (move_uploaded_file($_FILES['image2']['tmp_name'], $uploadfile)) {
            //ok
            $uploadfile = $uploaddomain . $today . "_" . $telefon . "_" . basename($_FILES['image2']['name']);
            array_push($pildid, $uploadfile);
          } else {
            //echo("image1_err");
          }
        }
        if(isset($_FILES['image3'])) {
          $uploadfile = $uploadlocation . basename($_FILES['image3']['name']);
          if (move_uploaded_file($_FILES['image3']['tmp_name'], $uploadfile)) {
            $uploadfile = $uploaddomain . $today . "_" . $telefon . "_" . basename($_FILES['image3']['name']);
            array_push($pildid, $uploadfile);
            //ok
          } else {
            //echo("image1_err");
          }
        }
        if(isset($_FILES['image4'])) {
          $uploadfile = $uploadlocation . basename($_FILES['image4']['name']);
          if (move_uploaded_file($_FILES['image4']['tmp_name'], $uploadfile)) {
            $uploadfile = $uploaddomain . $today . "_" . $telefon . "_" . basename($_FILES['image4']['name']);
            array_push($pildid, $uploadfile);
            //ok
          } else {
            //echo("image1_err");
          }
        }
        if(isset($_FILES['image5'])) {
          $uploadfile = $uploadlocation . basename($_FILES['image5']['name']);
          if (move_uploaded_file($_FILES['image5']['tmp_name'], $uploadfile)) {
            $uploadfile = $uploaddomain . $today . "_" . $telefon . "_" . basename($_FILES['image5']['name']);
            array_push($pildid, $uploadfile);
            //ok
          } else {
            //echo("image1_err");
          }
        }
      
      //start mail instance
      $mail = new PHPMailer;
      
      //$mail->SMTPDebug = 3;                               // Enable verbose debug output
      
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8';                                   // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'xxx';                 // SMTP username
      $mail->Password = 'xxx';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to
      
      $mail->setFrom('xxx', 'Hinnapakkumine');
      $mail->addAddress('xxx', 'Karl Erik Õunapuu');     // Add a recipient
      //$mail->addAttachment('uploads/kana.jpeg'); 
      $mail->isHTML(true);                                  // Set email format to HTML
      
      $mail->Subject = 'Uus hinnapakkumine: ' . $nimi;

      $aadress = "";

      foreach ($pildid as $url) {
        $aadress .= $url . "<br>";
      }

      $mail->Body    = 'Teile on saabunud uus sõiduki hinnapakkumine isikult ' . $nimi . '.<br><br><b>Sõiduki andmed:</b><br>
      Mark: ' . $mark . '<br>
      Mudel: ' . $mudel . '<br>
      Aasta: ' . $aasta . '<br>
      Mootor: ' . $mootor . '<br>
      Kütus: ' . $kytus . '<br>
      Ülevaatus: ' . $ulevaatus . '<br>
      Soovitav hind: ' . $hind . '<br><br>
      <b>Kontaktandmed:</b><br>
      Nimi: ' . $nimi . '<br>
      Email: ' . $email . '<br>
      Telefon: ' . $telefon . '<br><br>
      Kommentaarid: ' . $kommentaarid . '<br><br>
      <b>Pildid:</b><br>' . $aadress . '<br>';


      $mail->AltBody = 'Sebi omale HTML toega veebipostkast';
      
      if(!$mail->send()) {
        print('<div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        <span class="sr-only">Viga:</span>
        Viga hinnapakkumise saatmisel. Proovige hiljem uuesti..
        </div>');
      } else {
        print('<div class="alert alert-success" role="alert">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        <span class="sr-only">Aitäh:</span>
        Saime teie hinnapakkumise kätte. Võtame teiega peatselt ühendust.
        </div>');
      } //mailsend
      
      } else {
        print('<div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Viga:</span>
        Te ei läbinud Google robotitesti.
        </div>');
      }
      } else {
      //echo "form_not_sent";
      }
      //var_dump($pildid);
      ?>
   <br>
   <form enctype="multipart/form-data" class="form-horizontal" method="post" action="">
      <fieldset>
         <!-- Text input-->
         <div class='container'>
            <!-- Ülevaade -->
            <div class="row form-group">
               <div class="col-xs-12">
                  <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                     <li class="active">
                        <a href="#step-1">
                           <h4 class="list-group-item-heading">1. samm</h4>
                           <p class="list-group-item-text">Auto informatsioon</p>
                        </a>
                     </li>
                     <li class="disabled">
                        <a href="#step-2">
                           <h4 class="list-group-item-heading">2. samm</h4>
                           <p class="list-group-item-text">Vali pildid</p>
                        </a>
                     </li>
                     <li class="disabled">
                        <a href="#step-3">
                           <h4 class="list-group-item-heading">3. samm</h4>
                           <p class="list-group-item-text">Kontaktinformatsioon</p>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
            <!-- Esimene samm -->
            <div class="row setup-content" id="step-1">
               <div class="col-xs-12">
                  <div class='col-md-6'>
                     <!-- Select Basic -->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="mark">Mark</label>
                        <div class="col-md-10">
                           <select id="mark" name="mark" class="form-control">
                              <option value="Audi">Audi</option>
                              <option value="Honda">Honda</option>
                           </select>
                           <span class="help-block">Valige auto mark</span>
                        </div>
                     </div>
                     <!-- Text input-->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="mootor">Mudel</label>  
                        <div class="col-md-10">
                           <input id="mudel" name="mudel" type="text" placeholder="A4" class="form-control input-md">
                           <span class="help-block">Sisestage mudeli nimi</span>  
                        </div>
                     </div>
                     <!-- Select Basic -->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="aasta">Aasta</label>
                        <div class="col-md-10">
                           <select id="aasta" name="aasta" class="form-control">
                              <option value="2000">2000</option>
                              <option value="2001">2001</option>
                              <option value="2002">2002</option>
                              <option value="2003">2003</option>
                           </select>
                           <span class="help-block">Valige auto valmimisaasta</span>
                        </div>
                     </div>
                  </div>
                  <div class='col-md-6'>
                     <!-- Text input-->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="mootor">Mootor</label>  
                        <div class="col-md-10">
                           <input id="mootor" name="mootor" type="text" placeholder="2.0 turbo" class="form-control input-md">
                           <span class="help-block">Sisestage mootori andmed</span>  
                        </div>
                     </div>
                     <!-- Select Basic -->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="kytus">Kütus</label>
                        <div class="col-md-10">
                           <select id="kytus" name="kytus" class="form-control">
                              <option value="bensiin">Bensiin</option>
                              <option value="diisel">Diisel</option>
                              <option value="gaas">Gaas</option>
                           </select>
                           <span class="help-block">Valige kütuse tüüp</span>
                        </div>
                     </div>
                     <!-- Select Basic -->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="ulevaatus">Ülevaatus</label>
                        <div class="col-md-10">
                           <select id="ulevaatus" name="ulevaatus" class="form-control">
                              <option value="puudub">Puudub</option>
                              <option value="olemas">Olemas</option>
                           </select>
                           <span class="help-block">Kas ülevaatus on kehtiv?</span>
                        </div>
                     </div>
                     <button id="samm-2" class="btn btn-primary btn-lg pull-right" type="button">Järgmine samm</button>
                  </div>
               </div>
            </div>
            <!-- Teine samm -->
            <div class="row setup-content" id="step-2">
               <div class="col-xs-12">
                  <div class="col-md-12 well text-center">
                     <h4>Kui teil on sõidukist pilte, siis saate need siin üles laadida.</h4>
                  </div>
                  <div class='col-md-8 col-md-offset-2'>
                     <div class="form-group">
                        <label>Vali pilt 1</label>
                        <input type="file" onchange="document.getElementById('img1text').value = this.value.split('\\').pop().split('/').pop()" accept="image/*" name="image1" id="image1" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                        <div class="bootstrap-filestyle input-group">
                           <input id='img1text' type="text" class="form-control " placeholder="" disabled="">
                           <span class="group-span-filestyle input-group-btn" tabindex="0">
                           <label for="image1" class="btn btn-success ">
                           <span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span>
                           <span class="buttonText"> Vali pilt</span>
                           </label>
                           </span>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Vali pilt 2</label>
                        <input type="file" onchange="document.getElementById('img2text').value = this.value.split('\\').pop().split('/').pop()" accept="image/*" name="image2" id="image2" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                        <div class="bootstrap-filestyle input-group">
                           <input id='img2text' type="text" class="form-control " placeholder="" disabled="">
                           <span class="group-span-filestyle input-group-btn" tabindex="0">
                           <label for="image2" class="btn btn-success ">
                           <span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span>
                           <span class="buttonText"> Vali pilt</span>
                           </label>
                           </span>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Vali pilt 3</label>
                        <input type="file" onchange="document.getElementById('img3text').value = this.value.split('\\').pop().split('/').pop()" accept="image/*" name="image3" id="image3" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                        <div class="bootstrap-filestyle input-group">
                           <input id='img3text' type="text" class="form-control " placeholder="" disabled="">
                           <span class="group-span-filestyle input-group-btn" tabindex="0">
                           <label for="image3" class="btn btn-success ">
                           <span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span>
                           <span class="buttonText"> Vali pilt</span>
                           </label>
                           </span>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Vali pilt 4</label>
                        <input type="file" onchange="document.getElementById('img4text').value = this.value.split('\\').pop().split('/').pop()" accept="image/*" name="image4" id="image4" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                        <div class="bootstrap-filestyle input-group">
                           <input id='img4text' type="text" class="form-control " placeholder="" disabled="">
                           <span class="group-span-filestyle input-group-btn" tabindex="0">
                           <label for="image4" class="btn btn-success ">
                           <span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span>
                           <span class="buttonText"> Vali pilt</span>
                           </label>
                           </span>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Vali pilt 5</label>
                        <input type="file" onchange="document.getElementById('img5text').value = this.value.split('\\').pop().split('/').pop()" accept="image/*" name="image5" id="image5" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                        <div class="bootstrap-filestyle input-group">
                           <input id='img5text' type="text" class="form-control " placeholder="" disabled="">
                           <span class="group-span-filestyle input-group-btn" tabindex="0">
                           <label for="image5" class="btn btn-success ">
                           <span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span>
                           <span class="buttonText"> Vali pilt</span>
                           </label>
                           </span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class='row' style='text-align: center;'>
                  <button id="samm-3" class="btn btn-primary btn-lg pull-right" type="button">Järgmine samm</button>
               </div>
            </div>
            <!-- Kolmas samm -->
            <div class="row setup-content" id="step-3">
               <div class="col-xs-12">
                  <div class='col-md-6'>
                     <!-- Text input-->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="nimi">Sinu nimi</label>  
                        <div class="col-md-10">
                           <input id="nimi" name="nimi" type="text" placeholder="ees- ja perekonnanimi" required="" class="form-control input-md">
                           <span class="help-block">Sisestage ees- ja perekonnanimi</span>  
                        </div>
                     </div>
                     <!-- Text input-->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="email">E-post</label>  
                        <div class="col-md-10">
                           <input id="email" name="email" type="text" placeholder="e-posti aadress" required="" class="form-control input-md">
                           <span class="help-block">Sisestage oma e-posti aadress</span>  
                        </div>
                     </div>
                     <!-- Text input-->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="telefon">Telefon</label>  
                        <div class="col-md-10">
                           <input id="telefon" name="telefon" type="text" placeholder="telefoninumber" required="" class="form-control input-md">
                           <span class="help-block">Sisestage oma telefoninumber</span>  
                        </div>
                     </div>
                  </div>
                  <div class='col-md-6'>
                     <!-- Text input-->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="price">Soovitav hind</label>  
                        <div class="col-md-10">
                           <input id="price" name="price" type="text" placeholder="1337" required="" class="form-control input-md">
                           <span class="help-block">Millist hinda soovite sõiduki eest saada?</span>  
                        </div>
                     </div>
                     <!-- Textarea -->
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="muu">Kommentaar</label>
                        <div class="col-md-10">                     
                           <textarea class="form-control" id="muu" rows="2" name="muu">Kui soovite midagi lisada, siis kirjutage see siia</textarea>
                        </div>
                     </div>
                     <div class='form-group'>
                     <label class="col-md-2 control-label" for="google">Antirobot</label>
                        <div class="col-md-10">
                           <div class="g-recaptcha" style='width: 100%;' data-sitekey="6Lc5lxEUAAAAAMls4oBmcRFBPUFdIgPgeLHOr8uI"></div>
                        </div>
                     </div>
                     <button class="btn btn-primary btn-lg pull-right step-3" type="submit">Saada pakkumine</button>
                  </div>
               </div>
            </div>
         </div>
      </fieldset>
   </form>
</html>