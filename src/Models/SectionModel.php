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

    public function getSection($id)
    {
        $sql = "select section_title, section_description from ".self::TABLE_NAME." where id =?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $results = $stmt->fetchAll();
        return $results[0];
    }

    public function deleteSection($id)
    {

        $sql = "select * from ".self::TABLE_NAME." where parent_id=?";
        //$sql = "delete from ".self::TABLE_NAME." where";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
    }

    public function editSection($id, $title, $description)
    {
        $sql = "update ".self::TABLE_NAME." set section_title =?, section_description=? where id=?";
        $stmt = $this->connect()->prepare($sql);
        if ($stmt->execute([$title, $description, $id])) return true; else return false;
    }

    public function addSection($parentId, $title, $desc)
    {
        $sql = "insert into ".self::TABLE_NAME." (section_title, section_description, parent_id) values (?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        if($stmt->execute([$title, $desc, $parentId])) return true; else return false;
    }
}