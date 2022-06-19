<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
    public function __construct(){
       parent::__construct();
       $this->load->model('Login_model');
    }

    public function entrar(){
        try{
            $post = $this->input->post();

            if(isset($post['email']) && isset($post['senha'])){
                $resp = $this->Login_model->login($post['email'], $post['senha']);

                echo json_encode($resp);
            }else{
                echo json_encode(['status' => http_response_code(401), 'msg' => "Acesso não autorizado!"]);
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    public function sair(){
        try{

        }catch(Exception $e){
            throw $e;
        }
    }
}