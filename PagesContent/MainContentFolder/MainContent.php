<style>
ul {
    list-style-type: none;
}
</style>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title" id="teacher_name_dashboard"></h3>
    </div>
    <div class="box-body" id="content_body">
        <div class="row container">
            <div class="col-xs-6">
                <h4>Assigned Class</h4>
                <ul id="assigned_class_list">
                    <?php 
                        include_once "../Database/DisplayStudentClass.php";
                        $assigned_clas = new DisplayStudentClass();
                        $assigned_clas->displayAssignedClassList($_SESSION['user_info_id']);
                    ?>
                </ul>
            </div>
            <div class="col-xs-6">
                <h4>Assigned Module</h4>
                <ul id="assigned_module_list">
                    <?php 
                        include_once "../Database/DisplayStudentClass.php";
                        $assigned_mod = new DisplayStudentClass();
                        $assigned_mod->displayAssignedModuleList($_SESSION['user_info_id']);
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>