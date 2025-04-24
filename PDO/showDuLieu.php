<?php
require_once 'connect.php';
echo '<link href="index.css" rel="stylesheet">';



try {

    $sql = "Select * from thanhVien";
    $stmt = $pdo->query($sql);          //query để trả về dữ liệu , k cần tham số truyền vào
    
    echo "    
    <table>
   <thead>
   <tr>
   <th>ID</th>
   <th>Account</th>
   <th>Password</th>
   <th>Level</th>

   </tr>
   </thead>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //fetch dùng để lấy 1 dòng dữ liệu trong kết quả truy vấn 
        //PDO::FETCH_ASSOC  giúp nó thành mảng kết hợp dễ truy vấn thông tin

        echo "<tbody>";
        echo "<tr>";
        echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["taiKhoan"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["matKhau"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["level"]) . '</td>';
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} catch (PDOException $a) {

    echo "Something Wrong !" . $a->getMessage();
}
