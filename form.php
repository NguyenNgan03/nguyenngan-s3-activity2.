<?php

function validate_message($message)
{
        // function to check if message is correct (must have at least 10 caracters (after trimming))
    $trimmed_message = trim($message);
    return strlen($trimmed_message)>=10;
}

function validate_username($username)
{
    // function to check if username is correct (must be alphanumeric => Use the function 'ctype_alnum()')
    return ctype_alnum($username);

}

function validate_email($email)
{
    // function to check if email is correct (must contain '@')
    $trimmed_email = trim($email);
    return filter_var($trimmed_email, FILTER_VALIDATE_EMAIL) !== false;
}

$user_error = "";
$email_error = "";
$terms_error = "";
$message_error = "";

$username = "";
$email = "";
$message = "";

$form_valid = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $terms = $_POST['terms'] ?? null;    
    if(empty($username)){
        $user_error = "Please enter your name";
    }
    elseif(!validate_username($username)){
        $user_error= 'Username should contains only letters and numbers';
    }
    if(empty($email)){
        $email_error='please enter email';
    }
    elseif(!validate_email($email)){
    $email_error = "email must contain '@'";
    }
    if(empty($message)){
        $message_error = "please enter message";
    }
    elseif(!validate_message($message)){
        $message_error = "Message must be at least 10 caracters long";
    }
    if(!isset($terms)){
        $terms_error = 'You must accept the Terms of Service';
    }
    if(empty($user_error)&&empty($email_error)&&empty($terms_error)&&empty($message_error)){
        $form_valid = true;
    }
    // Here is the list of error messages that can be displayed:
    //
    // "Message must be at least 10 caracters long"
    // "You must accept the Terms of Service"
    // "Please enter a username"
    // "Username should contains only letters and numbers"
    // "Please enter an email"
    // "email must contain '@'"
}
?>
<form action="#" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username">
            <small class="form-text text-danger"> <?php echo $user_error; ?></small>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter email" name="email">
            <small class="form-text text-danger"> <?php echo $email_error; ?></small>
        </div>
    </div>
    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"></textarea>
        <small class="form-text text-danger"> <?php echo $message_error; ?></small>
    </div>
    <div class="mb-3">
        <input type="checkbox" class="form-control-check" name="terms" id="terms" value="terms"> <label for="terms">I accept the Terms of Service</label>
        <small class="form-text text-danger"> <?php echo $terms_error; ?></small>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<hr>

<?php
if ($form_valid) :
?>
    <div class="card">
        <div class="card-header">
            <p><?php echo $username; ?></p>
            <p><?php echo $email; ?></p>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $message; ?></p>
        </div>
    </div>
<?php
endif;
?>