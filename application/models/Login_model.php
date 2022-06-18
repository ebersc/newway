<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->table = 'login';
    }

    public function login($user, $passwd){
        $resul = $this->db->select('*')
                    ->from($this->table)
                    ->where(array('email' => $user, 'senha' => $passwd))
                    ->get();

        if($resul->num_rows() > 0){
            $arrResp = $resul->result_array()[0];
            $arrResp['login'] = true;
            return $arrResp;
        }else{
            $arrResp['login'] = false;
            return $arrResp;
        }
    }
}