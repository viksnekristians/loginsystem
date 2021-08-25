<?php

declare(strict_types=1);

namespace App\Models;

use App\db\Database;


class SectionModel extends Database 
{

    const TABLE_NAME = "sections";

    public function getSections()
    {
        $sql = "select * from ".self::TABLE_NAME;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $arr =[];
        foreach ($results as $row) {
            $arr[(int)$row['id']]['section_title']=$row['section_title'];
            $arr[(int)$row['id']]['section_description']=$row['section_description'];
	        $arr[(int)$row['id']]['parent_id']=(int)$row['parent_id'];
        }

        //$this->buildTreeView($arr, 0);
        return $arr;

    }


    public function deleteSection($id)
    {
        
    }
}