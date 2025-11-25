<?php defined('BASEPATH') or exit('No direct script access allowed');

/* 
fungsi M_Web

- Berkaitan dengan database yang terhubung dengan project yg dibuat
- Biasanya digunakan untuk manipulasi data atau CRUD
*/

class M_Web extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

// class M_Web extends CI_Model
// {
//   protected $my_sql;
//   function __construct()
//   {
//     parent::__construct();
//     $this->my_sql = $this->load->database('my_sql', true);
//   }

  public function save($data)
  {
    // $id = $this->db->insert_id(); ----> ga dipake lagi karna syntaxnya udah ga valid
    $this->db->insert('arduino.arduino_gps_device_information', $data);

    if ($this->db->affected_rows()) {
      return [
        'message' => 'success insert data'
      ];
    } else {
      return [
        'message' => 'failed insert data'
      ];
    }
  }

  // function untuk monitoring di web-> dipanggil di views/V_index.php
  public function monitoring()
  {
    $data = $this->db->order_by('id', 'desc')
      ->limit(100)
      ->get('arduino.arduino_gps_device_information')->result_array();
    return $data;
  }
  
  public function getAllData()
  {
    $data = $this->db->order_by('id', 'desc')
       ->limit(100)
       ->get('arduino.arduino_gps_device_information')->result_array();
     return $data;
  }

  public function getFirstData()
  {
      // ini kita kasih id dan asc agar short by id dan urutkan dari atas(asc)
      $this->db->order_by('id', 'ASC');
      $query = $this->db->get('arduino.arduino_gps_device_information', 1);
      return $query->row_array();
  }

  public function getLastData()
  {
      // ini kita kasih id dan asc agar short by id dan urutkan dari atas(decs)
      $this->db->order_by('id', 'DESC');
      $query = $this->db->get('arduino.arduino_gps_device_information', 1);
      return $query->row_array();
  }

  public function getById($id)
  {
    // disini kita bikin get_where dan kita arahin ke table-> field id
    return $this->db->get_where('arduino.arduino_gps_device_information', ['id' => $id])->row_array();
  }

  public function update($id, $data)
  {
    //update by id, jadi update nya berdasarkan device tapi ada juga ada yg berdasarkan id
    $this->db -> where ('id', $data['id'])
      ->update('arduino.arduino_gps_device_information', $data);

    if ($this->db->affected_rows()) {
      return [
        'id' => 'true',
        'message' => 'success update data',
        'data' => $data
      ];
    } else {
      return [
        'id' => 'false',
        'message' => 'failed update data',
        'data' => $data
      ];
    }
  }
}
