<?php

include_once "Livre.php";

class LivreManager {

    public $db;

    public function __construct(PDO $db){
        $this->db = $db; 
    }

    public function selectAll (){
        $sql = "SELECT * FROM livre";
        $stmt = $this->db->prepare ($sql);
        $stmt->execute();
        $arrLivres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // on renvoi un array de livres
        // var_dump ($stmt->errorInfo());
        // die();
      

        $arrObjetsLivres = [];
        // $unLivreArray est un livre sous la forme d'un array
        // $arrLivres est un array qui contient de Livres sous la forme d'array
        // $arrObjetsLivres est un array qui contient de Livres sous la forme d'objets
        foreach ($arrLivres as $unLivreArray){
            $objectLivre = new Livre ($unLivreArray);
            $arrObjetsLivres[] = $objectLivre;
            // var_dump ($objectLivre);
            // var_dump ($unLivreArray);

        }
        // return $arrLivres; // on ne veut plus un array d'arrays!
 
        return $arrObjetsLivres;
    }

    // select avec de filtres
    public function selectFiltres ($arrayFiltres = null){
        
        
        // si vide: SELECT * FROM Livre 

        // si pas vide : SELECT * FROM Livre WHERE cle1 = :cle1 AND cle2 = :cle2 etc...
        // si pas vide : SELECT * FROM Livre WHERE prix = :prix AND titre = :titre etc...
        // $sql = "SELECT * FROM Livre WHERE ";

        // $chaineFiltres = "";
        // foreach ($arrayFiltres as $key => $value){
        //     $sql = $sql . $key . " = :" . $key . " AND "; 
        // }
        // var_dump ($sql);
        // var_dump (array_keys($arrayFiltres));

        // on rajoute de couples cle =:cle dans un array 
        $arrayFiltresChaine = [];
        foreach ($arrayFiltres as $cle => $valeur){
            $arrayFiltresChaine[] = $cle . " =:". $cle;
        }
        var_dump ($arrayFiltresChaine);
        // on crée un string contenant les couples séparées par AND
        $chaineFiltres = implode (" AND ", $arrayFiltresChaine);
        var_dump ($chaineFiltres);
        
        $sql = "SELECT * FROM Livre";
        if (!is_null ($arrayFiltres)) {
            $sql = $sql. " WHERE " . $chaineFiltres;
        }
        

    }

    // effacer un objet Livre
    public function delete (Livre $unLivre){
        $sql = "DELETE FROM livre WHERE id = :id";
        $stmt = $this->db->prepare ($sql);
        $stmt->bindValue (":id", $unLivre->getId());
        $stmt->execute();
        // var_dump ($stmt->errorInfo());
    }

    public function deleteParId ($id){
        $sql = "DELETE FROM livre WHERE id = :id";
        $stmt = $this->db->prepare ($sql);
        $stmt->bindValue (":id", $id);
        $stmt->execute();
        // var_dump ($stmt->errorInfo());
    }



    


}