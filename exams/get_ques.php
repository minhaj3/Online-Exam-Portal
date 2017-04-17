<?php 
$pagerows = 4;

  if (isset($_GET['p']) && is_numeric ($_GET['p'])) {
   $pages=$_GET['p']; 
   }
  else{
    if(isset($_GET["set"]) ){
      $e_id = $_GET['set'];
      $result = mysqli_query ($cn, "SELECT COUNT(ques_id) FROM question WHERE exam_id = '$e_id' " );
      $row = @mysqli_fetch_array ($result); 
      $records = $row[0];
      if ($records > $pagerows)
      { 
         $pages = ceil ($records/$pagerows);  
      }
      else
      {
        $pages = 1;
      }
    }
  }
  if (isset($_GET['s']) && is_numeric ($_GET['s'])){
      $start = $_GET['s']; 
  }
  else {
   $start = 0; 
  }
  if(isset($_GET["set"]) ){ 
      
      $ques = mysqli_query($cn,"SELECT * FROM question WHERE exam_id = '$e_id' ORDER BY ques_id ASC LIMIT $start, $pagerows ");
  ?>
      <form action = "student/result.php" method= "POST">
          <?php
            $e_id =$_GET['set'];
            echo '<input type="hidden" name = "e_id" value= "'.$e_id.'" /> ';
            
            $members = $row[0];
              //mysqli_close($cn);
              echo '<input type="hidden" name = "total_q" value= "'.$members.'" /> ';
             // echo $members;
            while($data = mysqli_fetch_assoc ($ques))
             {
              $ques_id = $data['ques_id'];
              $x = 'cs'.$ques_id;
              echo '<input type="hidden" name = "cse'.$ques_id.'" value= "'.$ques_id.'" /> ';
              echo '<pre>'.$data['ques_id']. ' . ' . $data['ques'] . '</pre>' . '<br>';
              echo '<input type="radio" name="cs'.$ques_id.'" value="1"/>' . $data['ans1'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
              echo '<input type="radio" name="cs'.$ques_id.'" value="2"/>' . $data['ans2'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
              echo '<input type="radio" name="cs'.$ques_id.'" value="3"/>' . $data['ans3'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
              echo '<input type="radio" name="cs'.$ques_id.'" value="4"/>' . $data['ans4'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'<hr>' ;
              
              echo '<br>';
              }
              //echo '<input type="hidden" name = "no_ques" value= "'.$records.'" />';
            
              echo "<p align='center' >Total Questions: ".$records."</p>"; 
            if ($pages >= 1) 
            {
              echo '<p>';
              $current_page = ($start/$pagerows) + 1;
              if ($current_page != 1) {
               echo '<a href="exm_1.php?s=' . ($start - $pagerows) .'&p=' . $pages . '">Previous</a> '; }
              if ($current_page != $pages) {
               echo '<p align="center">'.'<a  href="exm_1.php?s=' . ($start + $pagerows) .  '&p=' . $pages . '">Next</a> '. '</p>';}
              elseif($current_page == $pages){
                 if(isset($_SESSION['tempLvl']) and (($_SESSION['tempLvl']==0))){
                    echo '<input type= "submit" class="btn-lg btn-primary" name="submit" value="submit" \> ';
                }
                else {
                  echo '<pre style="background-color:cyan;">You need to login as student to submit test questions.</pre>';
                }
                
              }
                echo '</p>'; 
            }
          ?>
      </form>
    <?php } ?>

  <?php
  if(isset($_GET["add"])) {
  include('teacher/add.php');
  }

  if(isset($_GET["del"])){
  include('teacher/del.php');
  }
  ?>