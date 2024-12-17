<?php
// Initialize the session
require_once("log and reg backend/classes/controller.Gmail.php");
require_once("log and reg backend/classes/model.User.php");
require_once("log and reg backend/config/config.php");

if(session_id() === "") session_start();

if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        case 1: header("Location: admin/admin-dashboard.php"); break;
        case 2: header("Location: staff/staff-dashboard.php"); break;
        case 3: header("Location: instructor/instructor-dashboard.php"); break;
        case 4: header("Location: student/student-dashboard.php"); break;
    }
}

// Update the following variables
$google_oauth_client_id = GOOGLE_CLIENT_ID;
$google_oauth_client_secret = GOOGLE_CLIENT_SECRET;
$google_oauth_redirect_uri = GOOGLE_REDIRECT_URL;
$google_oauth_version = 'v3';
// If the captured code param exists and is valid
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Execute cURL request to retrieve the access token
    $params = [
        'code' => $_GET['code'],
        'client_id' => $google_oauth_client_id,
        'client_secret' => $google_oauth_client_secret,
        'redirect_uri' => $google_oauth_redirect_uri,
        'grant_type' => 'authorization_code'
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response, true);
    // Make sure access token is valid
    if (isset($response['access_token']) && !empty($response['access_token'])) {
        // Execute cURL request to retrieve the user info associated with the Google account
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/' . $google_oauth_version . '/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
        $response = curl_exec($ch);
        curl_close($ch);
        $profile = json_decode($response, true);
        // Make sure the profile data exists
        if (isset($profile['email'])) {
            $google_name_parts = [];
            // Sanitize and get the given name
            if (isset($profile['given_name'])) {
                $google_name_parts['given_name'] = preg_replace('/[^a-zA-Z0-9.]/s', ' ', $profile['given_name']);
            } else {
                $google_name_parts['given_name'] = ''; // Default to empty if not set
            }

            // Sanitize and get the family name
            if (isset($profile['family_name'])) {
                $google_name_parts['family_name'] = preg_replace('/[^a-zA-Z0-9.]/s', '', $profile['family_name']);
            } else {
                $google_name_parts['family_name'] = ''; // Default to empty if not set
            }

            // Combine names if needed
            $fullName = trim($google_name_parts['given_name'] . ' ' . $google_name_parts['family_name']);
            $_SESSION["fullname"] = $fullName;
            $_SESSION["givenName"] = $google_name_parts['given_name'];
            $_SESSION["familyName"] = $google_name_parts['family_name'];

            // Authenticate the user
            session_regenerate_id();
            $_SESSION['google_loggedin'] = TRUE;
            $_SESSION['google_email'] = $profile['email'];
            $_SESSION['google_name'] = implode("", $google_name_parts);
            $_SESSION['google_picture'] = isset($profile['picture']) ? $profile['picture'] : '';
            // Put Conditional Statement here to check if user is already registerd in the db or not
            // Redirect to registration form if not, and redirect to dashbaord/profile page if yes
            
            if($_SESSION["google_email"] == "eduportalmain@gmail.com"){
                $gmailControl = new GmailController($_SESSION['google_email'] ,"admin admin");
            }else{
                $gmailControl = new GmailController($_SESSION['google_email'] ,$_SESSION['google_name']);
            }
            
            if($gmailControl->isRegistered() == true){
                $id = $gmailControl->getId();
                $userCategory = $gmailControl->getCategory();
                $address = $gmailControl->getAddress();
                echo var_dump($address);
                echo "testing";
                $_SESSION["address"] =  $address[0]["address"];
                echo "Session ". $_SESSION["address"];
         
                $_SESSION['user_id'] = $id[0]['user_id'];
                $_SESSION["user_category"] =  $userCategory[0]["user_category"];
                switch($_SESSION["user_category"]){
                    case 1:
                        header('Location: admin/admin-dashboard.php');
                        break;
                    case 2:
                        header('Location: staff/staff-dashboard.php');
                        break;
                    case 3:
                        header('Location: instructor/instructor-dashboard.php');
                        break;
                    case 4:
                        header('Location: student/student-dashboard.php');
                        break;
                }

                exit();
            }else{
              $_SESSION['signUp'] = "true";
              header('Location: index.php');
              exit();
            }
            // Redirect to profile page
          //  header('Location: profile.php');
            exit;
        } else {
            exit('Could not retrieve profile information! Please try again later!');
        }
    } else {
        exit('Invalid access token! Please try again later!');
    }
} else {
    // Define params and redirect to Google Authentication page
    $params = [
        'response_type' => 'code',
        'client_id' => $google_oauth_client_id,
        'redirect_uri' => $google_oauth_redirect_uri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ];
    header('Location: https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
    exit;
}
?>
