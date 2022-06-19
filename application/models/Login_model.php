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
                    ->where(array('email' => $user, 'senha' => md5($passwd)))
                    ->get();

        if($resul->num_rows() > 0){
            $arrResp = $resul->result_array()[0];
            $arrResp['login'] = true;
            $arrResp['token'] = $this->generate_token($user);
            return $arrResp;
        }else{
            $arrResp['login'] = false;
            $arrResp['md5'] = md5("123456");
            return $arrResp;
        }
    }

    private function verifica_token_ativo(){
        try{
            
        }catch(Exception $e){
            throw $e;
        }
    }

    private function generate_token($user) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < 150; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return md5($key . "-" . $user);
    }
}