<?php

/**
 * File to handle all API requests
 * Accepts GET and GET
 * 
 * Each request will be identified by TAG
 * Response will be JSON data
 * check for GET request 
 */
if (isset($_GET['tag']) && $_GET['tag'] != '') 
{
    // GET tag
    $tag = $_GET['tag'];

    // include db handler
    require_once 'Source Files/include/DB_Functions.php';
    $db = new DB_Functions();

    // response Array
    $response = array("tag" => $tag, "error" => FALSE);

    // check for tag type
    if ($tag == 'login') 
    {
        // Request type is check Login
        $login = $_GET['login'];
        $password = $_GET['password'];

        // check for user
        $user = $db->getUserByLoginAndPassword($login, $password);
        if ($user != false) 
        {
            // user found
            $response["error"] = FALSE;
            $response["id"] = $user["id"];
            $response["utilisateurs"]["nom"] = $user["nom"];
            $response["utilisateurs"]["mail"] = $user["mail"];
            echo json_encode($response);
        } 
        else 
        {
            // user not found
            // echo json with error = 1
            $response["error"] = TRUE;
            $response["error_msg"] = "Mauvais login ou mot de passe!";
            echo json_encode($response);
        }
    }
    elseif($tag == 'listUser') 
    {

        $listUser = $db->getUser();

        echo "{ \"eleve\": ".json_encode($listUser)." }";
     }  
     else 
     {
         // user failed to store
         $response["error"] = TRUE;
         $response["error_msg"] = "Unknow 'tag' value. It should be either 'login' or 'listUser'";
         echo json_encode($response);
     }
} 
else 
{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter 'tag' is missing!";
    echo json_encode($response);
}
    ?>