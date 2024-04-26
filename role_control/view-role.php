<?php
require_once('../db_connect.php');
$role_id = $_GET['role_id'];

$conn = new Database();
$features_list = $conn->query("SELECT * FROM chucnang");
$sql = "SELECT chucnangId, action FROM role_chucnang WHERE roleId = $role_id";
$role_features_actions = $conn->query($sql);

// Convert the result to an associative array
$role_features_actions_assoc = [];
while ($row = $role_features_actions->fetch_assoc()) {
  $role_features_actions_assoc[$row['chucnangId']][] = $row['action'];
}
$conn->close();

ob_start();

if ($features_list->num_rows > 0) {
  while ($feature = $features_list->fetch_assoc()) {
    echo '
            <tr>
              <td>' . $feature['name'] . '</td>
              <td class="role-view-containter">
              <input class="role-view"  type="checkbox" id="feature' . $feature['id'] . 'c" name="features[' . $feature['id'] . '][]" value="create"' . (isset($role_features_actions_assoc[$feature['id']]) && in_array('create', $role_features_actions_assoc[$feature['id']]) ? ' checked' : '') . '> 
              <span class="checkmark"></span>
              </td>      
              <td class="role-view-containter">
              <input class="role-view"  type="checkbox" id="feature' . $feature['id'] . 'u" name="features[' . $feature['id'] . '][]" value="update"' . (isset($role_features_actions_assoc[$feature['id']]) && in_array('update', $role_features_actions_assoc[$feature['id']]) ? ' checked' : '') . '> 
              <span class="checkmark"></span>
              </td>
              <td class="role-view-containter">
              <input class="role-view"  type="checkbox" id="feature' . $feature['id'] . 'd" name="features[' . $feature['id'] . '][]" value="delete"' . (isset($role_features_actions_assoc[$feature['id']]) && in_array('delete', $role_features_actions_assoc[$feature['id']]) ? ' checked' : '') . '> 
              <span class="checkmark"></span>
              </td>
              <td class="role-view-containter">
              <input class="role-view"  type="checkbox" id="feature' . $feature['id'] . 'r" name="features[' . $feature['id'] . '][]" value="read"' . (isset($role_features_actions_assoc[$feature['id']]) && in_array('read', $role_features_actions_assoc[$feature['id']]) ? ' checked' : '') . '> 
              <span class="checkmark"></span>
              </td>
            </tr>';
  }
}

$html = ob_get_clean();

echo json_encode($html);
