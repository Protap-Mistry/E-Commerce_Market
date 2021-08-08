<?php
  require "phpMailer/vendor/autoload.php";
      
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
?>


<?php
  $filepath= realpath(dirname(__FILE__));
  include_once $filepath.'/../database/db.php';

  class Format
  {
     public function formatDate($date)
     {
        return date('F j, Y, g:i a', strtotime($date));
     }

     public function textShorten($text, $limit = 400)
     {
        $text = $text. " ";
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text."...";
        return $text;
     }

     public function validation($data)
     {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }

     public function title()
     {
        $path = $_SERVER['SCRIPT_FILENAME'];
        $title = basename($path, '.php');
        //$title = str_replace('_', ' ', $title);
        if ($title == 'index') 
        {
          $title = 'home';
        }elseif ($title == 'contact') 
        {
          $title = 'contact';
        }
        return $title = ucfirst($title);
     }

     /* admin panel work start */

    //for admin login
    public function getLoginUser($username, $password)
    {
      $sql= "select * from backend_user where username= :username and password= :password";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':username', $username);
      $query->bindValue(':password', $password);
      $query->execute();
      
      return $query->fetch(PDO::FETCH_OBJ);
      
    }
    public function userLogin($data)
    {
      $username= $data['username'];
      $password= $data['password'];
          
      if($username== "" OR $password== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $username)){

      $msg= "<div style='color:red;'> <strong> Error!!! </strong> Username must only contain alphanumerical, dashes and underscore.</div>";
      return $msg;
      }elseif (strlen($username)<3) {
          
        $msg= "<div style='color:red;''> <strong> Error!!! </strong> Username is too short </div>";
        return $msg;
      }
      if(strlen($password)<5)
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Password is too short. It must be greater than 4 values </div>";
        return $msg;
      }
      $password= md5($data['password']);

      $result= $this->getLoginUser($username, $password);

      if($result)
      {
        Session::init();
        Session::set("login", true);
        Session::set("id", $result->id);
        Session::set("name", $result->name);
        Session::set("username", $result->username);
        Session::set("email", $result->email);
        Session::set("role", $result->role);
        Session::set("loginmsg", "<div style='color:green;'> <strong>Successfull! </strong>
        You are logged in... </div>");

        header("Location: index.php");
      }
      else
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Data not found ! </div>";
        return $msg;
      }
    }
    //check existence of email
    public function emailCheck($email)
    {
      $sql= "select * from backend_user where email= :email";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':email', $email);
      $query->execute();
      if($query->rowCount()>0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    //add backend users
    public function addUser($data){
      $username= $data['username'];
      $email= $data['email'];
      $password= $data['password'];
      $role= $data['role'];

      if($username== "" || $email== "" || $password== "" || $role== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $username)){

        $msg= "<div style='color:red;''> <strong> Error!!! </strong> Username must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

        $msg= "<div style='color:red;'> <strong> Error!!! </strong>The email address is not valid. Please put like name@gmail.com </div>";
        return $msg;    
      }
      $email_chk= $this->emailCheck($email);

      if($email_chk==true){

        $msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> The email address already exist </div>";
        return $msg;
      }

      $password= md5($data['password']);

      $sql= "insert into backend_user(username, email, password, role) values(:n, :e, :p, :r)";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':n', $username);
      $query->bindValue(':e', $email);
      $query->bindValue(':p', $password);
      $query->bindValue(':r', $role);

      if($query->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Thank You, you have been added a new user. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, there has been problem to insert your user.  </div>";
        return $msg;
      }
    }
    //recovery password by sending email for backend users
    public function passwordRecover($data){
      $email= $data['email'];

      if($email == ""){
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

        $msg= "<div style='color:red;'> <strong> Error!!! </strong>The email address is not valid. Please put like name@gmail.com </div>";
        return $msg;    
      }
      $email_chk= $this->emailCheck($email);

      if($email_chk==true)
      {
        if($email_chk){
          foreach ((array)$email_chk as $key => $value) {
            $id= $value['id'];
            $username= $value['username'];
          }
        }

        $new_generate= substr($email, 0, 3);
        $random= rand(10000, 99999);
        $combine= "$new_generate$random";
        $new_pass= md5($combine);

        $sql= "update backend_user set password= :p where id= :id";
        $query= databaseClass::ourPrepareMethod($sql);

        $query->bindValue(':p', $new_pass);
        $query->bindValue(':id', $id);
        $query->execute();

        $to= "$email";
        $from= "pro.cse4.bu@gmail.com";

        $headers= "From: $from\n";
        $headers.= "MIME-Version: 1.0"."\r\n";
        $headers.= "Content-type: text/html; charset=iso-8859-1"."\r\n";

        $subject= "Your New Password";

        $message= "Your username is".$username." and Password is ".$combine.". Please visit our website to login";

        $send_email= mail($to, $subject, $message, $headers);

        if($send_email)
        {
          $msg= "<div style='color: green'> <strong> Successfull! </strong>Please check your email for getting new password.</div>";
          return $msg;
        }
        else
        {
          $msg= "<div style='color: red'> <strong> Error! </strong>Sorry, User password not recovered !!!  </div>";
          return $msg;
        }             
      }
      else
      {
        $msg= "<div style='color: red'> <strong> Error!!! </strong> The email address doesn't exist. </div>";
        return $msg;
      }
    }
    //select backend users into profile
    public function selectUserByIdAndRole($id, $role)
    {
      $sql= "select * from backend_user where id= :id and role=:r limit 1";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->bindValue(':r', $role);
      $query->execute();
      
      $result= $query->fetch(PDO::FETCH_OBJ);
      return $result;
    }
    //update backend user profile
    public function updateUserProfile($id, $data)
    {
      $name= $data['name'];
      $username= $data['username'];
      $email= $data['email'];
      $details= $data['details'];

      if($name== "" || $username== "" || $email== "" || $details== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

        $msg= "<div style='color:red;''> <strong> Error!!! </strong> Name must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $username)){

        $msg= "<div style='color:red;''> <strong> Error!!! </strong> User name must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
      }elseif (strlen($username)<3) {
          
        $msg= "<div style='color:red;''> <strong> Error!!! </strong> Username is too short (Upto 3 characters)</div>";
        return $msg;
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

        $msg= "<div style='color:red;'> <strong> Error!!! </strong>The email address is not valid. Please put like name@gmail.com </div>";
        return $msg;    
      }

      $sql= "update backend_user set name= :n, username= :u, details= :details, email= :e where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);

      $query->bindValue(':n', $name);
      $query->bindValue(':u', $username);
     
      $query->bindValue(':details', $details);
       $query->bindValue(':e', $email);
      $query->bindValue(':id', $id);
      
      if($query->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>User profile updated successfully </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, User profile not updated !!!  </div>";
        return $msg;
      }     
    }
   //show users list
    public function showUserList(){

      $sql="select * from backend_user order by id";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //delete page
    public function deleteUser($id){

      $delete= "delete from backend_user where id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>User deleted successfully. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, User not deleted.  </div>";
        return $msg;
      }
    }
    //view users
    public function viewUserById($id)
    {
      $sql= "select * from backend_user where id= :id limit 1";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->execute();
      
      $result= $query->fetch(PDO::FETCH_OBJ);
      return $result;
    }

    //show frontend users(customer) list
    public function showFrontendUserList(){

      $sql="select * from customer order by id";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //delete frontend users(customer)
    public function deleteFrontendUser($id){

      $delete= "delete from customer where id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Frontend User deleted successfully. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Frontend User not deleted.  </div>";
        return $msg;
      }
    }

    public function checkPassword($id, $old_pass)
    {
      $password= md5($old_pass);
      $sql= "select password from backend_user where id= :id  and  password= :password";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->bindValue(':password', $password);
      $query->execute();
      if($query->rowCount()>0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    public function updatePassword($id, $data)
    {
      $old_pass= $data['old_pass'];
      $new_pass= $data['new_pass'];

      if($old_pass== "" OR $new_pass== "")
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Field must not be empty!!! </div>";
        return $msg;
      }
      $chk_pass= $this->checkPassword($id, $old_pass);
      
      if($chk_pass== false)
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Old password not exist!!! </div>";
        return $msg;
      }
      if(strlen($new_pass)<5)
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Password length is too short. You have put at least 6 values </div>";
        return $msg;
      }

      $password=md5($new_pass);

      $sql= "update backend_user set password= :password where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':password', $password);    
      $query->bindValue(':id', $id);
      
      if($query->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Password updated successfully </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Password not updated !!!  </div>";
        return $msg;
      }
    }

    //show notification number count
    public function notificationSymbol(){

      $sql="select count(id) from feedback where status='0' order by id";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();

      $total_zero_status_rows= $result->fetchColumn();
      return $total_zero_status_rows;
    }
    //create new slide image
    public function addSlide($data){

      $title= $data['title'];

      /*Image work start*/
      $permitted= array('jpg', 'jpeg', 'png', 'gif');
      $image_file_name= $_FILES['image']['name'];
      $file_size= $_FILES['image']['size'];
      $file_temp_name= $_FILES['image']['tmp_name'];

      $divided= explode('.', $image_file_name);
      $file_extension= strtolower(end($divided));
      $unique_image= substr(md5(time()), 0, 10).'.'.$file_extension;
      $uploaded_image= "upload/slider/".$unique_image;
      /*Image work start*/

      if($title== "" ||  $image_file_name== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $title)){

        $msg= "<div style='color:red;''> <strong> Error!!! </strong> Category name must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
      }elseif (strlen($title)<3) {
          
        $msg= "<div style='color:red;''> <strong> Error!!! </strong> Title is too short (Upto 3 characters)</div>";
        return $msg;
      }

      if($file_size>1048567){
        $msg= "<div style='color:red;'> <strong> Error! </strong>Image size should be less than 1 MB. </div>";
        return $msg;
      }elseif (in_array($file_extension, $permitted) === false) {
        $msg= "<div style='color:red;'> <strong> Error! </strong>You can upload only: ".implode(', ', $permitted)."</div>";
        return $msg;
      }else{
        move_uploaded_file($file_temp_name, $uploaded_image);
      }

      $sql= "insert into slider(title, image) values(:t, :i)";
      $query= databaseClass::ourPrepareMethod($sql);

      $query->bindValue(':t', $title);
      $query->bindValue(':i', $uploaded_image);     
      if($query->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Thank You, you have been added a new slider. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, there has been problem to create your slider.  </div>";
        return $msg;
      }
    }
    //show sliders
    public function showSlideList(){

      $sql="select * from slider order by id limit 4";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //update post
    public function selectTheSlideById($id)
    {
      $sql= "select * from slider where id= :id limit 1";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->execute();
      
      $result= $query->fetch(PDO::FETCH_OBJ);
      return $result;
    }
    public function updateTheSlide($id, $data)
    {
      $title= $data['title'];

      /*Image work start*/
      $permitted= array('jpg', 'jpeg', 'png', 'gif');
      $image_file_name= $_FILES['image']['name'];
      $file_size= $_FILES['image']['size'];
      $file_temp_name= $_FILES['image']['tmp_name'];

      $divided= explode('.', $image_file_name);
      $file_extension= strtolower(end($divided));
      $unique_image= substr(md5(time()), 0, 10).'.'.$file_extension;
      $uploaded_image= "upload/slider/".$unique_image;
      /*Image work start*/

      if($title== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }else
      {
        if(preg_match('/[^A-Za-z0-9 ._-]+/i', $title)){

        $msg= "<div style='color:red;''> <strong> Error!!! </strong> Category name must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
        }elseif (strlen($title)<3) {
            
          $msg= "<div style='color:red;''> <strong> Error!!! </strong> Title is too short (Upto 3 characters)</div>";
          return $msg;
        }

        if(!empty($image_file_name))
        {
          if($file_size>1048567){
            $msg= "<div style='color:red;'> <strong> Error! </strong>Image size should be less than 1 MB. </div>";
            return $msg;
          }
          elseif (in_array($file_extension, $permitted) === false) {
            $msg= "<div style='color:red;'> <strong> Error! </strong>You can upload only: ".implode(', ', $permitted)."</div>";
            return $msg;
          }else{
            move_uploaded_file($file_temp_name, $uploaded_image);
          }

          $sql= "update slider set title= :t, image= :i where id= :id";
          $query= databaseClass::ourPrepareMethod($sql);
          $query->bindValue(':t', $title);
          $query->bindValue(':i', $uploaded_image);         
          $query->bindValue(':id', $id);
          
          if($query->execute())
          {
            $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>The slide updated successfully </div>";
            return $msg;
          }
          else
          {
            $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, the slide is not updated !!!  </div>";
            return $msg;
          }
        }else
        {
          $sql= "update slider set title= :t where id= :id";
          $query= databaseClass::ourPrepareMethod($sql);
          $query->bindValue(':t', $title);
          $query->bindValue(':id', $id);
          
          if($query->execute())
          {
            $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>The slide updated successfully </div>";
            return $msg;
          }
          else
          {
            $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, The slide is not updated !!!  </div>";
            return $msg;
          }
        }
      }
      
    }
    //delete slide
    public function deleteSlide($id){

      $delete= "delete from slider where id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>The slide deleted successfully. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, The slide is not deleted.  </div>";
        return $msg;
      }
    }
    //insert category type
    public function addCategory($data){
      $name= $data['categoryName'];

      if($name== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9, ._-]+/i', $name)){

      $msg= "<div style='color:red;''> <strong> Error!!! </strong> Category name must only contain alphanumerical, dashes and underscore.</div>";
      return $msg;
      }

      $sql= "insert into category(categoryName) values(:name)";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':name', $name);
      
      if($query->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Thank You, you have been added a new category. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, there has been problem to insert your category.  </div>";
        return $msg;
      }
    }
    //show categories
    public function showCategory(){

      $sql="select * from category";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //update category
    public function selectCategoryById($id)
    {
      $sql= "select * from category where id= :id limit 1";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->execute();
      
      $result= $query->fetch(PDO::FETCH_OBJ);
      return $result;
    }
    public function updateCategory($id, $data)
    {
      $name= $data['categoryName'];
      
      if($name==""){

        $msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Field must not empty.</div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

        $msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Name must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
      }

      $sql= "update category set categoryName= :name where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':name', $name);
      $query->bindValue(':id', $id);
      
      if($query->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>User data updated successfully </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, User data not updated !!!  </div>";
        return $msg;
      }
    }
    //delete portion
    public function deleteCategory($id){

      $delete= "delete from category where id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Category deleted successfully. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Category not deleted.  </div>";
        return $msg;
      }
    }
    //insert brand type
    public function addBrand($data){
      $name= $data['brandName'];

      if($name== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9, ._-]+/i', $name)){

      $msg= "<div style='color:red;''> <strong> Error!!! </strong> Brand name must only contain alphanumerical, dashes and underscore.</div>";
      return $msg;
      }

      $sql= "insert into brand(brandName) values(:name)";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':name', $name);
      
      if($query->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Thank You, you have been added a new brand. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, there has been problem to insert your brand.  </div>";
        return $msg;
      }
    }
    //show brands
    public function showBrand(){

      $sql="select * from brand";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //update category
    public function selectBrandById($id)
    {
      $sql= "select * from brand where id= :id limit 1";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->execute();
      
      $result= $query->fetch(PDO::FETCH_OBJ);
      return $result;
    }
    public function updateBrand($id, $data)
    {
      $name= $data['brandName'];
      
      if($name==""){

        $msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Field must not empty.</div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

        $msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Name must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
      }

      $sql= "update brand set brandName= :name where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':name', $name);
      $query->bindValue(':id', $id);
      
      if($query->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>User data updated successfully </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, User data not updated !!!  </div>";
        return $msg;
      }
    }
    //delete portion
    public function deleteBrand($id){

      $delete= "delete from brand where id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Brand deleted successfully. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Brand not deleted.  </div>";
        return $msg;
      }
    }
    //create new product
    public function addProduct($data){

      $name= $data['productName'];
      $cat_id= $data['category_id'];
      $brand_id=$data['brand_id'];
      $body= $data['body'];

      /*Image work start*/
      $permitted= array('jpg', 'jpeg', 'png', 'gif');
      $image_file_name= $_FILES['image']['name'];
      $file_size= $_FILES['image']['size'];
      $file_temp_name= $_FILES['image']['tmp_name'];

      $divided= explode('.', $image_file_name);
      $file_extension= strtolower(end($divided));
      $unique_image= substr(md5(time()), 0, 10).'.'.$file_extension;
      $uploaded_image= "upload/".$unique_image;
      /*Image work start*/

      $price= $data['price'];
      $type= $data['type'];

      if($name== "" || $cat_id== "" || $brand_id== "" || $body== "" || $image_file_name== "" || $price== "" || $type== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

        $msg= "<div style='color:red;''> <strong> Error!!! </strong> Category name must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
      }elseif (strlen($name)<3) {
          
        $msg= "<div style='color:red;''> <strong> Error!!! </strong> name is too short (Upto 3 characters)</div>";
        return $msg;
      }

      if($file_size>1048567){
        $msg= "<div style='color:red;'> <strong> Error! </strong>Image size should be less than 1 MB. </div>";
        return $msg;
      }elseif (in_array($file_extension, $permitted) === false) {
        $msg= "<div style='color:red;'> <strong> Error! </strong>You can upload only: ".implode(', ', $permitted)."</div>";
        return $msg;
      }else{
        move_uploaded_file($file_temp_name, $uploaded_image);
      }

      $sql= "insert into product(productName, category_id, brand_id, image, body, price, type) values(:n, :c, :b, :i, :body, :p, :t)";
      $query= databaseClass::ourPrepareMethod($sql);

      $query->bindValue(':n', $name);
      $query->bindValue(':c', $cat_id);
      $query->bindValue(':b', $brand_id);
      $query->bindValue(':i', $uploaded_image);
      $query->bindValue(':body', $body);
      $query->bindValue(':p', $price);
      $query->bindValue(':t', $type);
      
      if($query->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Thank You, you have been added a new product. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, there has been problem to create your product.  </div>";
        return $msg;
      }
    }
    //show products
    public function showProductList(){

      $sql="select product.*, category.categoryName, brand.brandName from product 
            inner join category
            on product.category_id = category.id
            inner join brand
            on product.brand_id = brand.id
            order by product.id";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //update post
    public function selectProductById($id)
    {
      $sql= "select * from product where id= :id limit 1";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->execute();
      
      $result= $query->fetch(PDO::FETCH_OBJ);
      return $result;
    }
    //update product
    public function updateProduct($id, $data)
    {  
      $name= $data['productName'];
      $cat_id= $data['category_id'];
      $brand_id= $data['brand_id'];
      $body= $data['body'];

      /*Image work start*/
      $permitted= array('jpg', 'jpeg', 'png', 'gif');
      $image_file_name= $_FILES['image']['name'];
      $file_size= $_FILES['image']['size'];
      $file_temp_name= $_FILES['image']['tmp_name'];

      $divided= explode('.', $image_file_name);
      $file_extension= strtolower(end($divided));
      $unique_image= substr(md5(time()), 0, 10).'.'.$file_extension;
      $uploaded_image= "upload/".$unique_image;
      /*Image work start*/

      $price= $data['price'];
      $type= $data['type'];

      if($name== "" || $cat_id== "" || $brand_id== "" || $body== "" || $price== "" || $type== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }else
      {
        if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

        $msg= "<div style='color:red;''> <strong> Error!!! </strong> Category name must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
        }elseif (strlen($name)<3) {
            
          $msg= "<div style='color:red;''> <strong> Error!!! </strong> Title is too short (Upto 3 characters)</div>";
          return $msg;
        }

        if(!empty($image_file_name))
        {
          if($file_size>1048567){
            $msg= "<div style='color:red;'> <strong> Error! </strong>Image size should be less than 1 MB. </div>";
            return $msg;
          }
          elseif (in_array($file_extension, $permitted) === false) {
            $msg= "<div style='color:red;'> <strong> Error! </strong>You can upload only: ".implode(', ', $permitted)."</div>";
            return $msg;
          }else{
            move_uploaded_file($file_temp_name, $uploaded_image);
          }

          $sql= "update product set productName= :pn, category_id= :c_id, brand_id= :b_id, body= :b, image= :i, price= :p, type= :t where id= :id";
          $query= databaseClass::ourPrepareMethod($sql);
          
          $query->bindValue(':pn', $name);
          $query->bindValue(':c_id', $cat_id);
          $query->bindValue(':b_id', $brand_id);
          $query->bindValue(':b', $body);
          $query->bindValue(':i', $uploaded_image);
          $query->bindValue(':p', $price);
          $query->bindValue(':t', $type);
          $query->bindValue(':id', $id);
          
          if($query->execute())
          {
            $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Product updated successfully </div>";
            return $msg;
          }
          else
          {
            $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Product not updated !!!  </div>";
            return $msg;
          }
        }
        else
        {
          $sql= "update product set productName= :pn, category_id= :c_id, brand_id= :b_id, body= :b, price= :p, type= :t where id= :id";
          $query= databaseClass::ourPrepareMethod($sql);
         
          $query->bindValue(':pn', $name);
          $query->bindValue(':c_id', $cat_id);
          $query->bindValue(':b_id', $brand_id);
          $query->bindValue(':b', $body);
          $query->bindValue(':p', $price);
          $query->bindValue(':t', $type);
          $query->bindValue(':id', $id);
          
          if($query->execute())
          {
            $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Product updated successfully </div>";
            return $msg;
          }
          else
          {
            $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Product not updated !!!  </div>";
            return $msg;
          }
        }
      }
      
    }
    //delete product
    public function deleteProduct($id){

      $delete= "delete from product where id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Product deleted successfully. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Product not deleted.  </div>";
        return $msg;
      }
    }
     //get all ordered products
    public function getAllOrderedProducts()
    {
      $sql= "select * from orders order by date desc";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->execute();
      $result= $query->fetchAll();

      return $result;
    }
    //show notification number count for ordered
    public function notificationSymbolForOrderedDetails(){

      $sql="select count(id) from orders where status='0' order by id";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();

      $total_zero_status_rows= $result->fetchColumn();
      return $total_zero_status_rows;
    }
    //get ordered product details
    public function getOrderedProductById($product_id)
    {
      $sql= "select product.*, category.categoryName, brand.brandName from product 
            inner join category
            on product.category_id = category.id
            inner join brand
            on product.brand_id = brand.id
            where product.id= :id
            order by product.id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $product_id);
      $query->execute();
      $result= $query->fetch(PDO::FETCH_OBJ);
      return $result;
    }
    //activate shift option
    public function shiftActivated($order_id, $customer_id, $product_id, $price, $date)
    {
      $sql= "update orders set status='1' where id= :o_id and customer_id= :c_id and product_id= :p_id and price= :p and date= :d";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':o_id', $order_id);
      $query->bindValue(':c_id', $customer_id);
      $query->bindValue(':p_id', $product_id);    
      $query->bindValue(':p', $price);
      $query->bindValue(':d', $date);
      
      if($query->execute())
      {
        echo "<script> window.location= 'order_details.php'; </script>";
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, Shift option not activated !!!  </div>";
        return $msg;
      }
    }
    //delete ordered product by admin
    public function orderProductDeleted($delete_order_id, $customer_id, $product_id, $price, $date)
    {
      $sql= "delete from orders where id= :o_id and customer_id= :c_id and product_id= :p_id and price= :p and date= :d";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':o_id', $delete_order_id);
      $query->bindValue(':c_id', $customer_id);
      $query->bindValue(':p_id', $product_id);    
      $query->bindValue(':p', $price);
      $query->bindValue(':d', $date);
      
      if($query->execute())
      {
        $msg= "<div style='color: green;'>Ordered product removed successfully !!!</div>";
        return $msg;
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, ordered product not removed !!!  </div>";
        return $msg;
      }
    }

    //update footer copyright
    public function updateFooterCopyright($data)
    {
      $text= $data['copyright'];
      
      if($text== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }
      else
      {
        $sql= "update footer set text= :t where id=1";
        $query= databaseClass::ourPrepareMethod($sql);
        $query->bindValue(':t', $text);
        
        if($query->execute())
        {
          $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Footer copyright updated successfully </div>";
          return $msg;
        }
        else
        {
          $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Footer coppyright not updated !!!  </div>";
          return $msg;
        }
      } 
    }

    //show feedbacks into the admin panel
    public function showFeedbackList(){

      $sql="select * from feedback where status='0' order by id";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //view feedbacks
    public function viewFeedbackById($id)
    {
      $sql= "select * from feedback where id= :id limit 1";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->execute();
      
      $result= $query->fetch(PDO::FETCH_OBJ);
      return $result;
    }
    //reply feedbacks by sending email
    public function feedReply($id, $data)
    {
      $to= $data['toemail'];
      $from= $data['fromemail'];
      $subject= $data['subject'];
      $reply= $data['reply'];

      if($to== "" || $from== "" || $subject== "" || $reply== "")
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty </div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $subject)){

        $msg= "<div style='color:red;'> <strong> Error!!! </strong> Subject must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
      }
      if(filter_var($from, FILTER_VALIDATE_EMAIL)==false){

        $msg= "<div style='color:red;'> <strong> Error!!! </strong>The email address is not valid. Please put like name@gmail.com </div>";
        return $msg;
      }

      $send_email= mail($to, $subject, $reply, $from);

      if($send_email)
      {
        $msg= "<div class='alert alert-success'> <strong> Successfull! </strong>E-mail sent successfully. </div>";
        return $msg;
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, E-mail not send. </div>";
        return $msg;
      }             
    }
    //update feedback status
    public function updateSeenFeedStatus($id)
    {
      
      $sql= "update feedback set status='1' where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);

      $query->bindValue(':id', $id);

      if($query->execute())
      {

        Session::init();
        Session::set("feed_msg", "<div style='color:green;'> <strong>Successfull! </strong>
        Feed moves into trash successfully. </div>");
        echo "<script> window.location= 'inbox.php'; </script>";
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, there has been problem to update your Feed status. </div>";
        return $msg;
      }           
    }
    //show seen feedbacks to delete after status updation
    public function showSeenFeedbackList(){

      $sql="select * from feedback where status='1' order by id";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //delete seen feedbacks
    public function deleteSeenFeeds($id){

      $delete= "delete from feedback where id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        Session::init();
        Session::set("feed_dlt_msg", "<div style='color:green;'> <strong>Successfull! </strong> Seen feedback deleted successfully. </div>");
        echo "<script> window.location= 'inbox.php'; </script>";

      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Seen feedback isn't not deleted.  </div>";
        return $msg;
      }
    }

    /* admin panel work end */

    /* frontend work start */

    //search product
    public function searchProduct($search, $track_start_page, $show_per_page){

      $sql="select * from product where productName like '%$search%' or body like '%$search%' limit $track_start_page, $show_per_page";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }

    //show iphone brand latest product 
    public function getIPhoneBrandLatestProduct()
    {
      $sql= "select * from product where brand_id= '1' order by id desc limit 1";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //show iphone brand all products
    public function getIPhoneBrandAllProducts($track_start_page, $show_per_page)
    {
      $sql= "select * from product where brand_id= '1' order by id desc limit $track_start_page, $show_per_page";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //pagination
    public function paginationForShowingIPhoneBrandAllProducts(){

      $sql= "select count(id) from product where brand_id='1'";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();

      $total_rows= $result->fetchColumn();
      return $total_rows;
    }
    //show acer brand latest product 
    public function getAcerBrandLatestProduct()
    {
      $sql= "select * from product where brand_id= '3' order by id desc limit 1";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
     //show acer brand all products
    public function getAcerBrandAllProducts($track_start_page, $show_per_page)
    {
      $sql= "select * from product where brand_id= '3' order by id desc limit $track_start_page, $show_per_page";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //pagination
    public function paginationForShowingAcerBrandAllProducts(){

      $sql= "select count(id) from product where brand_id='3'";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();

      $total_rows= $result->fetchColumn();
      return $total_rows;
    }
    //show HP brand latest product 
    public function getHPBrandLatestProduct()
    {
      $sql= "select * from product where brand_id= '4' order by id desc limit 1";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
     //show hp brand all products
    public function getHPBrandAllProducts($track_start_page, $show_per_page)
    {
      $sql= "select * from product where brand_id= '4' order by id desc limit $track_start_page, $show_per_page";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //pagination
    public function paginationForShowingHPBrandAllProducts(){

      $sql= "select count(id) from product where brand_id='4'";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();

      $total_rows= $result->fetchColumn();
      return $total_rows;
    }
    //show canon brand latest product 
    public function getCanonBrandLatestProduct()
    {
      $sql= "select * from product where brand_id= '5' order by id desc limit 1";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
     //show canon brand all products
    public function getCanonBrandAllProducts($track_start_page, $show_per_page)
    {
      $sql= "select * from product where brand_id= '5' order by id desc limit $track_start_page, $show_per_page";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //pagination
    public function paginationForShowingCanonBrandAllProducts(){

      $sql= "select count(id) from product where brand_id='5'";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();

      $total_rows= $result->fetchColumn();
      return $total_rows;
    }
    //show featured products
    public function showFeaturedProducts($track_start_page, $show_per_page)
    {
      $sql= "select * from product where type='0' order by id desc limit $track_start_page, $show_per_page";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //pagination
    public function paginationForShowingFeaturedProducts(){

      $sql= "select count(id) from product where type='0'";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();

      $total_rows= $result->fetchColumn();
      return $total_rows;
    }
    //show new or general products
    public function showGeneralProducts($track_start_page, $show_per_page)
    {
      $sql= "select * from product where type='1' order by id desc limit $track_start_page, $show_per_page";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    //pagination
    public function paginationForShowingGeneralProducts(){

      $sql= "select count(id) from product where type='1'";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();

      $total_rows= $result->fetchColumn();
      return $total_rows;
    }
    //get single product details
    public function getSingleProduct($id)
    {
      $sql= "select product.*, category.categoryName, brand.brandName from product 
            inner join category
            on product.category_id = category.id
            inner join brand
            on product.brand_id = brand.id
            where product.id= :id
            order by product.id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->execute();
      $result= $query->fetch(PDO::FETCH_OBJ);
      return $result;
    }
    //add to cart
    public function addToCart($id, $data)
    {
      $quantity= $data;
      $product_id= $id;
      $session_id= session_id();
      
      $sql= "select * from product where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $product_id);
      $query->execute();
      $result= $query->fetch(PDO::FETCH_ASSOC);
     
      $productName= $result['productName'];
      $price= $result['price'];
      $image= $result['image'];

      //start to avoid adding product duplicate time
      $check_add_query="select * from cart where session_id= :s_id and product_id= :p_id";
      $query= databaseClass::ourPrepareMethod($check_add_query);

      $query->bindValue(':s_id', $session_id);
      $query->bindValue(':p_id', $product_id);      
      $query->execute();

      if($query->rowCount()>0)
      {
        $msg= "Product already added!!!";
        return $msg;
      } 
      else
      {
 
        $sql= "insert into cart(session_id, product_id, productName, price, quantity, image) values(:s_id, :p_id, :n, :p, :q, :i)";
        $query= databaseClass::ourPrepareMethod($sql);

        $query->bindValue(':s_id', $session_id);
        $query->bindValue(':p_id', $product_id);
        $query->bindValue(':n', $productName);
        $query->bindValue(':p', $price);
        $query->bindValue(':q', $quantity);
        $query->bindValue(':i', $image);
        
        if($query->execute())
        {
          echo "<script> window.location= 'cart.php'; </script>";
        }
        else
        {
          echo "<script> window.location= 'details.php'; </script>";
        }
      } 
    }
    //show product to cart
    public function showProductToCart()
    {
      $session_id= session_id();

      $sql= "select * from cart where session_id= :id order by id";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->bindValue(':id',$session_id);
      $result->execute();
      return $result->fetchAll();
    }
    //update cart quantity
    public function updateCartQuantity($id, $data)
    {
      $cart_id= $id;
      $quantity= $data;

      if($quantity== "" || $quantity<= 0 )
      {
        $msg= "<div style='color:red;'> <strong> Error! </strong>Field must not be empty or zero</div> </br>";
        return $msg;
      }

      $sql= "update cart set quantity= :q where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':q', $quantity);
      $query->bindValue(':id', $cart_id);
      
      if($query->execute())
      {
        /*$msg= "<div style='color: green;'> Cart quantity updated successfully !!!</div> </br>";
        return $msg;*/
        echo "<script> window.location= 'cart.php'; </script>";
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, Cart quantity not updated !!! </div> </br>";
        return $msg;
      }
    }
    //delete product from cart
    public function deleteProductFromCart($id)
    {

      $delete= "delete from cart where id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        echo "<script> window.location= 'cart.php'; </script>";
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, Product not deleted from your cart list. </div> </br>";
        return $msg;
      }
    }
    //check cart table data
    public function checkCartTableData()
    {
      $session_id= session_id();
      $sql= "select * from cart where session_id= :id";
      $result= databaseClass::ourPrepareMethod($sql);

      $result->bindValue(':id', $session_id);
      $result->execute();
      return $result->fetchAll();
    }
    //fetch category name from product table
    public function getCategoryFromProduct($category_id)
    {
      $sql= "select category.categoryName from product
              inner join category
              on product.category_id=category.id
              where product.category_id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $category_id);
      $query->execute();
      
      return $query->fetch(PDO::FETCH_OBJ);
      
    }
    //to show product by category
    public function showProductByCategory($id, $track_start_page, $show_per_page)
    {
      // $sql= "select product.*, category.categoryName from product
      //         inner join category
      //         on product.category_id=category.id
      //         where product.category_id= :id 
      //         order by product.id desc 
      //         limit $track_start_page, $show_per_page";
      $sql= "select * from product where category_id= :id order by id desc limit $track_start_page, $show_per_page";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->execute();      
      $result= $query->fetchAll();
      return $result;
    }
    //pagination for showing differents categories products 
    public function paginationForShowingDifferentCategoriesProducts($category_id){
      
      //echo $category_id;

      $sql= "select count(product.id) from product 
            inner join category
            on product.category_id=category.id 
            where category_id= :c_id";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->bindValue(':c_id', $category_id);
      $result->execute();

      $total_rows= $result->fetchColumn();
      return $total_rows;
    }

    //customer registration
    public function customerRegistration($data)
    {
      $name= $data['name'];
      $country= $data['country'];
      $city= $data['city'];
      $zipcode= $data['zipcode'];
      $address= $data['address'];
      $phone= $data['phone'];
      $email= $data['email'];
      $password= $data['password'];

      if($name=="" || $country=="" || $city=="" || $zipcode=="" || $address=="" || $phone=="" || $email=="" || $password==""){

        $msg= "<div style='color: red;'> Field must not empty.</div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

        $msg= "<div style='color: red;'> Name must only contain alphanumerical, dashes, spaces and underscore.</div>";
        return $msg;
      }elseif (strlen($name)<3) {
          
        $msg= "<div style='color: red;'> Name is too short. It must be upto 3 characters. </div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z]+/i', $city)){

        $msg= "<div style='color: red;'> City name must only contain alphanumerical.</div>";
        return $msg;
      }
      if(preg_match('/[^0-9]+/i', $zipcode)){

        $msg= "<div style='color: red;'> Zipcode must only contain numbers.</div>";
        return $msg;
      }
      if(preg_match('/[^0-9+]+/i', $phone)){

        $msg= "<div style='color: red;'> Contact number must only contain numbers and (+) sign.</div>";
        return $msg;
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

        $msg= "<div style='color: red;'>The email address is not valid. Please put like name@gmail.com </div>";
        return $msg;
      }
      $email_chk= $this->customerEmailCheck($email);

      if($email_chk==true){

        $msg= "<div style='color: red;'> The email address already exist </div>";
        return $msg;
      }
      if(strlen($password)<6){
        $msg= "<div style='color: red;'> Password is too short. It must be greater than 5 digits. </div>";
        return $msg;
      }

      $password= md5($data['password']);
      
      $sql= "insert into customer(customerName, country, city, zipcode, address, phone, email, password) values(:name, :country, :c, :z, :a, :p, :email, :password)";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':name', $name);
      $query->bindValue(':country', $country);
      $query->bindValue(':c', $city);
      $query->bindValue(':z', $zipcode);
      $query->bindValue(':a', $address);
      $query->bindValue(':p', $phone);
      $query->bindValue(':email', $email);
      $query->bindValue(':password', $password);
      
      if($query->execute())
      {
        $msg= "<div style='color: green;'> Thank You, you have been registered successfully...</div>";
        return $msg;
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, there has been problem to insert your details  </div>";
        return $msg;
      }
    }
    //check customer email
    public function customerEmailCheck($email)
    {
      $sql= "select * from customer where email= :email";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':email', $email);
      $query->execute();
      if($query->rowCount()>0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    //customer login
    public function getLoginCustomer($email, $password)
    {
      $sql= "select * from customer where email= :email and password= :password limit 1";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':email', $email);
      $query->bindValue(':password', $password);
      $query->execute();
      
      return $query->fetch(PDO::FETCH_OBJ);
      
    }
    public function customerLogin($data)
    {
      $email= $data['email'];
      $password= ($data['password']);
          
      if($email== "" OR $password== "")
      {
        $msg= "<div style='color: red;'>Field must not be empty </div>";
        return $msg;
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL)== false)
      {
      
        $msg= "<div style='color: red;'>The email address is not valid. Please put like name@gmail.com </div>";
        return $msg;
    
      }
      $chk_email= $this->customerEmailCheck($email);

      if($chk_email== false)
      {
        $msg= "<div style='color: red;'>The email address does not match... </div>";
        return $msg;
      }
      if(strlen($password)<6)
      {
        $msg= "<div style='color: red;'>Password is too short. It must be greater than 5 digits. </div>";
        return $msg;
      }
      $password= md5($data['password']);

      $result= $this->getLoginCustomer($email, $password);

      if($result)
      {
        Session::init();
        Session::set("customer_login", true);
        Session::set("customer_id", $result->id);
        Session::set("customer_name", $result->customerName);
        Session::set("customer_country", $result->country);
        Session::set("customer_city", $result->city);
        Session::set("customer_zipcode", $result->zipcode);
        Session::set("customer_address", $result->address);
        Session::set("customer_phone", $result->phone);
        Session::set("customer_login_msg", "<div style='color: green;'> You are logged in... </div>");
        header("Location: cart.php");
      }
      else
      {
        $msg= "<div style='color: red;'> Data not found ! </div>";
        return $msg;
      }
    }
    //delete_cart_data_for_a_customer
    public function deleteCartDataForACustomerAfterLogout()
    {
      $session_id= session_id();

      $delete= "delete from cart where session_id=:id";
      $result= databaseClass::ourPrepareMethod($delete);
      $result->bindValue(':id', $session_id);
      $result->execute();
    }

    //get customer data in his/her profile
    public function getCustomerById($id)
    {
      $sql= "select * from customer where id= :id limit 1";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->execute();
      
      $result= $query->fetch(PDO::FETCH_OBJ);
      return $result;
    }
    //update customer profile
    public function updateCustomerData($id, $data)
    {
      $name= $data['name'];
      $country= $data['country'];
      $city= $data['city'];
      $zipcode= $data['zipcode'];
      $address= $data['address'];
      $phone= $data['phone'];
      $email= $data['email'];
      
      if($name=="" || $country=="" || $city=="" || $zipcode=="" || $address=="" || $phone=="" || $email==""){

        $msg= "<div style='color: red;'> Field must not empty.</div> </br>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

        $msg= "<div style='color: red;'> Name must only contain alphanumerical, dashes, spaces and underscore.</div> </br>";
        return $msg;
      }elseif (strlen($name)<3) {
          
        $msg= "<div style='color: red;'> Name is too short. It must be upto 3 characters. </div> </br>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z]+/i', $city)){

        $msg= "<div style='color: red;'> City name must only contain alphanumerical.</div> </br>";
        return $msg;
      }
      if(preg_match('/[^0-9]+/i', $zipcode)){

        $msg= "<div style='color: red;'> Zipcode must only contain numbers.</div> </br>";
        return $msg;
      }
      if(preg_match('/[^0-9+]+/i', $phone)){

        $msg= "<div style='color: red;'> Contact number must only contain numbers and (+) sign.</div> </br>";
        return $msg;
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

        $msg= "<div style='color: red;'>The email address is not valid. Please put like name@gmail.com </div> </br>";
        return $msg;
      }

      $sql= "update customer set customerName= :name, country= :country, city= :c, zipcode= :z, address= :a, phone= :p, email= :email where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':name', $name);
      $query->bindValue(':country', $country);
      $query->bindValue(':c', $city);
      $query->bindValue(':z', $zipcode);
      $query->bindValue(':a', $address);
      $query->bindValue(':p', $phone);
      $query->bindValue(':email', $email);
      $query->bindValue(':id', $id);
      
      if($query->execute())
      {
        $msg= "<div style='color: green;'>Your data updated successfully... </div> </br>";
        return $msg;
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, Your data not updated !!!  </div> </br>";
        return $msg;
      }
    }
    //change customer password
    public function checkCustomerPassword($id, $old_pass)
    {
      $password= md5($old_pass);
      $sql= "select password from customer where id= :id  and  password= :password";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $id);
      $query->bindValue(':password', $password);
      $query->execute();
      if($query->rowCount()>0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    public function updateCustomerPassword($id, $data)
    {
      $old_pass= $data['old_pass'];
      $new_pass= $data['password'];

      if($old_pass== "" OR $new_pass== "")
      {
        $msg= "<div style='color: red;'>Field must not be empty!!! </div> </br>";
        return $msg;
      }
      $chk_pass= $this->checkCustomerPassword($id, $old_pass);
      
      if($chk_pass== false)
      {
        $msg= "<div style='color: red;'>Old password not exist!!! </div> </br>";
        return $msg;
      }
      if(strlen($new_pass)<=5)
      {
        $msg= "<div style='color: red;'>Password length is too short. You have put at least 6 values </div> </br>";
        return $msg;
      }

      $new_password=md5($new_pass);

      $sql= "update customer set password= :password where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':password', $new_password);    
      $query->bindValue(':id', $id);
      
      if($query->execute())
      {
        $msg= "<div style='color: green;'>Password updated successfully... </div> </br>";
        return $msg;
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, Password not updated !!!  </div> </br>";
        return $msg;
      }
    }
    //recovery customer password by sending email
    public function customerPasswordRecover($data){
      $email= $data['email'];

      if($email == ""){
        $msg= "<div style='color: red;'>Field must not be empty !!!</div> </br>";
        return $msg;
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

        $msg= "<div style='color: red;'>The email address is not valid. Please put like name@gmail.com </div> </br>";
        return $msg;    
      }

      $email_chk= $this->customerEmailCheck($email);

      if($email_chk==true)
      {
        
        $new_generate= substr($email, 0, 3);
        $random= rand(10000, 99999);
        $combine= "$new_generate$random";
        $new_pass= md5($combine);

        $sql= "update customer set password= :p where email= :email";
        $query= databaseClass::ourPrepareMethod($sql);

        $query->bindValue(':p', $new_pass);
        $query->bindValue(':email', $email);
        $query->execute();

        //new work start

        $sender = 'sender_email@gmail.com';

        $developmentMode = true;
        $mailer = new PHPMailer($developmentMode);
        $mailer->Mailer = "smtp";

        try 
        {
            $mailer->SMTPDebug = 0;
            $mailer->isSMTP();

            if ($developmentMode) 
            {
                $mailer->SMTPOptions = [
                    'ssl'=> [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    ]
                ];
            }

            $mailer->Host = 'smtp.gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->Username = $sender;
            $mailer->Password = 'sender_email_password';
            $mailer->SMTPSecure = 'tls';
            $mailer->Port = 587;

            $mailer->setFrom($sender, 'Author');
            $mailer->addAddress($email);

            $mailer->isHTML(true);
            $mailer->Subject = 'Your New Password';
            $mailer->Body = "Your new password is ".$combine.". Please visit our website to login";
       
            //$mailer->ClearAllRecipients();
            //echo "E-mail has been sent successfully !!!";
            if($mailer->send())
            {
              $msg= "<div style='color: green;'>E-mail has been sent successfully !!! Please check your email for getting new password.</div> </br>";
              return $msg;
            }
        } 
        catch (Exception $e) 
        {
            echo "E-mail sending failed. INFO: " . $mailer->ErrorInfo;
        }
        //new work end           
      }
      else
      {
        $msg= "<div style='color: red;'> The email address doesn't exist. </div> </br>";
        return $msg;
      }
    }
    //order product
    public function orderProduct($id)
    {
      //$check=0;
      $customer_id= $id;
      //echo "customer_id: ".$customer_id."</br>";
      $session_id= session_id();
      //echo "session_id: ".$session_id."</br>";
      $sql= "select * from cart where session_id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $session_id);
      $query->execute();
      $result= $query->fetchAll();

      // echo "<pre>";
      //   print_r($result);
      // echo "</pre>";

      if($result)
      {
        foreach ($result as $key => $value) 
        {
          $product_id= $value['product_id'];
          $product_name= $value['productName'];
          $quantity= $value['quantity'];
          $price= $value['price'] * $value['quantity'];
          $image= $value['image'];

      // echo "product_id: ".$product_id."</br>";
      // echo "product_name: ".$product_name."</br>";
      // echo "quantity: ".$quantity."</br>";
      // echo "price: ".$price."</br>";
      // echo "image: ".$image."</br>";

          $sql2= "insert into orders(customer_id, product_id, productName, quantity, price, image) values(:c_id, :p_id, :n, :q, :p, :i)";
          $query2= databaseClass::ourPrepareMethod($sql2);

          $query2->bindValue(':c_id', $customer_id);
          $query2->bindValue(':p_id', $product_id);
          $query2->bindValue(':n', $product_name);
          $query2->bindValue(':q', $quantity);
          $query2->bindValue(':p', $price);
          $query2->bindValue(':i', $image);

          $result2= $query2->execute();

        // echo "<pre>";
        //   print_r($query2);
        // echo "</pre>";
     
        // if($result2)
        //   {
        //    $check=1;
        //    echo "<pre>";
        //       print_r($check);
        //    echo "</pre>";
        //   }
        //   else
        //   {
        //     $check=0;
        //   } 
        // }

          if($result2)
          {
            echo "<script> window.location= 'order_success.php'; </script>";
          }
          else
          {
            $msg= "<div style='color: red;'>Sorry, there has been a problem to order.Please try again.  </div> </br>";
            return $msg;
          } 
        }     
      }
    }

    //to show payable amount
    public function payableAmount($customer_id)
    {

      $sql= "select price from orders where customer_id= :c_id and date= now()";
      $query= databaseClass::ourPrepareMethod($sql);      
      $query->bindValue(':c_id', $customer_id);
      $query->execute();
      $result= $query->fetchAll();

      return $result;
    }
    //grt ordered details
    public function orderDetails($id)
    {
      $customer_id= $id;

      $sql= "select * from orders where customer_id= :c_id order by date desc";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':c_id', $customer_id);
      $query->execute();
      $result= $query->fetchAll();

      return $result;
    }
    //activate shift confirmation option
    public function shiftConfirmed($order_id, $customer_id, $product_id, $price, $date)
    {
      $sql= "update orders set status='2' where id= :o_id and customer_id= :c_id and product_id= :p_id and price= :p and date= :d";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':o_id', $order_id);
      $query->bindValue(':c_id', $customer_id);
      $query->bindValue(':p_id', $product_id);    
      $query->bindValue(':p', $price);
      $query->bindValue(':d', $date);
      
      if($query->execute())
      {
        echo "<script> window.location= 'order_details.php'; </script>";
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, Shift confirmation option not activated !!!  </div>";
        return $msg;
      }
    }
    //delete product from order details
    public function deleteProductFromOrderDetails($id)
    {

      $delete= "delete from orders where id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        echo "<script> window.location= 'order_details.php'; </script>";
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, Product not deleted from your ordered list. </div>";
        return $msg;
      }
    }
    //add to comparison product list
    public function insertComparisonProduct($customer_id, $comparison_product_id)
    { 
      $check_sql= "select * from comparison where customer_id= :c_id and product_id= :p_id";
      $check_query= databaseClass::ourPrepareMethod($check_sql);
      $check_query->bindValue(':c_id', $customer_id);
      $check_query->bindValue(':p_id', $comparison_product_id);
      $check_query->execute();

      if($check_query->rowCount()>0)
      {
        $msg= "<div style='color: red;'>Product already added to your comparison list. </div>";
        return $msg;
      } 

      $sql= "select * from product where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $comparison_product_id);
      $query->execute();
      $result= $query->fetch(PDO::FETCH_OBJ);
     
      if($result)
      {
        $product_id= $result->id;
        $product_name= $result->productName;
        $image= $result->image;
        $price= $result->price;       

        $sql2= "insert into comparison(customer_id, product_id, productName, image, price) values(:c_id, :p_id, :n, :i, :p)";
        $query2= databaseClass::ourPrepareMethod($sql2);

        $query2->bindValue(':c_id', $customer_id);
        $query2->bindValue(':p_id', $product_id);
        $query2->bindValue(':n', $product_name);        
        $query2->bindValue(':i', $image);
        $query2->bindValue(':p', $price);
        
        if($query2->execute())
        {
          $msg= "<div style='color: green;'>Added!!! Check comparison list. </div>";
          return $msg;
        }
        else
        {
          $msg= "<div style='color: red;'>Sorry, Product not added to your comparison list. </div>";
          return $msg;
        }
      } 
      else
      {
        $msg= "<div style='color: red;'>Sorry, Product details not found. </div>";
        return $msg;       
      } 
    }
    //get comparison product details
    public function showComparisonProducts($id)
    {
      $customer_id= $id;

      $sql= "select * from comparison where customer_id= :c_id order by id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':c_id', $customer_id);
      $query->execute();
      $result= $query->fetchAll();

      return $result;
    }
    //delete_comparison_data_for_a_customer_after_logout
    public function deleteComparisonDataForACustomerAfterLogout($customer_id)
    {
      $delete= "delete from comparison where customer_id=:c_id";
      $result= databaseClass::ourPrepareMethod($delete);
      $result->bindValue(':c_id', $customer_id);
      $result->execute();
    }
     //delete product from comparison list
    public function deleteProductFromComparison($id)
    {

      $delete= "delete from comparison where product_id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        echo "<script> window.location= 'comparison_products.php'; </script>";
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, Product not deleted from your comparison list. </div>";
        return $msg;
      }
    }
    //add product to wishlist
    public function insertWishlistProduct($customer_id, $wishlist_product_id)
    { 
      $check_sql= "select * from wishlist where customer_id= :c_id and product_id= :p_id";
      $check_query= databaseClass::ourPrepareMethod($check_sql);
      $check_query->bindValue(':c_id', $customer_id);
      $check_query->bindValue(':p_id', $wishlist_product_id);
      $check_query->execute();

      if($check_query->rowCount()>0)
      {
        $msg= "<div style='color: red;'>Product already added to your wishlist. </div>";
        return $msg;
      } 

      $sql= "select * from product where id= :id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':id', $wishlist_product_id);
      $query->execute();
      $result= $query->fetch(PDO::FETCH_OBJ);
     
      if($result)
      {
        $product_id= $result->id;
        $product_name= $result->productName;
        $image= $result->image;
        $price= $result->price;       

        $sql2= "insert into wishlist(customer_id, product_id, productName, image, price) values(:c_id, :p_id, :n, :i, :p)";
        $query2= databaseClass::ourPrepareMethod($sql2);

        $query2->bindValue(':c_id', $customer_id);
        $query2->bindValue(':p_id', $product_id);
        $query2->bindValue(':n', $product_name);        
        $query2->bindValue(':i', $image);
        $query2->bindValue(':p', $price);
        
        if($query2->execute())
        {
          $msg= "<div style='color: green;'>Added!!! Check wishlist. </div>";
          return $msg;
        }
        else
        {
          $msg= "<div style='color: red;'>Sorry, Product not added to your wishlist. </div>";
          return $msg;
        }
      } 
      else
      {
        $msg= "<div style='color: red;'>Sorry, Product details not found. </div>";
        return $msg;       
      } 
    }
    //get wishlist product details
    public function showWishlistProducts($id)
    {
      $customer_id= $id;

      $sql= "select * from wishlist where customer_id= :c_id order by id";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':c_id', $customer_id);
      $query->execute();
      $result= $query->fetchAll();

      return $result;
    }
     //delete product from wishlist
    public function deleteProductFromWishlist($id)
    {

      $delete= "delete from wishlist where product_id=:id";
      $result= databaseClass::ourPrepareMethod($delete);

      $result->bindValue(':id', $id);
      if($result->execute())
      {
        echo "<script> window.location= 'wishlist.php'; </script>";
      }
      else
      {
        $msg= "<div style='color: red;'>Sorry, Product not deleted from your wishlist. </div>";
        return $msg;
      }
    }
    //show footer copyright
    public function showFooterCopyright(){

      $sql="select * from footer where id=1";
      $result= databaseClass::ourPrepareMethod($sql);
      $result->execute();
      return $result->fetchAll();
    }
    
    //User feedback
    public function userFeedback($data)
    {
      $name= $data['name'];
      $email= $data['email'];
      $body= $data['body'];
          
      if($name== " " OR $email== " " OR $body== " ")
      {
        $msg= "<div style='color: red;'>Field must not be empty </div>";
        return $msg;
      }
      if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

        $msg= "<div style='color: red;'> Firstname must only contain alphanumerical, dashes and underscore.</div>";
        return $msg;
      }

      if(filter_var($email, FILTER_VALIDATE_EMAIL)==false)
      {

        $msg= "<div style='color: red;'>The email address is not valid. Please put like name@gmail.com </div>";
        return $msg;
      }

      $sql= "insert into feedback(name, email, body) values(:n, :e, :b)";
      $query= databaseClass::ourPrepareMethod($sql);
      $query->bindValue(':n', $name);
      $query->bindValue(':e', $email);
      $query->bindValue(':b', $body);
      
      if($query->execute())
      {
        $msg= "<div style='color: green;'> Thank You, your queries accepted by author.</div>";
        return $msg;
      }
      else
      {
        $msg= "<div style='color: red;'> Sorry, there has been problem to send your queries. </div>";
        return $msg;
      }
    }
    /**frontend portion end **/ 
  }
?>