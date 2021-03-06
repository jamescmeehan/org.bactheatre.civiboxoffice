<?php

if (!defined('ft_check')) {die('System intrusion ');}

class OrderStatus{

  /* Params should be auto geneated when calling from db */
  public $id;
  public $order_id;
  public $updated;
  public $status_from;
  public $status_to;
  public $updated_by;


  public function statusChange($orderId, $newStatus=false, $updatedBy=NULL, $action=false, $description=false,$data=''){

    if(is_numeric($orderId)){
      $sql = "SELECT os_status_to
            FROM order_status
            WHERE os_order_id = "._esc($orderId)."
            ORDER BY os_changed DESC, os_id DESC
            LIMIT 0,1";
      $query = ShopDB::query_one_row($sql);

      if(is_null($query)){
        $oldStatus = "NULL";
      }else{
        $oldStatus = _esc($query['os_status_to']);
      }
      //Check for action
      if(empty($action)){
        $action='NULL';
      }else{
        $action=_esc($action);
      }
      //Check if passed desc
      if(empty($description)){
        $description='NULL';
      }else{
        $description=_esc($description);
      }
      //Check for passed newStatus
      if(empty($newStatus)){
        $newStatus=$query['os_status_to'];
      }
      if(is_object($data)|| is_array($data)){
        $data = _esc(serialize($data));
      }else{
        $data = _esc($data);
      }


      $sql = "INSERT INTO order_status (`os_order_id`, `os_changed`, `os_status_from`, `os_status_to`, `os_changed_by`, `os_action`, `os_description`, `os_data`)
              VALUES ( "._esc($orderId).", CURRENT_TIMESTAMP, ".$oldStatus.", "._esc($newStatus).", null, ".$action.", ".$description.", ".$data." )";
      if(!$res=ShopDB::query($sql) || ShopDB::num_rows($res)<>1){
      //  ShopDB::rollback("Failed to insert status row.");
        return false;
      }
      return true;
    }else{
      ShopDB::rollback("Failed to update status");
      return false;
    }
  }

  public function massStatusChange($orderFields,$newStatus=false,$updatedBy=NULL,$action=false,$description=false){

    if(empty($orderFields)){
      ShopDB::rollback("Failed to pass massStatusChange fields");
      return false;
    }

    if(!is_array($orderFields)){
      ShopDB::rollback("Failed to pass massStatusChange fields 2");
      return false;
    }
    $where = "";
    foreach($orderFields as $field=>$value){
      $where .= " $field = "._esc($value)." \n";
    }

    $query="SELECT DISTINCT order_id
            FROM `Order`
            WHERE 1=1
            $where";
    $res = ShopDB::query($query);

    if(ShopDB::num_rows($res)<0){
      ShopDB::rollback("Failed massStatusChange 3");
      return false;
    }

    while($row = ShopDB::fetch_assoc($res)){
      if(!OrderStatus::statusChange($row['order_id'],$newStatus,$updatedBy,$action,$description)){
        return false;
      }
    }

    return true;
  }

}
?>