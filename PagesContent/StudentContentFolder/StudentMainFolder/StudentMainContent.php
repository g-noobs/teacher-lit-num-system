
<!-- Add Student Modal -->
<?php include_once "../PagesContent/StudentContentFolder/ModalFolder/AddStudentModal.php"?>
<!-- Add student script -->
<?php include_once "../PagesContent/StudentContentFolder/StudentScriptFolder/AddStudentScript.php"?>

<!--Script below will be used for search -->
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

<div class="container">
    <!-- <h2>Dynamic Tabs</h2>
    <p>To make the tabs toggleable, add the response-toggle="tab" attribute to each link. Then add a .tab-pane class with a
        unique ID for every tab and wrap them inside a div element with class .tab-content.</p> -->

    <ul class="nav nav-tabs" id="dynamic-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
    </ul>

    <div class="tab-content" id="dynamic-content">
        <div id="home" class="tab-pane fade in active">
            <h3>HOME</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.</p>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $.ajax({
        url: '../PagesContent/StudentContentFolder/ActionStudent/ActionGetClassData.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Populate dynamic tabs
            var tabsContainer = $('#dynamic-tabs');
            var contentContainer = $('#dynamic-content');

            $.each(response, function(index, tab) {
                var tabId = 'tab' + tab.id;
                var tabContent = '<div id="' + tabId + '" class="tab-pane fade"></div>';

                var tabContentId = 'tabContent' + tab.id;
                var tabContent = `
                <div id="${tabId}" class="tab-pane fade">
                    <!-- Include the content dynamically -->
                    <div class="box box-default">
                    <div class="box-header with-border">
                        <br>
                        <div class="row">
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-primary add_stdnt_btn" data-class-id="${tab.id}">
                            <i class="fa fa-plus"></i> <span>Add Student</span>
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
                    <div class="box-body container-fluid" style="overflow-y: scroll; max-height: 400px;">
                        <!-- Include the content dynamically -->
                        <table id="${tabContentId}" class="table table-hover text-center">
                        <thead>
                            <tr>
                            <th><input type='checkbox' id="select-all" class='checkbox'></th>
                            <th colspan='2'></th>
                            <th>Student ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Acount Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        </table>
                    </div>
                    </div>
                </div>`;

                tabsContainer.append(
                    `<li><a data-toggle="tab" href="#${tabId}">${tab.name}</a></li>`);
                contentContainer.append(tabContent);
                $.ajax({
                    url: '../PagesContent/StudentContentFolder/ActionStudent/ActionDisplayTable.php', // Adjust the URL as per your backend logic
                    type: 'GET',
                    data: {
                        id: tab.id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.hasOwnProperty('success')) {
                            $('#' + tabContentId + ' tbody').html(response
                                .success);
                        } else if (response.hasOwnProperty('error')) {
                            $('#' + tabContentId + ' tbody').html(response
                                .error);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        $('#' + tabContentId + ' tbody').html(
                            '<tr><td colspan="7">Error loading content for ' +
                            tab.name + '</td></tr>');
                    }
                });
            });
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            alert('Error loading tabs.');
        }
    });
});
</script>



