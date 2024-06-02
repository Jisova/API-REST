<?php

namespace App\Controllers;
use App\Models\Home_model; // Just guessing here


class Home extends BaseController
{
    protected $home_model; 
    public function __construct()
    {
       
		
		// $this->home_model = new Home_model();
		

    }

    public function index()
    {
        // return view('welcome_message');
    }

    public function sonsulta( ){

        $this->db = \Config\Database::connect();
        $query=$this->db->query("SELECT clienteid, cedula_ruc, nombrecia, nombrecontacto, direccioncli, fax, email, celular, fijo
        FROM public.clientes;");

        $test=($query->getResult());
        return $this->response->setJSON($test);

    }
    public function eliminar($productoid){

        $this->db = \Config\Database::connect();
        $query=$this->db->query("DELETE FROM public.categorias where productoid like = '$productoid';");
        echo 'ok';

    }
    public function insertar($clienteid, $cedula_ruc, $nombrecia, $nombrecontacto, $direccioncli,
    $fax, $email, $celular, $fijo ){

        $this->db = \Config\Database::connect();
        $query=$this->db->query(" INSERT INTO public.clientes VALUES ( '$clienteid', '$cedula_ruc',' $nombrecia',
        '$nombrecontacto', '$direccioncli','$fax', '$email', '$celular', '$fijo'); ");
        echo 'ok';
        
    }

    public function actualizar(){

        $this->db = \Config\Database::connect();
        $query=$this->db->query("UPDATE public.categorias SET  nombrecat = 'PLASTICOS'
        WHERE categoriaid = 100");
        echo 'ok';
       

    }


}
