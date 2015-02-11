<?
/********************************************************************
(-/\-)
Create by :: Nattapong Pradabsook, Surin, Thailand  
Date  :: 29/08/2010
Good luck :']   
********************************************************************/
 
 
class J_SQL
{
 
 var $db_host;
 var $db_user;
 var $db_pass;
 var $db_name;
 var $db_connect;
 
  
 function J_SQL()
 {
  $this->db_host = _host;
  $this->db_user = _db_user;
  $this->db_pass = _db_pass;
  $this->db_name = _db_name;
 }
 
 //ฟังก์ชั่นติดต่อฐานข้อมูล
 function J_ConnectDB()
 {
  $this->db_connect  = @mysql_connect($this->db_host,$this->db_user,$this->db_pass) or die(mysql_error());  
 }
  
 //ฟังก์ชั่นเลือกฐานข้อมูล
 function J_SelectDB()
 {
  @mysql_select_db($this->db_name) or die(mysql_error());
 }
 
 //ฟังก์ชั่นที่ทำให้ MySQL แสดงอักขระเป็น tis620
 function set_char_tis620()
 {
  $cs1 = "SET character_set_results=tis620"; 
  $cs2 = "SET character_set_client = tis620"; 
  $cs3 = "SET character_set_connection = tis620"; 
  @mysql_query($cs1) or die('Error query: ' . mysql_error()); 
  @mysql_query($cs2) or die('Error query: ' . mysql_error()); 
  @mysql_query($cs3) or die('Error query: ' . mysql_error()); 
 }
 
 //ฟังก์ชั่นที่ทำให้ MySQL แสดงอักขระเป็น utf8
 function set_char_utf8()
 {
  $cs1 = "SET character_set_results=utf8"; 
  $cs2 = "SET character_set_client = utf8"; 
  $cs3 = "SET character_set_connection = utf8"; 
  @mysql_query($cs1) or die('Error query: ' . mysql_error()); 
  @mysql_query($cs2) or die('Error query: ' . mysql_error()); 
  @mysql_query($cs3) or die('Error query: ' . mysql_error()); 
 }
   
 //ฟังก์ชั่นเรียกดูข้อมูลในฐานข้อมูล  คืนค่าเป็น อะเรย์
 function J_Select($fieldNames,$tableName)
 {
   $sql = "SELECT ".$fieldNames." FROM ".$tableName;
  $rs = @mysql_query($sql) or die(mysql_error());
  while($row = @mysql_fetch_array($rs))
  {
   $array[] = $row;
  }
  return $array;
 }
 
 //ฟังก์ชั่นเพิ่มข้อมูลลงในฐานข้อมูล
 function J_Insert($fieldsAndValues,$tableName)
 {
  $sql = "INSERT INTO ".$tableName;
  $f = "(";
  $val = " VALUES(";
  for($i < 0 ; $i < count($fieldsAndValues);$i++)
  {
   $f .= key($fieldsAndValues);
   if($i != (count($fieldsAndValues)-1))
    $f .= ",";
   $val .= "'".$fieldsAndValues[key($fieldsAndValues)]."'";
   if($i != (count($fieldsAndValues) - 1))
    $val .= ",";
   next($fieldsAndValues);
  }
  $f .= ")";
  $val .= ")";
  $sql .= $f.$val;
  @mysql_query($sql) or die(mysql_error());  
 }
  
 //ฟังก็ชั่นปรับปรุงข้อมูลในฐานข้อมูล
 function J_Update($fieldsAndValues,$key,$tableName)
 {
  $sql = "UPDATE ".$tableName." SET "; 
  $w  = "";
  for($i < 0 ; $i < count($fieldsAndValues);$i++)
  {
   $sql .= key($fieldsAndValues)." = '".$fieldsAndValues[key($fieldsAndValues)]."'";
   if($i != (count($fieldsAndValues)-1))
    $sql .= ", ";
    
   if($i == $key[$i])
   {
    $w .= key($fieldsAndValues)." = '".$fieldsAndValues[key($fieldsAndValues)]."'";
    if($i != (count($key)-1))
     $w .= " AND ";
   }   
   next($fieldsAndValues);
  }
  $sql .= " WHERE ".$w;
  @mysql_query($sql) or die(mysql_error());
 }
 
 //ฟังก์ชั่นทำคำสั่ง sql โดยไม่มีการแสดงผลเช่น INSERT, DELETE, UPDATE
 function J_ExecuteNonQuery($sql)
 {
  @mysql_query($sql) or die(mysql_error());
 }
 
 //ฟังก์ชั่นทำคำสั่ง sql คืนค่าเป็น อะเรย์
 function J_Execute($sql)
 {
  $rs = @mysql_query($sql) or die(mysql_error());
  while($row = @mysql_fetch_array($rs))
  {
   $array[] = $row;
  }
  return $array;
 }
 
 //ฟังก์ชั่นปิดการเชื่อมต่อฐานข้อมูล
 function J_Close()
 {
  @mysql_close($this->db_connect);
 }
 
}
 
?>