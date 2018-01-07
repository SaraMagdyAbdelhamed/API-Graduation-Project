<?php 
 //open connection to mysql db
$connection = mysqli_connect("localhost","root","" ,"securedataproject") or die("Error " . mysqli_error($connection));
 //$connection = mysqli_connect("localhost","pentates_islam87","yT9A.t4#)SO}" ,"pentates_securedataproject") or die("Error " . mysql_error($connection)); 
if($_SERVER["REQUEST_METHOD"]=="POST"){
    switch($_POST["status"])
{
            //register for doctor
        case "RGD":
            {
    $name = $_POST["name"];	
	$email = $_POST["email"];
	$password = $_POST["password"];
    $department=$_POST["department"];
	$mobile_number=$_POST["mobile_number"];
    $check_for_email="SELECT doctor_id FROM doctors WHERE email='$email'";
                $check=mysqli_query($connection,$check_for_email);
                $email_check=mysqli_fetch_array($check);
                if(!isset($email_check)){
	$query = " Insert into doctors(Doctor_Name,Email,Password,Department,Mobile_Number) values ('$name','$email','$password','$department','$mobile_number');";
          $register=  mysqli_query($connection, $query) ;
                if(mysqli_error($connection))
                {
                    echo "fail";
                }
                else
                {
                    echo "success";
                }
                }
    }
            break;
            //register for patient
        case "RGP":
            {
     $name = $_POST["name"];	
    $address=$_POST["address"];
	$email = $_POST["email"];
	$password = $_POST["password"];
   
	$mobile_number=$_POST["mobile_number"];
                $doctor_id=$_POST["doctor_id"];
     $check_for_email="SELECT patient_id FROM patients WHERE email='$email'";
                $check=mysqli_query($connection,$check_for_email);
                $email_check=mysqli_fetch_array($check);
                if(!isset($email_check)){
               
	$query = " Insert into patients(Patient_ID,Patient_Name,Address,Email,Password,Mobile_Number) values ('','$name','$address','$email','$password','$mobile_number');";
             $register=  mysqli_query($connection, $query) ;
                if(mysqli_error($connection))
                {
                    echo "fail";
                   
                }
                else
                {
                    echo "success";
                }
                }
    }
            break; 
            //login for doctor
        case "LD":
            {
  $email = $_POST['email'];
 $password = $_POST['password'];
 $sql = "SELECT * FROM doctors WHERE email='$email' AND password='$password'";
$result=mysqli_query($connection,$sql);
 $check = mysqli_fetch_array($result,MYSQLI_ASSOC);
     
 if(isset($check)){       
     
     echo"success";
 }
else{
 echo "failure";
 }
            }
            break;
            
            //login for patient
                  case "LP":
            {
                $email = $_POST['email'];
 $password = $_POST['password'];
     
  $sql = "SELECT * FROM patients WHERE email='$email' AND password='$password'";
 
 $result = mysqli_query($connection,$sql);
 
 $check = mysqli_fetch_array($result,MYSQLI_ASSOC);
 
 if(isset($check)){
     echo "success";
  
 }
else{
 echo "failure";
 }
            }
            break;
   
 
 

 
    
        case "show_doctor_data":
            {
                 $email = $_POST['email'];
 
 $sql = "SELECT * FROM doctors WHERE email='$email' ";
$result=mysqli_query($connection,$sql);
    
           $doctor_data = array();
                   while ($data = mysqli_fetch_assoc($result)) {
           
            $doctor_data []= $data;
                     
            
        }
               echo json_encode(array('doctor_data' => $doctor_data ));
     
            }
            break;
        case "show_patients_data":
   {
         $doctor_id = $_POST['Doctor_ID'];
 


     //search for all id's patient that have relation with doctor id
     $query_patient_id=mysqli_query($connection,"SELECT patient_id FROM patient_doctor WHERE doctor_id='$doctor_id'")or die(mysqli_error());
              $patient_array = array();
   
        while ($data = mysqli_fetch_assoc($query_patient_id)) {
            
            $patient_array[] = $data["patient_id"];
         
        }
  //search for patients names in patients and add them to array
      $data_array = array();
            $counter=0;
            while($counter != sizeof($patient_array))
            {
             
            $patient_select_data=mysqli_query($connection,"SELECT *  FROM patients WHERE Patient_ID='$patient_array[$counter]' ")or die(mysqli_error());
                 while ($data = mysqli_fetch_assoc($patient_select_data)) {
            
            $data_array[] = $data;
                     
            
        }
                $counter++;
       }
 
//echo "success&",implode('&',$check),"&",implode('&',$data_array);
      echo json_encode(array('patient_data' => $data_array ));
       
   }
            break;
            //requset for doctors IDs and names to patient to choose from them 
        case "send_doctors_data":
            {
                $query_doctors_data=mysqli_query($connection,"SELECT Doctor_ID,Doctor_Name,Department FROM doctors")or die(mysqli_error());
                       $doctors_array = array();
   
        while ($data = mysqli_fetch_assoc($query_doctors_data)) {
            
            $doctors_array[] = $data;
         
        }
                  echo json_encode(array('doctor_data' => $doctors_array ));
            }
            break;
 case "show_patient_data":
   {
                       $email = $_POST['email'];
 
 $sql = "SELECT * FROM patients WHERE email='$email' ";
$result=mysqli_query($connection,$sql);
    
           $patient_data = array();
                   while ($data = mysqli_fetch_assoc($result)) {
           
            $patient_data []= $data;
                     
            
        }
               echo json_encode(array('patient_data' => $patient_data ));
   }
            break;
            //show to the patient the last read for his data
        case "last_data":
            {
                
                       $email = $_POST['email'];
 
 $sql = "SELECT patient_id FROM patients WHERE email='$email' ";
                $result=mysqli_query($connection,$sql);
                $patient_id = mysqli_fetch_assoc($result);
                if(isset($patient_id)){
                     $id = $patient_id["patient_id"];
                    $select_data=mysqli_query($connection,"SELECT data,time FROM data WHERE patient_id='$id'")or die(mysqli_error());
                    $patient_data=array();
                    while($data = mysqli_fetch_assoc($select_data))
                          {
                              $patient_data[]=$data;
                          }
                    $last = sizeof($patient_data);
                    echo json_encode(array('patient_data' =>array( $patient_data[$last-1] )));
                }
            }
            break;
                //show to the patient his history
        case "history":
            {
                
                       $email = $_POST['email'];
 
 $sql = "SELECT patient_id FROM patients WHERE email='$email' ";
                $result=mysqli_query($connection,$sql);
                $patient_id = mysqli_fetch_assoc($result);
                if(isset($patient_id)){
                     $id = $patient_id["patient_id"];
                    $select_data=mysqli_query($connection,"SELECT data,time FROM data WHERE patient_id='$id'")or die(mysqli_error());
                    $patient_data=array();
                    while($data = mysqli_fetch_assoc($select_data))
                          {
                              $patient_data[]=$data;
                          }
                    
                    echo json_encode(array('patient_data' => $patient_data ));
                }
            }
            break;
            //Register Data in data table
        case "RDATA":
            {
                  $patient_id = $_POST["Patient_ID"];
                $data=$_POST["Data"];
                $time=$_POST["Time"];
                $location=$_POST["Location"];
                $date=$_POST["Date"];
                if($data >50 && $data < 120)
                {
                    $emergency_state = 'n';
                }
                else
                {
                     $emergency_state = 'y';
                }
                	$query = " Insert into data(ID,Patient_ID,Data,Time,Location,Emergency_state,Date) values ('','$patient_id','$data','$time','$location','$emergency_state','$date');";
          $register=  mysqli_query($connection, $query) ;
                if(mysqli_error($connection))
                {
                    echo "fail";
                }
                else
                {
                    echo "success";
                }
                
            }
            break;
            //connect patient to doctor in patient_doctor table
        case "patient_doctor":
            {
                $patient_id=$_POST["Patient_ID"];
                $doctor_id=$_POST["Doctor_ID"];
                $query="INSERT into patient_doctor(ID,Patient_ID,Doctor_ID)values('','$patient_id','$doctor_id');";
                $insert=  mysqli_query($connection, $query) ;
                if(mysqli_error($connection))
                {
                    echo "fail";
                }
                else
                {
                    echo "success";
                }
            }
            break;
    mysqli_close($connection);
}
}

?>