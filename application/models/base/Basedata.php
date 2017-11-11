<?php 

/* 
 * Author: chandra.
 * date created : 2016-08-17
 * class API models.
 */

class Basedata extends CI_Model {
    function __construct(){
	parent::__construct();
    }
    public function getNasabah($id){
        if($id!="all"){
            $where = "WHERE nasabah_id='$id'";
        }else{
            $where = "";
        }
        $query=$this->db->query("SELECT * FROM nasabah $where");
        return $query->result();
    }
    public function setNasabah($post){
        $cek=$this->getNasabah($post['idRec']);
        $data = array(
            'nasabah_name'=>$post['nasabah_name'],
            'phone'=>$post['phone'],
            'alamat'=>$post['alamat'],
            'email'=>$post['email'],
            'user_id'=>$post['user_id']
        );
        if(sizeof($cek)==0){
            $this->db->insert('nasabah',$data);
        }else{
            $this->db->where('id', $post['idRec']);
            $this->db->update('nasabah', $data);
        }
        return 1;
    }
    public function delNasabah($id){
        $this->db->query("DELETE FROM nasabah WHERE nasabah_id='$id'");
        return 1;
    }
    public function getDebtM($id){
        $query=$this->db->query("SELECT SUM(amount) AS total FROM pinjaman
        WHERE nasabah_id='$id'
        AND status='1'");
        return $query->result();
    }
    
}
