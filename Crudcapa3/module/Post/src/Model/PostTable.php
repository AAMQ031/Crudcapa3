<?php
    namespace Post\Model;
    use RuntimeException;
    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\TableGateway\TableGateway;
    use Zend\Db\Adapter\Adapter;
    use Zend\Db\Sql\Sql;
    use Zend\Db\Sql\Select;
    use Zend\Db\ResultSet\ResultSet;
    use Zend\Db\TableGateway\Feature;
    use Post\Controler\indexController;
    

    
        class PostTable extends TableGateway
    {
        private  $dbAdapter;
    
        public function __construct()
        {
            $this->dbAdapter = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
            $this->table = 'post';
            $this->featureSet = new Feature\FeatureSet();
            $this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
            $this->initialize();
        }
    
    
        public function fetchAll()
        {
            $select = $this->select();
        $posts = $select->toArray();
        //imprime un array
        //print_r($users);
        return $posts;


        }
        public function  addAction($data){
        //inserta el array desde el service
        $this->insert($data);
        return $data;
    }
       public function editAction($data){
        // con esta linea mandamos el update
        $post = $this->update($data, array("id"=>$data['id']));
        
         return $post;
    }
  
  

public function getUserById($id){

        //$sql = new Sql($this->dbAdapter);
        //consula
        //$select = $sql->select();
        //columnas
        //$select->columns(array('id_users','name','lastname','email'))
        //->from('users')
        //->where(array('id_users'=>$id_user));

        //$selectString = $sql ->getSqlStringForSqlObject($select);
        //ejecuta la consulta
        //$execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        //Se pasa a array
        //$result = $execute->toArray();

        //echo "<pre>"; print_r($result); exit;
        //return $result[0];
        $sql = new Sql($this->dbAdapter);
        $select = $this->dbAdapter->query("select * from post where id=$id",Adapter::QUERY_MODE_EXECUTE);
        $result = $select->toArray();
        //imprime echo "<pre>"; print_r($result); exit;
        return $result[0];
}
    
       public function saveData($post){
            $data = [
                'nombre' => $post->getNombre(),
                'raza'  => $post->getRaza(),
                'sexo'  => $post->getSexo(),
                'caracteristicas'  => $post->getCaracteristicas(),
            ];

            if($post->getId()){
                $this->tableGateway->update($data, ['id' => $post->getId()]);
            
            }   
            else{
                $this->tableGateway->insert($data);
            }   
                
        }

         public function deleteAction($id){
           $delete=$this->delete(array("id"=>$id));
             return $delete;
        }
        
    }
?>