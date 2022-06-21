<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Votar extends CI_Controller{
    public function __construct(){
        try{
            parent::__construct();

            $this->load->model("CadastrosFilmesSeries_model");
        }catch(Exception $e){
            throw $e;
        }
    }

    public function cadastrar_voto(){
        try{
            $id = $this->input->post('id_filme_serie');

            $this->CadastrosFilmesSeries_model->voto($id);

            echo json_encode(['status' => 200, 'msg' => 'Voto cadastrado com sucesso!']);
        }catch(Exception $e){
            echo json_encode(["status" => 500, "msg" => $e->getMessage()]);
        }
    }

    public function contabilizar_votos(){
        try{
            $post = $this->input->post();

            $orderby = isset($post['order']) ? $post['order'] : 'nome';
            $direction = isset($post['direction']) ? $post['direction'] : 'asc';

            $resp = $this->CadastrosFilmesSeries_model->contabilizar($orderby, $direction);

            echo json_encode($resp);
        }catch(Exception $e){
            echo json_encode(["status" => 500, "msg" => $e->getMessage()]);
        }
    }
}