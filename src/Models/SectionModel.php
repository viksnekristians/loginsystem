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

    public function getParentIds()
    {
        $sql = "select id, parent_id from ".self::TABLE_NAME;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $arr =[];
        foreach ($results as $row) {
	        $arr[(int)$row['id']]=(int)$row['parent_id'];
        }
        return $arr;
    }

    public function getChildNodes($nodes)
    {
        $sections = $this->getParentIds();
        foreach($sections as $sectionId => $parentId) {
            if (in_array($parentId, $nodes)) {
                if(!in_array($sectionId, $nodes))
                {
                    array_push($nodes, $sectionId);
                    $this->getChildNodes($nodes);
                }    
            }
        }
        return $nodes;
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
        $nodes = $this->getChildNodes([$id]);
        $str = implode(',', $nodes);
        $sql = "delete from ".self::TABLE_NAME." where id in (".$str.");";
        $stmt = $this->connect()->prepare($sql);
        if ($stmt->execute()) return true;
        return false;
    }

    public function editSection($id, $title, $description)
    {
        $sql = "update ".self::TABLE_NAME." set section_title =?, section_description=? where id=?";
        $stmt = $this->connect()->prepare($sql);
        if ($stmt->execute([$title, $description, $id])) return true;
        return false;
    }

    public function addSection($parentId, $title, $desc)
    {
        $sql = "insert into ".self::TABLE_NAME." (section_title, section_description, parent_id) values (?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        if($stmt->execute([$title, $desc, $parentId])) return true;
        return false;
    }
}