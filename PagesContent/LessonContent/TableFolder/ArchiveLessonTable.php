<?php include_once "../../../CommonCode/ModifiedSearchStyle.php";?>

<!-- Confirmation modal -->
<?php include_once "../CommonLesson/ConfirmationModal.php";?>


<div class="row">
    <div class="col-xs-12">
        <div class="box box-default container">
            <div class="box-header with-border">
                <button id="activate_btn" type="button" class="btn btn-success" data-toggle="modal" data-target="">
                    <i class="fa fa-check-circle"></i> <span>Activate</span>
                </button>
                <div class="box-tools pull-right">
                    <div class="search-box" style="margin-right: 35px;">
                        <i class="fa fa-search"></i>
                        <input type="text" id="userInput" class="form-control" placeholder="Search..">
                    </div>
                </div>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <br>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th><input type='checkbox' id="select-all" class='checkbox'></th>
                                <th>Lesson ID</th>
                                <th>Lesson Description</th>
                                <th>Category Name</th>
                                <th>Module Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                        include_once("../../../Database/LessonDisplayClass.php");
                        $quiztable = new LessonDisplayClass();
                        $quiztable->archivedLessonTable();
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

<!-- activate script -->
<?php include_once "../LessonScript/ActivateScript.php"?>

</script>
<!-- Jquery for Table Search -->
<script>
$(document).ready(function() {
    $("#userInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("tbody tr").filter(function() {
            var rowText = $(this).text().toLowerCase();
            var pText = $(this).find("p").text().toLowerCase();
            $(this).toggle(rowText.indexOf(value) > -1 || pText.indexOf(value) > -1);
        });
    });
});
</script>