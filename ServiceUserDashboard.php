<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);


// Generate the query section
echo("
  <form method=\"post\" action=\"user.php?sessionid=$sessionid\">
  Number: <input type=\"text\" size=\"8\" maxlength=\"8\" name=\"q_id\"> 
  Firstname: <input type=\"text\" size=\"20\" maxlength=\"30\" name=\"q_fname\"> 
  Lastname: <input type=\"text\" size=\"20\" maxlength=\"30\" name=\"q_lname\"> 
  <BR />
  Student(y/n): <input type=\"text\" size=\"1\" maxlength=\"1\" name=\"q_student\"> 
  Admin <input type=\"text\" size=\"1\" maxlength=\"1\" name=\"q_admin\">   
  ");


oci_free_statement($cursor);

echo("
  </select>
  <input type=\"submit\" value=\"Search\">
  </form>

  <form method=\"post\" action=\"welcomepage.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>

  <form method=\"post\" action=\"emp_add.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Add A New Employee\">
  </form>
  ");

// Interpret the query requirements
$q_id = $_POST["q_eid"];
$q_fname = $_POST["q_fname"];
$q_lname = $_POST["q_lname"];
$q_student = $_POST["q_student"];
$q_admin = $_POST["q_admin"];




if (isset($q_id) and trim($q_id) != "") { 
  $whereClause .= " and id = $q_dnumber"; 
}

if (isset($q_fname) and $q_fname != "") { 
  $whereClause .= " and fname like '%$q_fname%'"; 
}

if (isset($q_lname) and $q_lname != "") { 
  $whereClause .= " and lname like '%$q_lname%'"; 
}

if (isset($q_student) and $q_student != "") { 
  $whereClause .= " and $q_student like '%$q_student%'"; 
}
if (isset($q_admin) and $q_admin != "") { 
  $whereClause .= " and $q_admin like '%$q_admin%'"; 
}



// Form the query statement and run it.
$sql = "select id, fname, lname, student, admin
  from univUser where $whereClause order by id";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

// Display the query results
echo "<table border=1>";
echo "<tr> <th>Id</th> <th>Firstname</th> <th>Lastname</th> <th>Student</th> <th>Admin</th> <th>Update</th> <th>Delete</th></tr>";

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor)){
  $id = $values[0];
  $fname = $values[1];
  $lname = $values[2];
  $student = $values[3];
  $admin = $values[4];
  
  echo("<tr>" . 
    "<td>$id</td> <td>$fname</td> <td>$lname</td> <td>$student</td> <td>$admin</td> ".
    " <td> <A HREF=\"user_update.php?sessionid=$sessionid&eid=$id\">Update</A> </td> ".
    " <td> <A HREF=\"user_delete.php?sessionid=$sessionid&eid=$id\">Delete</A> </td> ".
    "</tr>");
}
oci_free_statement($cursor);

echo "</table>";

?>
