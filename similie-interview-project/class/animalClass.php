<?php
    class AnimalClass{

        //assigning database variable values;
        Private $server_name="127.0.0.1";
        Private $server_user="root";
        Private $server_pass="DDee@2022@DD";
        Private $server_db="similie_db";
        protected $connector;

        //db connect constructor for animal class
        function  __construct()
        {
            $this->connector=new mysqli($this->server_name, $this->server_user, $this->server_pass, $this->server_db);
            if(!$this->connector){
                die("Error: Failed to connect to the database :.");
                exit();
            }
            return $this->connector;
        }

        //verifying input to protect db against SQLinjection;
        //verifying invalide character and preventing SQLinject.
        //note: I will still use prepared statement.
        public function RemoveInvalideInput($string)
        {
            $escape = mysqli_real_escape_string($this->connector, $string);
            $escape = trim($escape);
            $escape = stripslashes($escape);
            $escape = strip_tags($escape);
            return htmlentities($escape);
        }

        //Inserting Animal or species into the database;
        public function InsertAnimals($name, $type, $lati, $longi,$input_file, $descs, $username)
        {
            //collecting image or file from input
            $unique_id=rand(1, 999);
            $filename=$input_file['name'];
            $filetmp=$input_file['tmp_name'];
            $fileSize=$input_file['size'];
            $fileError=$input_file['error'];
            $fileType=$input_file['type'];

            //verifying the format and only permitting only one type, png, jpg and jpeg.
            $fileExt=explode('.', $filename);
            $fileCheck=strtolower(end($fileExt));
            $fileStore=array('jpg','png','jpeg');

        if (in_array($fileCheck, $fileStore) &&  $fileSize <= 5000000) {

            //inserting image alone with the data.
            $distinationFolder='images/'.$unique_id.'_'.$filename;
            move_uploaded_file($filetmp, $distinationFolder);
            $insertAdmin="INSERT INTO animals(an_name, an_type, lat, lng, image, description, username) VALUES(?,?,?,?,?,?,?)";
            $stmt= $this->connector->prepare($insertAdmin);
            $stmt->bind_param('ssddsss',  $name, $type, $lati, $longi, $distinationFolder, $descs, $username);
            $stmt->execute();
            if ($stmt){
                return true;
            }else{
                return false;
            }
            }else{
                return false;
            }
        }

        //Updating Animal or species into the database;
        public function UpdateAnimals($name, $type, $lati, $longi, $input_file, $desc, $username, $id)
        {
            //collecting image or file from input
            $unique_id=rand(1, 999);
            $filename=$input_file['name'];
            $filetmp=$input_file['tmp_name'];
            $fileSize=$input_file['size'];
            $fileError=$input_file['error'];
            $fileType=$input_file['type'];

            //verifying the format and only permitting only one type, png, jpg and jpeg.
            $fileExt=explode('.', $filename);
            $fileCheck=strtolower(end($fileExt));
            $fileStore=array('jpg','png','jpeg');

            if (in_array($fileCheck, $fileStore) &&  $fileSize <= 5000000) {

                //updating image alone with the data.
                $distinationFolder='images/'.$unique_id.'_'.$filename;
                move_uploaded_file($filetmp, $distinationFolder);
                $update="UPDATE animals SET an_name=?, an_type=?, lat=?, lng=?, image=?, description=?, username=? WHERE id=?;";
                $stmt=$this->connector->prepare($update);
                $stmt->bind_param('ssddsssi', $name, $type, $lati, $longi, $distinationFolder, $desc, $username, $id);
                $stmt->execute();
                if ($stmt){
                    return $stmt;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        //deleting  Animal or species from the database;
       public  function  DeleteAnimals($id){
           $insertAdmin= "SELECT * FROM animals WHERE id=?;";
           $stmt= $this->connector->prepare($insertAdmin);
           $stmt->bind_param('i', $id);
           $stmt->execute();
           $result=$stmt->get_result();
           if($result) {
               //collecting the image to be deleted with the data.
               while ($row=$result->fetch_assoc()){
                   $file=$row['image'];
               }
           }
           $delete="DELETE FROM animals WHERE id=?";
           $stmt=$this->connector->prepare($delete);
           $stmt->bind_param('i', $id);
           $stmt->execute();
           //deleting both data and image or icon from db.
           if($stmt){
               if(file_exists($file)){
                   unlink($file);
               }
               return true;
           }else{
               return false;
           }
       }

       //Selecting one Animal or specie based on ID from the database
        public function SelectOneAnimals($id)
        {
            $insertAdmin= "SELECT * FROM animals WHERE id=?;";
            $stmt= $this->connector->prepare($insertAdmin);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result){
                return $result;
            }else{
                return false;
            }

        }

        //Selecting all Animals or species from the database
        public function SelectAnimal()
        {
            $sqlselect="SELECT * FROM animals;";
            $stmt=$this->connector->prepare($sqlselect);
            $stmt->execute();
            $result=$stmt->get_result();

            if ($result->num_rows >0) {
                return $result;
            }else{
               return false;
            }

        }


    }

?>