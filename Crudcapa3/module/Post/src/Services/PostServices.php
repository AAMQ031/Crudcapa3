<?php
namespace Post\Services;
//incluir model
use Post\Model\Post;
use Post\Model\PostTable;


class PostServices
{
	private $postTable;

	public function   __construct(){
		$this->postTable = new PostTable();
	}
	
	// manda la variable al modelo para que se realice la consulta
	public function fetchAll(){
		$posts=$this->postTable->fetchAll();
		return $posts;
	}
	//funcion que va a agregar los datos en el parametro se indica lo que se va a recibir
	public function addAction($formData){

		//se genera un array asosiativo
		$data = array(
			//campos de la base
			"nombre" => $formData['nombre'],
			"raza" => $formData['raza'],
			"sexo" => $formData['sexo'],
			"caracteristicas" => $formData['caracteristicas']
			);
		// print_r($data); exit();
		 $post= $this->postTable->addAction($data);

		//$post = $this->addAction($data, array("id"=>$data['id']));
        return $post;
	}

public function getUserById($id){
		
		$post = $this->postTable->getUserById($id);
		return $post;
	}

	 public function getPost($id)
        {
            $id = (int) $id;
            $rowset = $this->postTable->select(['id' => $id]);
            $row = $rowset->current();
            if (! $row) {
                throw new RuntimeException(sprintf(
                    'Could not find row with identifier %d',
                    $id
                ));
            }
    
            return $row;
        }

	public function editAction($formData){
		// enviar solo los parametros que queremos modificar
		$data = array(
			"id" => $formData['id'],
			"nombre" => $formData['nombre'],
			"raza" => $formData['raza'],
			"sexo" => $formData['sexo'],
			"caracteristicas" => $formData['caracteristicas']

			);
		//llamada al modelo
		$post = $this->postTable->editAction($data);
		return $post;

	}
	   	public function deleteAction($id){
		$post = $this->postTable->deleteAction($id);
		return $post;

	}

}