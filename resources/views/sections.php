<?php

buildTreeView($data, 0);

function buildTreeView($arr,$parent,$level = 0,$prelevel = -1){
        foreach($arr as $id=>$data){
            if($parent==$data['parent_id']){
                if($level>$prelevel){
                    echo "<ol>";
                }
                if($level==$prelevel){
                    echo "</li>";
                }
                echo "<li><div><h4>".$data['section_title']."</h4><form method='post' action='/edit'><button class='btn btn-primary mr-3' type='submit' name='edit' value=".$id.">Edit</button></form>
                <form method='post' action='/delete'><button class='btn btn-danger' type='submit' name='delete' value=".$id.">Delete</button></form>
                <form method='post' action='/add'><button class='btn btn-success' type='submit' name='add' value=".$id.">Add</button></form></div>";
                echo "<p>".$data['section_description']."</p>";
                if($level>$prelevel){
                    $prelevel=$level;
                }
                $level++;
                buildTreeView($arr,$id,$level,$prelevel);
                $level--;	
            }
        }
        if($level==$prelevel){
            echo "</li></ol>";
        }
    }