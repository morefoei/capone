<?php
include 'koneksi.php';

header('Content-Type: application/json');

$type = isset($_GET['type']) ? (int)$_GET['type'] : 10;
$q = isset($_GET['q']) ? $_GET['q'] : '';

$table = ($type === 9) ? 'icd9' : 'icd10';

$results = [];

    $searchTerm = mysqli_real_escape_string($koneksi, '%' . $q . '%');
    
    $query = "SELECT code, display FROM $table WHERE code LIKE '$searchTerm' OR display LIKE '$searchTerm' LIMIT 100";
    $res = mysqli_query($koneksi, $query);
    
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $results[] = [
                'id' => $row['code'],
                'text' => $row['code'] . ' - ' . $row['display'],
                'code' => $row['code'],
                'name' => $row['display']
            ];
        }
    }

echo json_encode($results);
