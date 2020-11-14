<?php
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

// **** TO DO : sanitize $_POST ****

function db_connect() {
    // SET database user connection here
    $mysqli = new mysqli("localhost","root","root","test");
    if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
    }
    return $mysqli;
}

function insert_user($name="",$age="") {
    $conn = db_connect();
    $missingInput = false;
    if ($name==="") {echo "<br />Missing Name!"; $missingInput=true;}
    if ($age==="") {echo "<br />Missing Age!"; $missingInput=true;}
    if ($missingInput) {return;}
    $sql="INSERT INTO users (name,age) VALUES('" . $name . "','" . $age . "');";
    $conn->query($sql);
    $conn->close();
}

function get_users() {
    /* array output sample data:
    $users = [
        ['name'=>'Joe','age'=>'47'],
        ['name'=>'John','age'=>'32']
    ];
    */
    $users = [];
    $filter = "%o%";
    $conn = db_connect();
    $sql="SELECT * from users WHERE name LIKE '" . $filter . "' ORDER BY name ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = ['name' => $row['name'], 'age' => intval($row['age'])];  
        }
      }
    return $users;
}

function get_users_prepared_statement() {
    /* array output sample data:
    $users = [
        ['name'=>'Joe','age'=>'47'],
        ['name'=>'John','age'=>'32']
    ];
    */
    $users = [];
    
    $conn = db_connect();

    // set filter parameter to bind
    $filter = "%%";

    // set up sql template
    $sql="SELECT * from users WHERE name LIKE ? ORDER BY name ASC";
    // Multiple bind_param example --
    /*
        $sql = "INSERT INTO users(name,age,type,data_added) VALUES (?, ?, ?, ?);"
        $stmt = $conn->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param("siss", $name, $age, $type, $date_added);
        $stmt->execute();
    */

    // create prepared statment
    $stmt = $conn->stmt_init();

    // prepare bind and execute the prepared statement
    if (!$stmt->prepare($sql)) { echo "Prepare failed"; return; }
    if (!$stmt->bind_param("s",$filter)) { echo "Bind failed"; return; }
    if (!$stmt->execute()) { echo "Execute failed : " . $stmt->error; return; }

    // get result of statement add to array
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = ['name' => $row['name'], 'age' => intval($row['age'])];  
        }
    }
    $stmt->close();    
    return $users;
}

// ADD USERS
if ($_POST['users-table']==="add") {
    insert_user(
        $_POST['user-name'],
        $_POST['user-age']
    );
}

// GET USERS
$prepared_users = get_users_prepared_statement();

?>

<form name="adduser" action="" method="POST">
<input name="user-name" type="text" />
<input name="user-age" type="text" />
<input type="hidden" name="users-table" value="add" />
<input type="submit" value="Add New User" />
</form>

<br />

<div style="display:flex; flex-wrap:wrap; ">

    <?php foreach ($prepared_users as $user) {
        echo '<div style="flex:1;background:#e1e1e1;padding:15px 30px; border-radius:5px; min-width:150px; margin:5px;">';
        echo "Name: " . $user['name'];
        echo "<br />";
        echo "Age: " . $user['age'];
        echo '</div>';
    } 
    ?>
    
</div>
