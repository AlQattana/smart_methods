
<?php
session_start();
require_once 'config.php';

$sql = "SELECT id, value FROM motors";
$result = mysqli_query($conn, $sql);
$i = 0;
$values_array = [];
while($row = mysqli_fetch_array($result)){
   $values_array[$i] = $row['value'];
   $i++;
}

switch ($values_array[7]) {
   case 0:
     $dir = 'stop';
     break;
   case 1:
     $dir = 'forward';
     break;      
   case 2:
     $dir = 'right';
     break;        
   case 3:
     $dir = 'left';
     break;  
   case 4:
     $dir = 'backward';
     break;    
 }

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>smart methods task 1</title>
      <link rel="stylesheet" href="styles.css">
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   </head>
   <body>
      <div class="box">
         <form action="update_motors.php" method="POST">
            <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
               <div id="display-success">
               <?php 
               echo $_SESSION['success_message']; 
               ?>
               </div>
               <br>
            <?php
               unset($_SESSION['success_message']);
            }  
            ?>
            <div id="display-success"> Robot State is <strong>
            <?php 
            echo ($values_array[6] == 0) ? '[off]' : '[on]'; 
            ?>
            </strong>
            <!-- <?php echo ($values_array[7] == 0) ? ' and the robot is stopped' : ' and the current robot direction is [' . $dir . "]"; ?> -->
            </div>
            <br>
            <label for="main" style="display: block; text-align: center; font-weight:bold">Motors controller</label>
            <br>
            <label for="fader">Motor 1</label>
            <input type="range" class="slider" min="0" max="100" value="<?php echo $values_array[0] ?>" name="motor1" id="1" step="1" oninput="outputUpdate(value, this.getAttribute('id'))">
            <output for="fader" id="volume1" class="vol"><?php echo $values_array[0] ?></output>
            <br>
            <label for="fader">Motor 2</label>
            <input type="range" class="slider" min="0" max="100" value="<?php echo $values_array[1] ?>" name="motor2" id="2" step="1" oninput="outputUpdate(value, this.getAttribute('id'))">
            <output for="fader" id="volume2" class="vol"><?php echo $values_array[1] ?></output>
            <br>
            <label for="fader">Motor 3</label>
            <input type="range" class="slider" min="0" max="100" value="<?php echo $values_array[2] ?>" name="motor3" id="3" step="1" oninput="outputUpdate(value, this.getAttribute('id'))">
            <output for="fader" id="volume3" class="vol"><?php echo $values_array[2] ?></output>
            <br>
            <label for="fader">Motor 4</label>
            <input type="range" class="slider" min="0" max="100" value="<?php echo $values_array[3] ?>" name="motor4" id="4" step="1" oninput="outputUpdate(value, this.getAttribute('id'))">
            <output for="fader" id="volume4" class="vol"><?php echo $values_array[3] ?></output>
            <br>
            <label for="fader">Motor 5</label>
            <input type="range" class="slider" min="0" max="100" value="<?php echo $values_array[4] ?>" name="motor5" id="5" step="1" oninput="outputUpdate(value, this.getAttribute('id'))">
            <output for="fader" id="volume5" class="vol"><?php echo $values_array[4] ?></output>
            <br>
            <label for="fader">Motor 6</label>
            <input type="range" class="slider" min="0" max="100" value="<?php echo $values_array[5] ?>" name="motor6" id="6" step="1" oninput="outputUpdate(value, this.getAttribute('id'))">
            <output for="fader" id="volume6" class="vol"><?php echo $values_array[5] ?></output>
            <br>
            
            <input type="checkbox" name="checkbox" style="display: none;" <?php echo ($values_array[6] == 1) ? 'checked' : ''; ?>/>
            <input type="button" class="button" onclick="set_checked()" value="<?php echo ($values_array[6] == 1) ? 'On' : 'Off'; ?>" />           
          
            <input type="submit" class="button" value="Save">
         </form>
      </div>

      <div class="box" style="text-align:center">
         <form>
            <div id="display-success" class="ctrl"> 
            <?php echo ($values_array[7] == 0) ? 'The robot is stopped' : 'The current robot direction is <strong>[' . $dir . "]</strong>"; ?>
            </div>
            <button class="ctrl_btn" type="button" value="forward">FORWARD</button>
            <br>
            <button class="ctrl_btn" type="button" value="left">LEFT</button>
            <button class="ctrl_btn" type="button" value="stop">STOP</button>
            <button class="ctrl_btn" type="button" value="right">RIGHT</button>
            <br>
            <button class="ctrl_btn" type="button" value="backward">BACKWARD</button>
         </form>              
      </div>

   </body>
   <script>
      $( document ).ready(function() {
         $(".ctrl_btn").click(function(e) {
            var value = $(this).attr("value");
            e.preventDefault();
            $.ajax({
               type: "POST",
               url: "update_movement.php",
               data: { 
                     mov_value: value
               },
               success: function(result) {
                     if(value === "stop")
                        $('.ctrl').html("The robot is stopped")
                     else
                        $('.ctrl').html("The current robot direction is <strong>[" + value + "]</strong>")
               },
            });
         });         
      });
   </script>
   <script>
      function outputUpdate(vol, id) {
         var element = '#volume' + id
         document.querySelector(element).value = vol;
      }

      function set_checked() {
         var element = document.querySelector('input[name=checkbox]');
         
         if (element.checked)
            element.checked = false;
         else
            element.checked = true;

         var btn = document.querySelector('input[type=button]');
         if(btn.value === 'On')
            btn.value = 'Off';
         else
            btn.value = 'On';
      }
   </script>
   <script>
	window.watsonAssistantChatOptions = {
		integrationID: "3a21aa5d-6c88-4fcb-89ee-729a849ef2e8", // The ID of this integration.
		region: "eu-gb", // The region your integration is hosted in.
		serviceInstanceID: "3fc49420-b5cc-40c9-8070-461d77f9b306", // The ID of your service instance.
		onLoad: function(instance) { instance.render(); }
	  };
	setTimeout(function(){
	  const t=document.createElement('script');
	  t.src="https://web-chat.global.assistant.watson.appdomain.cloud/loadWatsonAssistantChat.js";
	  document.head.appendChild(t);
	});
   </script>
</html>