<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model(array('base/basedata'));
        $this->config->load('config', true);
        $this->server = $this->config->item('server_url');
    }
    public function nasabah(){
        $id='all';
        $data=$this->basedata->getNasabah($id);
        if(sizeof($data)>0){
            //$dataArray=array();
            foreach($data as $d){
                $dataArray[]=array(
                    'nasabah_id'=>$d->nasabah_id,
                    'nasabah_name'=>$d->nasabah_name,
                    'phone'=>$d->phone,
                    'alamat'=>$d->alamat,
                    'email'=>$d->email,
                    'utang'=>$this->getDebt($d->nasabah_id),                    
                    'user_id'=>$d->user_id
                    );
            }
            echo $this->success($dataArray);
        }else{
            echo $this->failure();
        }
    }
    public function getDebt($id){
        $data=$this->basedata->getDebtM($id);
        if($data[0]->total == null){
            return "0";
        }else{
            return $data[0]->total;
        }
    }
    public function setnasabah(){
        $post=$this->input->post();
        $data=$this->basedata->setNasabah($post);
        if($data==1){
            echo $this->success($data);
        }else{
            echo $this->failure();
        }
    }
    public function delnasabah(){
        $data=$this->basedata->delNasabah();
        if($data==1){
            echo $this->success($data);
        }else{
            echo $this->failure();
        }
    }
    public function success($data){
        $result = array('result'=>'success','data'=>$data);
        return json_encode($result);
    }
    public function failure(){
        $result = array('result'=>'failure','data'=>'empty');
        return json_encode($result);
    }
}    