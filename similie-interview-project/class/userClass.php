<?php
    class UserClass{
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

    //inserting user or creating user acount
    public function InsertAdmin($fullname, $username, $pass)
    {
        $insertAdmin= "INSERT INTO user(Fullname, Username, Passwords) VALUES(?, ?, ?);";
        $stmt= $this->connector->prepare($insertAdmin);
        $stmt->bind_param('sss', $fullname, $username, $pass);
        $stmt->execute();
        return $stmt;
    }

    //updating user or creating user acount
    public function UpdateAdmin($fullname, $username, $pass){
        $update="UPDATE user SET fullname=?, passwords=? WHERE Username=?;";
        $stmt=$this->connector->prepare($update);
        $stmt->bind_param('sss', $fullname, $pass, $username,);
        $stmt->execute();
        if ($stmt) {
            return true;
        }else{
            return false;
        }
    }

    //deleting  user or user account from the database;
   public function DeleteUsers($id_admin)
    {
        $insertAdmin= "DELETE FROM user WHERE id=?;";
        $stmt= $this->connector->prepare($insertAdmin);
        $stmt->bind_param('i', $id_admin);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    
   }

    //Selecting one user from database;
    public function SelectOneUsers($id)
    {
        $insertAdmin= "SELECT * FROM user WHERE id=?;";
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

   // Selecting all users from the database;
   public function SelectUsers()
   {
       $insertAdmin= "SELECT * FROM user;";
       $stmt= $this->connector->prepare($insertAdmin);
       $stmt->execute();
       $result=$stmt->get_result();
       if($result){
           return $result;
       }else{
           return false;
   }
   
  }

  //Verifying if username has not been taken before creating it;
  public function verifyId($username)
  {
    $sqlLogin="SELECT * FROM user WHERE username=?;";
      $stmt=$this->connector->prepare($sqlLogin);
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $result=$stmt->get_result();
  
      if ($result->num_rows <=0) {
       return true;
      }else{
        return false;
      }
    
  }

  //Logging in users based on correct username and password;
    public function login($username, $password)
    {
        $sqlLogin="SELECT * FROM user WHERE username=?;";
        $stmt=$this->connector->prepare($sqlLogin);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result=$stmt->get_result();

        if ($result->num_rows <=0 || $result->num_rows >1) {
            return false;
        }else if($result->num_rows ==1){
            if ($row=$result->fetch_assoc()) {
                //collecting and verifying hash password from database.
                $hashPasswordCheck=password_verify($password, $row['Passwords']);
                if ($hashPasswordCheck==false) {
                    return false;
                }elseif ($hashPasswordCheck==true) {
                    //collecting user details and setting expiration time in session variable.
                    $_SESSION['start_time']=time();
                    $_SESSION['empire']=$_SESSION['start_time']+(10 * 60);
                    $_SESSION['id']=$row['id'];
                    $_SESSION['fullname']=$row['Fullname'];
                    $_SESSION['username']=$row['Username'];
                    return true;

                }else{
                    return false;
                }
        }else {
            return false;
            }

        }
    }
}
  
?>