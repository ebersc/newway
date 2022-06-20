<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->table = 'login';

        $this->load->model('Token_model');
    }

    public function login($user, $passwd){
        $resul = $this->db->select('*')
                    ->from($this->table)
                    ->where(array('email' => $user, 'senha' => md5($passwd)))
                    ->get();

        if($resul->num_rows() > 0){
            // $arrResp = $resul->result_array()[0];
            $this->session->user_email = $resul->result_array()[0]['emails'];
            $this->session->user_id = $resul->result_array()[0]['id'];
            $arrResp['login'] = true;

            $token = $this->busca_token_ativo();

            if(empty($token)){
                $token = $this->generate_token($this->session->user_email);
            }

            $arrResp['token'] = $token;
            return $arrResp;
        }else{
            $arrResp['login'] = false;
            return $arrResp;
        }
    }

    private function busca_token_ativo(){
        try{
            $id_user = $this->session->user_id;
            $resul = $this->Token_model->busca_token_ativo(['id' => $id_user]);

            return $resul;
        }catch(Exception $e){
            throw $e;
        }
    }

    private function generate_token($user) {
        try{
            $key = '';
            $keys = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        
            for ($i = 0; $i < 250; $i++) {
                $key .= $keys[array_rand($keys)];
            }

            $token = md5($key . "-" . $user);

            $data_expiracao = date('Y-m-d H:i:s', strtotime('+30 minutes', date('Y-m-d H:i:s')));

            $this->Token_model->insere_token([
                'id_usuario' => $this->session->user_id,
                'token' => $token,
                'data_expiracao' => $data_expiracao
            ]);

            return $token;
        }catch(Exception $e){
            throw $e;
        }
    
    }
}