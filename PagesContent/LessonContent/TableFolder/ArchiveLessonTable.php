<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../../../CommonCode/ModifiedSearchStyle.php";?>

<!-- Confirmation modal -->
<?php include_once "../CommonLesson/ConfirmationModal.php";?>

<div class="row">
    <div class="box container">
        <div class="box-header">
            <br>
            <div class="row">
                <div class="col-xs-6">
                    <button id="activate_btn" type="button" class="btn btn-success" data-toggle="modal" data-target="">
                        <i class="fa fa-check-circle"></i> <span>Activate</span>
                    </button>
                </div>
                <div class="col-xs-6">
                    <div class="search-box">
                        <i class="fa fa-search"></i>
                        <input type="text" id="userInput" class="form-control" placeholder="Search..">
                    </div>
                </div>
            </div>

        </div>
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
                        $archessonTable = new LessonDisplayClass();
                        $archessonTable->archivedLessonTable();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
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


<!-- custom dropdown -->
<script>
$(function() {
    $('.custom-dropdown-menu a').click(function(e) {
        e.preventDefault();
        var categoryType = $(this).data('lesson-type');
        var contentPath = '';

        if (categoryType === 'active-lesson') {
            location.reload();
        } else if (categoryType === 'archive-lesson') {
            contentPath = '../PagesContent/LessonContent/TableFolder/ArchiveLessonTable.php';
        }
        $('.custom-dropdown-toggle').html($(this).text() + '<span class="caret"></span>');
        if (contentPath !== '') {
            $("#lesson-table").fadeOut(400, function() {
                $(this).load(contentPath, function() {
                    $(this).fadeIn(400);
                });
            });
        }
    });
});
</script>