<?php

require_once("model/PostDB.php");
require_once("ViewHelper.php");

class PostController {

    public static function index() {
        if (isset($_GET["id"])) {
            ViewHelper::render("view/post-detail.php", ["post" => PostDB::get($_GET["id"])]);
        } else {
            ViewHelper::redirect(BASE_URL . "forum");
        }
    }

    public static function search() {
        if (isset($_GET["query"])) {
            $query = $_GET["query"];
            $hits = BookDB::search($query);
        } else {
            $query = "";
            $hits = [];
        }

        ViewHelper::render("view/book-search.php", ["hits" => $hits, "query" => $query]);
    }

    // Function can be called without providing arguments. In such case,
    // $data and $errors paramateres are initialized as empty arrays
    public static function showAddForm($data = [], $errors = []) {
        // If $data is an empty array, let's set some default values
        /* if (empty($data)) {
            $data = [
                "author" => "",
                "title" => "",
                "description" => "",
                "price" => 0,
                "year" => date("Y"),
                "quantity" => 10
            ];
        }

        // If $errors array is empty, let's make it contain the same keys as
        // $data array, but with empty values
        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }

        $vars = ["book" => $data, "errors" => $errors]; */
        ViewHelper::render("view/create-post-form.php");
    }

    public static function insert() {
        /* $rules = [
            "author" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[ a-zA-ZšđčćžŠĐČĆŽ\.\-]+$/"]
            ],
            // we convert HTML special characters
            "title" => FILTER_SANITIZE_SPECIAL_CHARS,
            "description" => FILTER_SANITIZE_SPECIAL_CHARS,
            "year" => [
                // The year can only be between 1500 and 2020
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1500, "max_range" => 2020]
            ],
            "price" => [
                // We provide a custom function that verifies the data. 
                // If the data is not OK, we return false, otherwise we return the data
                "filter" => FILTER_CALLBACK,
                "options" => function ($value) { return (is_numeric($value) && $value >= 0) ? floatval($value) : false; }
            ],
            "quantity" => [
                // The minimum quantity should be at least 10
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 10]
            ]
        ];
        // Apply filter to all POST variables; from here onwards we never
        // access $_POST directly, but use the $data array
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["author"] = $data["author"] === false ? "Provide the name of the author: only letters, dots, dashes and spaces are allowed." : "";
        $errors["title"] = empty($data["title"]) ? "Provide the book title." : "";
        $errors["year"] = $data["year"] === false ? "Year should be between 1500 and 2020." : "";
        $errors["price"] = $data["price"] === false ? "Price should be non-negative." : "";
        $errors["quantity"] = $data["quantity"] === false ? "Quantity should be at least 10." : "";

        // Is there an error?
        $isDataValid = true;

 */
        $errors = [];
        $data = $_POST;
        $isDataValid = true;

        

        if (strlen(basename($_FILES["imgf"]["name"]))>0){
            $data["image"] = basename($_FILES["imgf"]["name"]);
            $target_file = IMAGES_URL.$data["image"];

            if (file_exists($target_file)){
                $data["image"] = $data["image"]."1";
            }

            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $errors["image"] = "Sorry, only JPG, JPEG, PNG & GIF files are supported.";
            }
        }

        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            if (strlen(basename($_FILES["imgf"]["name"]))>0){

                if(! is_writable(IMAGES_URL)){
                    ViewHelper::redirect("nay123");
                    return;
                }
                
                $target_file = IMAGES_URL.basename($_FILES["imgf"]["name"]);
                if(move_uploaded_file($_FILES["imgf"]["tmp_name"], $target_file)){
                    ViewHelper::redirect("yay");
                    return;
                    $errors["test"] =$_FILES["imgf"]["error"];
                    self::showAddForm($data, $errors);
                }
                else{
                    ViewHelper::redirect("nay");
                    return;
                }
            }

            PostDB::insert($data["title"], $data["text"], $data["image"], 
                $data["uid"], $data["tid"]);
            ViewHelper::redirect(BASE_URL . "forum");
        } else {
            self::showAddForm($data, $errors);
        }
    }

    public static function showEditForm($data = [], $errors = []) {
        if (empty($data)) {
            $data = BookDB::get($_GET["id"]);
        }

        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }
        
        ViewHelper::render("view/book-edit.php", ["book" => $data, "errors" => $errors]);
    }    

    public static function edit() {
        $rules = [
            "author" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[ a-zA-ZšđčćžŠĐČĆŽ\.\-]+$/"]
            ],
            // we convert HTML special characters
            "title" => FILTER_SANITIZE_SPECIAL_CHARS,
            "description" => FILTER_SANITIZE_SPECIAL_CHARS,
            "year" => [
                // The year can only be between 1500 and 2020
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1500, "max_range" => 2020]
            ],
            "price" => [
                // We provide a custom function that verifies the data. 
                // If the data is not OK, we return false, otherwise we return the data
                "filter" => FILTER_CALLBACK,
                "options" => function ($value) { return (is_numeric($value) && $value >= 0) ? floatval($value) : false; }
            ],
            "quantity" => [
                // The minimum quantity should be at least 10
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 0]
            ],
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 0]
            ]
        ];
        // Apply filter to all POST variables; from here onwards we never
        // access $_POST directly, but use the $data array
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["author"] = $data["author"] === false ? "Provide the name of the author: only letters, dots, dashes and spaces are allowed." : "";
        $errors["title"] = empty($data["title"]) ? "Provide the book title." : "";
        $errors["year"] = $data["year"] === false ? "Year should be between 1500 and 2020." : "";
        $errors["price"] = $data["price"] === false ? "Price should be non-negative." : "";
        $errors["quantity"] = $data["quantity"] === false ? "Quantity should be at least 0." : "";
        $errors["id"] = $data["id"] === false ? "Id should be a positive number" : "";

        $isDataValid = true;
        // Is there an error?
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }
        // TODO: Implement server-side validation, similar to the one for adding books

        if ($isDataValid) {
            BookDB::update($data["id"], $data["author"], $data["title"], $data["description"], 
                $data["price"], $data["year"], $data["quantity"]);
            ViewHelper::redirect(BASE_URL . "book?id=" . $data["id"]);
        } else {
            self::showEditForm($data, $errors);
        }
    }

    public static function delete() {
        $rules = [
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ],
            "delete_confirmation" => [
                "filter" => FILTER_VALIDATE_BOOLEAN
            ]
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["id"] = $data["id"] === null ? "Cannot delete without a valid ID." : "";
        $errors["delete_confirmation"] = $data["delete_confirmation"] === null ? "Forgot to check the delete box?" : "";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            BookDB::delete($data["id"]);
            $url = BASE_URL . "book";
        } else {
            if ($data["id"] !== null) {
                $url = BASE_URL . "book/edit?id=" . $data["id"];
            } else {
                $url = BASE_URL . "book";
            }
        }

        ViewHelper::redirect($url);
    }

    public static function searchApi() {
        if (isset($_GET["query"])) {
            $hits = PostDB::search($_GET["query"]);
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }
}