<?php
require_once("User.php");
require_once("session_helper.php");
class Users
{
    private $userModel;
    public function __construct(){
        $this->userModel = new User;

    }
    public function register(){
        //sanitize post data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //initialise data array
        $data = [
            'firstname' => trim($_POST['firstname']),
            'lastname' => trim($_POST['lastname']),
            'username' => trim($_POST['username']),
            'password' => trim($_POST['password']),
            'passwordrepeat' => trim($_POST['passwordrepeat'])
        ];
        //input validation
        //empty fields
        if(empty($data['username']) || empty($data['lastname']) ||
            empty($data['password']) || empty($data['passwordrepeat'])){
            flash("register", "Please fill out all inputs");
            header("Location:../signup.php");
            exit();

        }
        //valid char
        if(!preg_match("/^[a-zA-Z0-9]*$/", $data['username'])) {
            flash("register", "Invalid username");
            header("Location:../signup.php");
            exit();

        }
        //password length must be <6
        if(strlen($data['password']) < 6){
            flash("register", "Invalid password");
            header("Location:../signup.php");
            exit();

        }
        //check if passwords match
        else if($data['password'] !== $data['passwordrepeat']){
            flash("register", "Passwords don't match");
            header("Location:../signup.php");
            exit();

        }
        //user with existing username in database
        if($this->userModel->findUserByUsername($data['username'])){
            flash("register", "Username already taken");
            header("Location:../signup.php");
            exit();

        }
        //Passed all validation checks.
        //hashing the password input
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if($this->userModel->register($data)){
            header("Location:../login.php");
            exit();
        }else{
            die("Something went wrong");
        }

    }
    //function that logs the user in
    public function login()
    {
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data array
        $data = [
            'username' => trim($_POST['username']),
            'password' => trim($_POST['password'])
        ];
        //empty field validation
        if (empty($data['username']) || empty($data['password'])) {
            flash("login", "Please fill out all inputs");
            header("Location: ../login.php");
            exit();

        }

        //Check for username to find user
        if($this->userModel->findUserByUsername($data['username'])){
            //User Found
            $loggedInUser = $this->userModel->login($data['username'], $data['password']);
            if($loggedInUser){
                //Create session
                $this->createUserSession($loggedInUser);
            }else{
                flash("login", "Password Incorrect");
                header("Location:../login.php");
                exit();
            }
        }else{
            flash("login", "No user found");
            header("Location:../login.php");
            exit();

        }
    }
    //create the session
    public function createUserSession($user){
        //setting session to user fields
        $_SESSION['id'] = $user->id;
        $_SESSION['firstname'] = $user->firstname;
        $_SESSION['username'] = $user->username;
        header("Location:../index.php");
        exit();

    }
    //destroy the session
    public function logout(){
        //unset fields
        unset($_SESSION['id']);
        unset($_SESSION['firstname']);
        unset($_SESSION['username']);
        session_destroy();
        header("Location:../index.php");
        exit();

    }

}
$init = new Users;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    switch($_POST['type']) {
        case 'register':
            $init->register();
            break;
        case 'login':
            $init->login();
            break;
        default:
            header("Location:../index.php");
            exit();

    }
}
else
{
    switch($_GET['q']){
        case 'logout':
            $init->logout();
            break;
        default:
            header("Location:../index.php");
            exit();

    }
}