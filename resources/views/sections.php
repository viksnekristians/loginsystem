<div class="container-lg mt-3">
    <div>
        <form  method='post' action='/add'><button class='btn btn-success' type='submit' name='add' value="0">Add</button></form>
    </div>
    <?php
    buildTreeView($data, 0);

    function buildTreeView($arr,$parent,$level = 0,$prelevel = -1){
        foreach($arr as $id=>$data){
            if($parent==$data['parent_id']){
                if($level>$prelevel){
                    echo "<ul>";
                }
                if($level==$prelevel){
                    echo "</li>";
                }
                echo "<li><div><h4 class='me-3' style='display:inline; vertical-align:middle;'>".$data['section_title']."</h4><form style='display:inline;' method='post' action='/edit'><button class='btn btn-primary mr-3' type='submit' name='edit' value=".$id.">Edit</button></form>
                <form style='display:inline;' method='post' action='/delete'><button class='btn btn-danger' type='submit' name='delete' value=".$id.">Delete</button></form>
                <form style='display:inline;' method='post' action='/add'><button class='btn btn-success' type='submit' name='add' value=".$id.">Add</button></form></div>";
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
            echo "</li></ul>";
        }
    }
    ?>
</div>