<?php

//deleta Registros
function DBDelete($table, $where = null)
{
    $table = DB_PREFIX. '_' . $table;
    $where = ($where) ? " WHERE {$where}" : null;
    
    $query = "DELETE FROM {$table}{$where}";
    
    return DBExecute($query);
}

//Altera Registros
function DBUpDate($table, array $data, $where = null, $insertID = false)
{
    foreach ($data as $key => $value)
    {
        $fields[] = "{$key} = '{$value}'";
    }
    
    $fields = implode(', ', $fields);
    
    $table = DB_PREFIX. '_' . $table;
    $where = ($where) ? " WHERE {$where}" : null;
    
    $query = "UPDATE {$table} SET {$fields}{$where}";
    
    return DBExecute($query, $insertID);
}

//ler Registros
function DBread($table, $params = null, $fields = '*')
{
    $table = DB_PREFIX. '_' . $table;
    $params =($params)? " {$params}" : null;
    
    $query = "SELECT {$fields} FROM {$table}{$params}";
    $result = DBExecute($query);
    
    if(!mysqli_num_rows($result))
        return false;
    else
    {
        While($res = mysqli_fetch_assoc($result))
        {
            $data[] = $res;
        }
        
        return $data;
    }
}
//Grava Registros
function DBCreate($table, array $data, $insertID = false)
{
    $table = DB_PREFIX. '_' . $table;
    $data = DBEscape($data);
    
    $fields = implode(', ', array_keys($data));
    $values = "'". implode("', '", $data) . "'";
    
    $query = "INSERT INTO {$table} ({$fields} ) VALUES ({$values})";
    
    return DBExecute($query, $insertID);
}


//Executa Querys
function DBExecute($query, $insertID = false)
{
    $link = DBConnect();
    $result = @mysqli_query($link, $query) or die (mysqli_error($link));
    
    if($insertID)
        $result = mysqli_insert_id($link);
    
    DBClose($link);
    return $result;
}

function DBEscape($dados)
{
    $link = DBConnect();
    if(!is_array($dados))
    {
        $dados = mysqli_real_escape_string($link, $dados);
    }
    else
    {
        $arr = $dados;

        foreach ($arr as $key => $value)
        {
            $key = mysqli_real_escape_string($link, $key);
            $value = mysqli_real_escape_string($link, $value);

            $dados[$key] = $value;
        }
    }

    DBClose($link);
    return $dados;
}

// Abre conexão com o MySQL
function DBConnect()
{
    $link = @mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die (mysqli_error());
    mysqli_set_charset($link, DB_CHARSET) or die(mysqli_error($link));

    return $link;

}

//fecha conexão com MySQL
function DBClose($link)
{
    $link = @mysqli_close($link) or die(mysqli_erro($link));
}