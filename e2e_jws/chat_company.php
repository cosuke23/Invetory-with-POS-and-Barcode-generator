<div id="right-menu">
  <div class="tab-content">
    <div id="right-menu-user" class="tab-pane fade in active">
      <ul id="tabs-demo3" class="nav nav-tabs nav-tabs-v3" role="tablist">
        <li role="presentation" class="active">
          <a href="#tab1" id="tabs1" role="tab" data-toggle="tab" aria-expanded="true">STAFF</a>
        </li>
        <li role="presentation">
          <a href="#tab2" id="tabs2" role="tab" data-toggle="tab" aria-expanded="true">COMPANY</a>
        </li>
      </ul>
      <div id="tabsDemo5Content" class="tab-content tab-content-v3">
        <div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">
          <div class="user col-md-12">
           <ul class="nav nav-list">
            <?php
              $q_user_list = $database->query("SELECT * FROM user_info WHERE status = 'Active' ORDER BY chat_status DESC")->fetchAll();
              foreach($q_user_list AS $q_user_data){
                $full_name = $q_user_data["fname"].' '.$q_user_data["lname"];
                $chat_status = $q_user_data["chat_status"];
                $comp_user_id_clicked = $q_user_data['user_id'];
                $receiver_user = $q_user_data['username'];
                $profileData = $q_user_data['profileData'];

                $decoded_img_profile = base64_decode($profileData);
                $f = finfo_open();
                $type = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);
            ?>
            <a href="chat_update_message_status.php?comp_user_id_clicked=<?php echo $comp_user_id_clicked; ?>&&sender_user=<?php echo $sender_user; ?>">
              <li class="<?php echo $chat_status; ?>">
                <?php
                  echo '<img src="data:'.$type.';base64,'.$profileData.'">' ;
                ?>
                <div class="name">
                  <?php
                    if($chat_status == 'online'){
                      echo '<h5 style="color:black;"><b style="color:black;">'.$full_name.'</b></h5>';
                      echo '<p style="color:#27c24c;font-weight:bold;">Online</p>';
                    }
                    else{
                      echo '<h5>'.$full_name.'</b></h5>';
                      echo '<p>Offline</p>';
                    }
                  ?>
                </div>
                <div class="gadget">
                  <span class="fa fa-desktop"></span>
                </div>
                <?php
                $c_new_staff_chat = $database->count("messenger",["AND"=>["receiver" => $sender_user,"sender" => $receiver_user,"message_status"=>'unread']]);
                if($c_new_staff_chat == 0){
                  echo "";
                }
                elseif($c_new_staff_chat == 1){
                  echo '<div class="badge" style="background:#0084ff;">'.$c_new_staff_chat.' new message</div>';
                }
                else{
                  echo '<div class="badge" style="background:#0084ff;">'.$c_new_staff_chat.' new messages</div>';
                }
                ?>
                <div class="dot"></div>
              </li>
              <?php } ?>
            </a>
          </ul>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">
        <div class="user col-md-12">
         <ul class="nav nav-list">
           <?php
           $q_comp = $database->query("SELECT * FROM company_info WHERE status='Active' AND comp_id != '$comp_id'")->fetchAll();
           foreach($q_comp AS $q_comp_data){
             $compid = $q_comp_data["comp_id"];
             $comp_name = $q_comp_data["comp_name"];
             $comp_user = $q_comp_data["username"];
             $comp_logo = $q_comp_data["comp_logo"];

             $decoded_img_profile = base64_decode($comp_logo);
             $f = finfo_open();
            $img_type_profile = finfo_buffer($f, $decoded_img_profile, FILEINFO_MIME_TYPE);

             $q_nop = $database->query("SELECT * FROM nop_job_fair WHERE comp_id = '$compid'")->fetchAll();
             foreach($q_nop AS $q_nop_data){
               $comp_id_clicked = $q_nop_data["comp_id"];
               $event_id = $q_nop_data["event_id"];
               $chat_status = $q_nop_data["chat_status"];

               $q_event = $database->query("SELECT * from event_manager WHERE status='Active' AND event_id='$event_id' AND type='Job Fair'")->fetchAll();
               foreach($q_event AS $q_event_data){
                 $event_name = $q_event_data["event_name"];
           ?>
          <a href="chat_update_message_status.php?user_comp_id_clicked=<?php echo $comp_id_clicked; ?>">
            <li class="<?php echo $chat_status; ?>">
              <?php
                echo '<img src="data:'.$img_type_profile.';base64,'.$comp_logo.'">' ;
              ?>
              <div class="name">
                <?php
                  if($chat_status == 'online'){
                    echo '<h5 style="color:black;"><b style="color:black;">'.$comp_name.'</b></h5>';
                    echo '<p style="color:#27c24c;font-weight:bold;">Online</p>';
                  }
                  else{
                    echo '<h5>'.$comp_name.'</b></h5>';
                    echo '<p>Offline</p>';
                  }
                ?>
              </div>
              <div class="gadget">
                <span class="fa fa-desktop"></span>
              </div>
              <?php
              $c_new_chat = $database->count("messenger",["AND"=>["receiver"=>$sender_user ,"sender" => $comp_user,"message_status"=>'unread']]);
              if($c_new_chat == 0){
                echo "";
              }
              elseif($c_new_chat == 1){
                echo '<div class="badge" style="background:#0084ff;">'.$c_new_chat.' new message</div>';
              }
              else{
                echo '<div class="badge" style="background:#0084ff;">'.$c_new_chat.' new messages</div>';
              }
              ?>
              <div class="dot"></div>
            </li>
            <?php
                }
              }
            }
            ?>
          </a>
         <ul>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
