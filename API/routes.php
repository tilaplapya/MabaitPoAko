<?php 
    require_once "./modules/get.php";
    //require_once "./modules/post.php";
    require_once "./config/database.php";

    $conn = new Connection();
    $pdo = $conn->connect();
    // Initialize Get and Post objects
    $get = new Get($pdo);
    //$post = new Post($pdo);
   

    // Check if 'request' parameter is set in the request
    if(isset($_REQUEST['request'])){
         // Split the request into an array based on '/'
        $request = explode('/', $_REQUEST['request']);
    }
    else{
         // If 'request' parameter is not set, return a 404 response
        echo "Not Found";
        http_response_code(404);
    }

    // Handle requests based on HTTP method
    switch($_SERVER['REQUEST_METHOD']){
        // Handle GET requests
        case 'GET':
            switch($request[0]){
                case 'employees':
                    // Return JSON-encoded data for getting employees
                    //echo json_encode($get->get_employees());
                    //break;
                    if(count($request)>1){
                        echo json_encode($get->get_employees($request[1]));
                    }
                    else{
                        echo json_encode($get->get_employees());
                    }
                
                case 'jobs':
                    // Return JSON-encoded data for getting jobs
                    if(count($request)>1){
                        //echo json_encode($get->get_jobs($request[1]));
                    }
                    else{
                       // echo json_encode($get->get_jobs());
                    }
                
                default:
                    // Return a 403 response for unsupported requests
                    echo "This is forbidden";
                    http_response_code(403);
                    break;
            }
            break;
        // Handle POST requests    
        case 'POST':
            // Retrieves JSON-decoded data from php://input using file_get_contents
            $data = json_decode(file_get_contents("php://input"));
            switch($request[0]){
                case 'addemployee':
                    if(count($request)>1){
                        echo json_encode($post->add_employees($request[1]));
                    }
                    else{
                        echo json_encode($post->add_employees());
                    }
                
                case 'addjob':
                    if(count($request)>1){
                        echo json_encode($post->add_jobs($request[1]));
                    }
                    else{
                        echo json_encode($post->add_jobs());
                    }
                
                default:
                    // Return a 403 response for unsupported requests
                    echo "This is forbidden";
                    http_response_code(403);
                    break;
            }
            break;
        default:
            // Return a 404 response for unsupported HTTP methods
            echo "Method not available";
            http_response_code(404);
        break;
    }

?>