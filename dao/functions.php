<?php
function get_rooms($conn){
    $sql = "select * from room";
    $stmt = sqlsrv_query($conn,$sql);
    if($stmt === false){
        die(print_r(sqlsrv_errors(),true));
    }
    $rooms = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
        $rooms[] = $row;
    }
    return $rooms;
}

function get_rooms_by_number($conn, $number){
    $sql = "select * from room WHERE room = '".$number."';";
    $stmt = sqlsrv_query($conn,$sql);
    if (!$stmt){
        echo "Error in statement execution.\n";
        die( print_r( sqlsrv_errors(), true));
    }
    return sqlsrv_fetch_object($stmt);
}

function registration ($conn,$login,$password){
    $sql = "INSERT INTO room (room, pass) VALUES ('".$login."','".$password."');";
    $stmt = sqlsrv_query($conn,$sql);
    if($stmt === false){
        die(print_r(sqlsrv_errors(),true));
    }
}

function set_hash_and_ip($hash,$user_ip, $room, $conn){
    $sql = "update room set hash = '".$hash."', user_ip='".$user_ip."'  WHERE room = '".$room."';";
    $stmt = sqlsrv_query($conn,$sql);
    if($stmt === false){
        die(print_r(sqlsrv_errors(),true));
    }
}

function get_balance($conn, $room_number){
    $sql = "SELECT balance.balance FROM Balance,room WHERE room.room = '".$room_number."' AND room.key_room = balance._room;";
    $stmt = sqlsrv_query($conn,$sql);
    if (!$stmt){
        echo "Error in statement execution.\n";
        die( print_r( sqlsrv_errors(), true));
    }
    return sqlsrv_fetch_object($stmt);
}

function get_connection_history($conn, $room_number){
    $sql = "SELECT history_conection._stat, history_conection.data_conrction FROM Balance,room,history_conection WHERE room.room = '".$room_number."' AND room.key_room = balance._room AND balance.key_balance = history_conection._balance;";
    $stmt = sqlsrv_query($conn,$sql);
    if($stmt === false){
        die(print_r(sqlsrv_errors(),true));
    }
    $connections = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
        $connections[] = $row;
    }
    return $connections;
}

function get_balance_history($conn, $room_number){
    $sql = "SELECT history_balanse._money, history_balanse.data_popolnenia FROM Balance,room,history_balanse WHERE room.room = '".$room_number."' AND room.key_room = balance._room AND balance.key_balance = history_balanse._balance;";
    $stmt = sqlsrv_query($conn,$sql);
    if($stmt === false){
        die(print_r(sqlsrv_errors(),true));
    }
    $connections = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
        $connections[] = $row;
    }
    return $connections;
}

function get_stat($conn, $room_number){
    $sql = "SELECT balance.stat FROM Balance,room WHERE room.room = '".$room_number."' AND room.key_room = balance._room;";
    $stmt = sqlsrv_query($conn,$sql);
    if (!$stmt){
        echo "Error in statement execution.\n";
        die( print_r( sqlsrv_errors(), true));
    }
    return sqlsrv_fetch_object($stmt);
}

function update_password($conn,$room_number,$new_pass){
    $sql = "UPDATE room SET pass='".$new_pass."' where room='".$room_number."';";
    $stmt = sqlsrv_query($conn,$sql);
    if($stmt === false){
        die(print_r(sqlsrv_errors(),true));
    }
}